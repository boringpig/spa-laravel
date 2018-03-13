<?php

namespace App\CPS\Entities;

use Jenssegers\Mongodb\Eloquent\Model;
use App\Scopes\QuanzhouScope;

class KioskStatus extends Model
{
    protected $connection = 'mongo_cps';
    protected $collection = 'kiosk_status';
}
