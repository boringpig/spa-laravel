<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Route;

class PageTitleComposer
{
    public function __construct()
    {
        //
    }

    public function compose(View $view)
    {
        $excludeView = ['emails.test'];
        
        if(in_array($view->getName(), $excludeView)) {
            $view->with('page_title', null);
        } else {
            $title = str_replace("/","",Route::current()->getPrefix());
            $lang = __("pageTitle.{$title}");
            if(preg_match("/^pageTitle/", __("pageTitle.{$title}"))) {
                $lang = __('pageTitle.system');
            }
            $view->with('page_title', $lang);
        }
    }
}