<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Lang;

class RouteAuthority
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $route_name = $request->route()->getName();
        // 轉化 create、edit 的路由名稱
        if(str_contains($route_name, '.')) {
            $menu = explode('.', $route_name)[0];
            $button = explode('.', $route_name)[1];
            switch($button) {
                case 'create':
                    $button = 'store';
                    break;
                case 'edit':
                    $button = 'update';
                    break;
            }
            $route_name = "{$menu}.{$button}";
        }

        if(is_null(Auth::user()->role) || (str_contains($route_name, '.') 
            && ! in_array($route_name, Auth::user()->role->permission))) {
            abort(403);
        }

        return $next($request);
    }
}
