<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\EventParticipant;
use App\Models\HomeHeroImage;
use App\Observers\EventParticipantObserver;
use App\Observers\HomeHeroImageObserver;
use App\Support\RichTextSanitizer;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(RichTextSanitizer::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind();

        LogViewer::auth(static fn ($request): bool => $request->user()?->hasRole(
            config('filament-shield.super_admin.name', 'super_admin'),
        ) === true);

        Gate::define('deleteLogFile', static fn (): bool => false);
        Gate::define('deleteLogFolder', static fn (): bool => false);

        Blade::directive('sanitize', static function (string $expression): string {
            return "<?php echo app(\\App\\Support\\RichTextSanitizer::class)->sanitize({$expression}); ?>";
        });

        View::composer('layouts.header', static function ($view): void {
            $view->with(
                'headerCompany',
                Company::query()->orderBy('id')->first(['company_name', 'logo_url']),
            );
        });

        // Register EventParticipant Observer
        EventParticipant::observe(EventParticipantObserver::class);
        HomeHeroImage::observe(HomeHeroImageObserver::class);
    }
}
