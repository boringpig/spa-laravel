<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class AreaGroup extends Model
{
    public $timestamps = false; 
    
    protected $fillable = [
        'parent_area', 'child_area'
    ];
}
