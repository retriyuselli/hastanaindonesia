<?php

namespace App\Providers;

use App\Models\EventParticipant;
use App\Observers\EventParticipantObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind();

        // Register EventParticipant Observer
        EventParticipant::observe(EventParticipantObserver::class);
    }
}
