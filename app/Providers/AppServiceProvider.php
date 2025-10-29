<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\View\Composers\UserComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // You may bind interfaces to implementations here.
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share user data across all views efficiently
        View::composer('*', UserComposer::class);
    }
}


