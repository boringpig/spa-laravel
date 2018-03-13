<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['category_no', 'content', 'language', 'broadcast_area'];

    public function category()
    {
        return $this->belongsTo('App\Entities\Category', 'category_no', 'no'); // localField, foreignField
    }

    public function scopeAreaPermission($query)
    {
        $area_permission = empty(\Auth::user()->role->area_permission)? [] : \Auth::user()->role->area_permission;
        $query->whereIn('broadcast_area', $area_permission);
    }
}
