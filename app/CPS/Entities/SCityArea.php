<?php

namespace App\CPS\Entities;

use Jenssegers\Mongodb\Eloquent\Model;
use App\Scopes\QuanzhouScope;

class SCityArea extends Model
{
    protected $connection = 'mongo_cps';
    protected $collection = 's_city_area';

    protected static function boot()
    {
        parent::boot();
        
        static::addGlobalScope(new QuanzhouScope);
    }
}
