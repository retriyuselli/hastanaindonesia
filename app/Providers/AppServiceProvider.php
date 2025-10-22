<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\EventParticipant;
use App\Observers\EventParticipantObserver;

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
        // Register EventParticipant Observer
        EventParticipant::observe(EventParticipantObserver::class);
    }
}
