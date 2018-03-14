<?php

namespace App\Http\Middleware;

use Closure;

class ApiLogger
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

    public function terminate($request, $response)
    {
        $start_time = date('Y-m-d H:i:s', LARAVEL_START);
        $end_time = date('Y-m-d H:i:s');
        if($response instanceof \Illuminate\Http\JsonResponse) {
            $form_data = json_encode($request->all(), JSON_UNESCAPED_UNICODE);
            $response_data = json_encode($response->getData(true), JSON_UNESCAPED_UNICODE);
            $content = "[{$start_time}] [{$request->ip()}] [{$request->route()->getAction('uses')}] [{$form_data}]\n";
            $content .= "[{$end_time}] [{$request->ip()}] [{$request->route()->getAction('uses')}] [{$response_data}]\n";
            file_put_contents(storage_path('logs/apilog.log'), $content, FILE_APPEND);
        }
    }
}