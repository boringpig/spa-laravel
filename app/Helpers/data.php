<?php

if (!function_exists('getSCityAreaArray')) {
    function getSCityAreaArray() 
    {
        return \App\CPS\Entities\SCityArea::get()->pluck('s_area.cn', 'area_id')->toArray();
    }
}

if (!function_exists('getRoleNameArray')) {
    function getRoleNameArray() 
    {
        return \App\Entities\Role::get()->pluck('name', 'id')->toArray();
    }
}