<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Kiosk extends Model
{
    protected $fillable = [
        'station_name', 'station_number', 'station_ip', 'station_area', 'identification', 'version',
        'temperatureinsidebox', 'temperatureoutsidebox', 'humidityinsidebox', 'humidityoutsidebox',
        'touch', 'camera', 'easycard'
    ];
}
