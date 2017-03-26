<?php namespace Modules\Menu\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Menu\Support\DashboardMenu;

class DashboardMenuFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return DashboardMenu::class;
    }
}
