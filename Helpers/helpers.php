<?php

if (! function_exists('menu_config')) {
    /**
     * Get / set the specified configuration value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param  array|string  $key
     * @param  mixed  $default
     * @return mixed
     */
     function menu_config($key = null, $default = null)
     {
         return config('module.menu.'.$key, $default);
     }
}

if (!function_exists('backend_menu_render')) {
    /**
     * @param $dir
     */
    function backend_menu_render()
    {
        return \BackendMenu::render();
    }
}

if (!function_exists('dashboard_menu_render')) {
    /**
     * @param $dir
     */
    function dashboard_menu_render()
    {
        return \DashboardMenu::render();
    }
}
