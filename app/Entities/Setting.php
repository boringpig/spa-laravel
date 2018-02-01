<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Setting extends Model
{
    public $timestamps = false; 
    
    protected $fillable = [
        'customer_service_phone', 'customer_service_email', 'kiosk_freetime'
    ];
}
