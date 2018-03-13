<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class AreaGroup extends Model
{
    public $timestamps = false; 
    
    protected $fillable = [
        'parent_area', 'child_area'
    ];

    public function scopeAreaPermission($query)
    {
        $area_permission = empty(\Auth::user()->role->area_permission)? [] : \Auth::user()->role->area_permission;
        $query->whereIn('parent_area', $area_permission);
    }
}
