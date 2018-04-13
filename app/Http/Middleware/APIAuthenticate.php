<?php

namespace App\Http\Middleware;

use Closure;
use App\Repositories\KioskTokenRepository;
use App\Exceptions\InvalidTokenException;

class APIAuthenticate
{
    protected $kioskTokenRepository;

    public function __construct(
        KioskTokenRepository $kioskTokenRepository
    ) {
        $this->kioskTokenRepository = $kioskTokenRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // $request->bearerToken() 取得Bearer後面的token
        // 驗證表頭
        $header_token = $request->header('Authorization');
        $token = $request->token;
        if(!is_null($header_token)) {
            //判斷 Bearer
            preg_match('/^Bearer\s(.*)/',$header_token, $match);
            if(count($match) > 1) {
                $token = $match[1];
            } 
        }
        if(empty($token)) {
            throw new InvalidTokenException(__('auth.unauthenticated', ['message' => __('auth.lack_token_field')]));
        }
        // 驗證該token是否存在db 或 驗證token是否存在於即時產生token內
        if($this->kioskTokenRepository->findByToken($token) || 
           $this->kioskTokenRepository->validateToken($token)) {
            return $next($request);
        } 
        
        throw new \App\Exceptions\InvalidTokenException(__('auth.unauthenticated', ['message' => __('auth.invalid_token')]));
    }
}
