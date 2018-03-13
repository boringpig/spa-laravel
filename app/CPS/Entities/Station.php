<?php

namespace App\CPS\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Station extends Model
{
    protected $connection = 'mongo_cps';
    protected $collection = 'station';

    public function scopeAreaPermission($query)
    {
        $areas = \Auth::user()->role->area_permission;
        if(!empty($areas)) {
            foreach($areas as $area) {
                $query->orWhere('s_no', 'regex', new \MongoDB\BSON\Regex("^{$area}"));
            }
        } else {
            $query->whereNull('s_no');
        }
    }
}
