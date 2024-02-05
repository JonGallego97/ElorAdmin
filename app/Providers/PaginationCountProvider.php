<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PaginationCountProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $paginationCount = 50;

        $this->app->singleton('paginationCount', function () use ($paginationCount) {
            return $paginationCount;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
