<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable =[
        'command', 'description', 'frequence', 'runtime', 'error'
    ];

    protected $dates = ['runtime'];
}
