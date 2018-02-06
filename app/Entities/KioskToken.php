<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class KioskToken extends Model
{
    public $timestamps = false; 
        
    protected $fillable = [
        'station_no', 'token'
    ];
}
