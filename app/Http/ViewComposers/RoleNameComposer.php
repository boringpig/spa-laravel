<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class RoleNameComposer
{

    public function __construct()
    {
        //
    }

    public function compose(View $view)
    {
        $view->with('roles', getRoleNameArray());
    }
}