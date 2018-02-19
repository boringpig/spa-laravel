<?php

namespace App\Http\Middleware;

use Closure;
use App\Repositories\ActionlogRepository;
use Illuminate\Support\Facades\Auth;

class RecordActionlog
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
        return $next($request);
    }

    /**
     * 儲存 response 的操作記錄
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function terminate($request, $response)
    {
        $route_name = $request->route()->getName();
        if(str_contains($route_name, '.')) {
            list($menu,$button) = explode('.', $route_name);
            if(array_key_exists($menu, config('menu')) && 
               array_key_exists($button, config('actionlog')) &&
               Auth::check()
            ) {
                cache()->tags('actionlog')->flush();
                $actionlogRepository = new ActionlogRepository();
                $actionlog = $actionlogRepository->create([
                    'user_id'         => Auth::id(),
                    'user_objectid'   => new \MongoDB\BSON\ObjectID(Auth::id()),
                    'menu'            => $menu,
                    'button'          => $button,
                ]);
                // Auth::user()->actionlogs()->save($actionlog);
            }
        }
    }
}
