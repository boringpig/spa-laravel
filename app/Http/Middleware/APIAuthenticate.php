<?php

namespace App\Http\Middleware;

use Closure;
use App\Repositories\KioskTokenRepository;

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
        try {
            if(empty($request->token)) {
                throw new \Exception(__('auth.unauthenticated', ['message' => __('auth.lack_token_field')]));
            }
            // 驗證該token是否存在db
            if($this->kioskTokenRepository->findByToken($request->token)) {
                return $next($request);
            }
            // 驗證token是否存在於即時產生token內
            if($this->kioskTokenRepository->validateToken($request->token)) {
                return $next($request);
            }
            // 都不符合則出現授權失敗
            throw new \Exception(__('auth.unauthenticated', ['message' => __('auth.invalid_token')]));
        } catch (\Exception $e) {
            return response()->json(errorOutput($e->getMessage()), 500);
        }
    }
}
