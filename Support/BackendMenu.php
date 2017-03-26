<?php namespace Modules\Menu\Support;

use Illuminate\Support\Collection;
use Auth;

use Modules\Menu\Support\MenuTrait;

class BackendMenu
{
    use MenuTrait;

    /**
     * @return string
     */
    public function render()
    {
        $links = $this->rearrangeLinks();
        return view('menu::menu.menu', [
            'isChildren' => false,
            'links' => $links,
            'level' => 0,
            'active' => $this->active,
            'loggedInUser' => $this->loggedInUser
        ])->render();
    }
}
