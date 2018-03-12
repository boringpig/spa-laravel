<?php

namespace App\CPS\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class SCityArea extends Model
{
    protected $connection = 'mongo_cps';
    protected $collection = 's_city_area';
}
