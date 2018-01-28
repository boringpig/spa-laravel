<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'permission'];

    public function users()
    {
        return $this->hasMany('App\User', 'role_id', '_id');
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($role) {
            $role->users->each(function($user) {
                $user->role_id = "";
                $user->save();
            });
        });
    }
}
