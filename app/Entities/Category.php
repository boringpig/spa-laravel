<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['no', 'name'];

    public function articles()
    {
        return $this->hasMany('App\Entities\Article', 'category_no', 'no');  // foreignField, localField
    }
}
