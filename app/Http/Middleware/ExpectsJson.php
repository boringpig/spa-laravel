<?php

namespace App\Http\Middleware;

use Closure;

class ExpectsJson
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
        if ($request->expectsJson()) {
            return $next($request);
        }

        throw new \App\Exceptions\ExpectsJsonException(__('message.request_must_json'));
    }
}
