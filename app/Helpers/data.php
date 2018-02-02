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

if (!function_exists('getSCityArray')) {
    function getSCityArray() 
    {
        $scity = \App\CPS\Entities\SCity::orderBy('province','asc')->orderBy('country_id','asc')->get()->toArray();
        return collect($scity)->map(function($item) {
                    preg_match("/^(.*)\(/",$item['province_cn'],$match);
                    return [
                        "{$item['province']}{$item['country_id']}"   => "{$match[1]}{$item['city_cn']}"
                    ];
                })->collapse()->toArray();
    }
}