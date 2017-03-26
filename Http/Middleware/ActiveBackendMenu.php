<?php

namespace Modules\Menu\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use BackendMenu;

class ActiveBackendMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $items = BackendMenu::all();
        $currentRoute = $request->url();
        $activeItems = $items->where('link',$currentRoute)->all();
        if (count($activeItems) > 0) {
            foreach ($activeItems as $key => $value) {
                BackendMenu::setActiveItem($value['id']);
            }
        }
        return $next($request);
    }
}
