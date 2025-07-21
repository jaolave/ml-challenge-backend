<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ResourceValidationService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ResourceValidationService::class, function ($app) {
            return new ResourceValidationService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
