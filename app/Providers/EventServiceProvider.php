<?php

namespace App\Providers;

use App\Models\Candidate;
use App\Observers\CandidateObserver;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register the CandidateObserver
        Candidate::observe(CandidateObserver::class);
    }
}
