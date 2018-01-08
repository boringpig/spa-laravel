<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'content', 'language'];
}
