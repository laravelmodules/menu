<?php

namespace Modules\Menu\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The root namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $rootUrlNamespace = 'Modules\Menu\Http\Controllers';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     *
     * @param  Router $router
     * @return void
     */
    public function before(Router $router)
    {
        //
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map(Router $router)
    {
        $router->aliasMiddleware('backend-menu', \Modules\Menu\Http\Middleware\ActiveBackendMenu::class);
        $router->aliasMiddleware('dashboard-menu', \Modules\Menu\Http\Middleware\ActiveDashboardMenu::class);

        $router->pushMiddlewareToGroup('admin', 'backend-menu');
        $router->pushMiddlewareToGroup('dashboard', 'dashboard-menu');
        
        if (!app()->routesAreCached()) {
            /**
            * Web Routes
            */
            $router->group(['middleware' => 'web', 'namespace' => $this->rootUrlNamespace, 'module' => 'menu'], function()
            {
                require __DIR__ . '/../routes/web.php';
            });
            /**
            * Api Routes
            */
            $router->group(['middleware' => 'api', 'namespace' => $this->rootUrlNamespace,'prefix' => 'api', 'module' => 'menu'], function()
            {
                require __DIR__ . '/../routes/api.php';
            });
        }
    }
}
