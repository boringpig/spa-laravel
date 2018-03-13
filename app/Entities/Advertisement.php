<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Advertisement extends Model
{
    protected $fillable = [
        'name', 'format', 'path', 'round_time', 'broadcast_area', 'broadcast_time', 'status', 'weeks', 'publish_at'
    ];

    protected $dates = ['publish_at'];

    public function scopeAreaPermission($query)
    {
        $area_permission = empty(\Auth::user()->role->area_permission)? [] : \Auth::user()->role->area_permission;
        $query->whereIn('broadcast_area', $area_permission);
    }
}
