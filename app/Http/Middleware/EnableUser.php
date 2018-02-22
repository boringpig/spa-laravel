<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Repositories\UserRepository;

class EnableUser
{
    protected $userRepository;

    public function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
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
        // 登入時驗證該帳號的狀態是否啟用
        if($request->path() == 'login' && $request->has('username')) {
            $user = $this->userRepository->findByUsername($request->username);
            if(!is_null($user) && !$user->status) {
                session()->flash('error', __('message.member_has_been_disabled'));
                return redirect('/login');
            }
        }
        // 目前為登入後的使用者，驗證該帳號的狀態是否啟用(有可能使用到一半被禁用)
        if(Auth::check() && !Auth::user()->status) {
            Auth::logout();
            session()->flash('error', __('message.member_has_been_disabled'));
            return redirect('/login');
        }
        return $next($request);
    }
}
