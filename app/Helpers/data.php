<?php

if (!function_exists('getSCityAreaArray')) {
    function getSCityAreaArray() 
    {
        return \App\CPS\Entities\SCityArea::get()->pluck('s_area.cn', 'area_id')->toArray();
    }
}