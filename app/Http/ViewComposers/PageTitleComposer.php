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
        
        // 略過不需要傳遞變數的 blade 頁面
        if(in_array($view->getName(), $excludeView)) {
            $view->with('page_title', null);
        } else {
            // 根據路由的 prefix 名稱，傳遞該語系的頁面標題
            $title = str_replace("/","",Route::current()->getPrefix());
            $lang = __("pageTitle.{$title}");
            if(preg_match("/^pageTitle/", __("pageTitle.{$title}"))) {
                $lang = __('pageTitle.system');
            }
            $view->with('page_title', $lang);
        }
    }
}