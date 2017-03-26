<?php

namespace Modules\Menu\Providers;

use Illuminate\Support\ServiceProvider;

use Modules\Menu\Console\MenuItemCommand;
use Modules\Menu\Console\MenuItemListCommand;

use Amamarul\Modules\Json;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();

        if ($this->app->runningInConsole()) {
            $this->commands([
                MenuItemCommand::class,
                MenuItemListCommand::class,
            ]);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(SidebarServiceProvider::class);
        $this->app->register(BreadcrumbsServiceProvider::class);

        $this->menuFacades();
    }

    public function menuFacades()
    {
        //Register Menu facades
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $menuNamespace = '\\Modules\\Menu\\Facades\\';
        $menuSupportPath = $this->app->modules->get('Menu')->getPath().'/Support';
        $menus = new Json ($menuSupportPath.'/menu.json');
        foreach ($menus->getAttributes() as $key => $value) {
            $loader->alias($key, $menuNamespace.$value);
        }
    }
    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('module/menu/menu.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'module.menu.menu'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/menu');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/menu';
        }, \Config::get('view.paths')), [$sourcePath]), 'menu');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/menu');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'menu');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'menu');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
