<?php

namespace Modules\Menu\Providers;

use Illuminate\Support\ServiceProvider;

class BreadcrumbsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->booted(function () {
            $this->booted();
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Register Backend Breadcrumbs (admin)
         */
        require __DIR__ .'/../Breadcrumbs/backend.php';
        /**
         * Register Dashboard Breadcrumbs (dashboard)
         */
        require __DIR__ .'/../Breadcrumbs/dashboard.php';
    }

    private function booted()
    {
        //
    }
}
