<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'content', 'language', 'broadcast_area'];
}
