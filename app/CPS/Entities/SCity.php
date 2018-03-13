<?php

namespace App\CPS\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class SCity extends Model
{
    protected $connection = 'mongo_cps';
    protected $collection = 's_city';

    public function scopeAreaPermission($query)
    {
        $areas = \Auth::user()->role->area_permission;
        if(!empty($areas)) {
            foreach($areas as $area) {
                $query->orWhere(function($q) use ($area) {
                    list($province, $county) = str_split($area,2);
                    $q->where('province', $province)->where('country_id',$county);
                });
            }
        } else {
            $query->whereNull('province');
        }        
    }
}
