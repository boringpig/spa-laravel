<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Actionlog extends Model
{
    protected $fillable = [
        'user_objectid','user_id', 'action', 'menu', 'button',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
