<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class HomeController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'page_title' => Lang::get('pageTitle.dashboard'),
        ]);
    }
}
