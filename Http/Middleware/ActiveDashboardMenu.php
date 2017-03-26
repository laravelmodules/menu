<?php

namespace Modules\Menu\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use DashboardMenu;

class ActiveDashboardMenu
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
        $items = DashboardMenu::all();
        $currentRoute = $request->url();
        $activeItems = $items->where('link',$currentRoute)->all();
        if (count($activeItems) > 0) {
            foreach ($activeItems as $key => $value) {
                DashboardMenu::setActiveItem($value['id']);
            }
        }
        return $next($request);
    }
}
