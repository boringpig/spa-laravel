<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Advertisement extends Model
{
    protected $fillable = [
        'name', 'format', 'path', 'round_time', 'broadcast_area', 'broadcast_time', 'status', 'weeks', 'publish_at'
    ];

    protected $dates = ['publish_at'];
}
