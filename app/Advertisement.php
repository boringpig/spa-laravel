<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Advertisement extends Model
{
    protected $fillable = [
        'name', 'format', 'sequence', 'path', 'round_time', 'broadcast_time', 'status', 'weeks', 'publish_at'
    ];

    protected $dates = ['publish_at'];
}
