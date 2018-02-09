<?php

namespace App\Http\Middleware;

use Closure;
use App\Repositories\KioskTokenRepository;
use App\Exceptions\MissingFieldException;

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
        if(empty($request->token)) {
            throw new MissingFieldException(__('auth.unauthenticated', ['message' => __('auth.lack_token_field')]));
        }
        // 驗證該token是否存在db 或 驗證token是否存在於即時產生token內
        if($this->kioskTokenRepository->findByToken($request->token) || 
           $this->kioskTokenRepository->validateToken($request->token)) {
            return $next($request);
        } else {
            return response()->json(errorOutput(__('auth.unauthenticated', ['message' => __('auth.invalid_token')])), 403);
        }
    }
}
