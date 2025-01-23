<?php

namespace App\Providers;

use App\Models\Consoler;
use App\Observers\ConsolerObserver;
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
    public function boot()
    {
//        Consoler::observe(ConsolerObserver::class);
    }

}
