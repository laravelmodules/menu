<?php namespace Modules\Menu\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Menu\Support\BackendMenu;

class BackendMenuFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return BackendMenu::class;
    }
}
