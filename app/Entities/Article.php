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
}
