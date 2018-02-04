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
        $this->permission = empty(Auth::user()->role)? [] : Auth::user()->role->permission;
    }

    public function compose(View $view)
    {
        if(str_contains(Route::current()->getName(), '.')) {
            $menu = explode('.', Route::current()->getName())[0];
            $this->role_button = collect($this->permission)->filter(function($value) use ($menu) {
                return preg_match("/^{$menu}/", $value);
            })->map(function($value) {
                return explode('.', $value)[1];
            })->values()->toArray();
        }
        
        $this->role_menu = collect($this->permission)->filter(function($value) {
            return preg_match("/.index$/", $value);
        })->map(function($value) {
            return explode('.', $value)[0];
        })->unique()->values()->toArray();
        $view->with('role_button', $this->role_button);
        $view->with('role_menu', $this->role_menu);
    }
}