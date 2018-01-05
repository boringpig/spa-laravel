<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'permission'];

    public function users()
    {
        return $this->hasMany('App\User', 'role_id', '_id');
    }
}
