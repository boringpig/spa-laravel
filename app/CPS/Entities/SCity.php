<?php

namespace App\CPS\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class SCity extends Model
{
    protected $connection = 'mongo_cps';
    protected $collection = 's_city';

}
