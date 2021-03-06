<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\ForbiddenException;

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
        // 轉換 create、edit 的路由名稱
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
        // 檢查目前的路由是否為該角色可存取的權限
        if(is_null(Auth::user()->role) || (str_contains($route_name, '.') 
            && ! in_array($route_name, Auth::user()->role->permission))) {
            throw new ForbiddenException;
        }

        return $next($request);
    }
}
