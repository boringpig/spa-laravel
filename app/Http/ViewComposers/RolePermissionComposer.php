<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class RolePermissionComposer
{
    private $permission;
    private $role_button = [];
    private $role_menu = [];

    public function __construct()
    {
        // 目前使用者角色的存取權限
        $this->permission = empty(Auth::user()->role)? [] : Auth::user()->role->permission;
    }

    public function compose(View $view)
    {
        $excludedViews = ['emails.test'];

        // 略過不需要傳遞變數的 blade 頁面
        if(in_array($view->getName(), $excludedViews)) {
            $view->with('role_button', $this->role_button);
            $view->with('role_menu', $this->role_menu);
        } else {
            // 根據目前的路由名稱去過濾目前使用者的存取的操作權限(CRUD的按鈕)
            if(array_key_exists('as', Route::current()->action) && str_contains(Route::current()->getName(), '.')) {
                $menu = explode('.', Route::current()->getName())[0];
                $this->role_button = collect($this->permission)->filter(function($value) use ($menu) {
                    return preg_match("/^{$menu}/", $value);
                })->map(function($value) {
                    return explode('.', $value)[1];
                })->values()->toArray();
            }
            // 根據目前的路由名稱去過濾目前使用者的左側選單顯示權限(只有要 xxx.index 列表權限)
            $this->role_menu = collect($this->permission)->filter(function($value) {
                return preg_match("/.index$/", $value);
            })->map(function($value) {
                return explode('.', $value)[0];
            })->unique()->values()->toArray();
            $view->with('role_button', $this->role_button);
            $view->with('role_menu', $this->role_menu);
        }
    }
}