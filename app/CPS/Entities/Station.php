<?php

namespace App\CPS\Entities;

use Jenssegers\Mongodb\Eloquent\Model;
use App\Scopes\QuanzhouScope;

class Station extends Model
{
    protected $connection = 'mongo_cps';
    protected $collection = 'station';

    protected static function boot()
    {
        parent::boot();
        
        static::addGlobalScope(new QuanzhouScope);
    }
}
