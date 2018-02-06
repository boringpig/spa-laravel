<?php

namespace App\Repositories;

use App\Entities\Category;

class CategoryRepository extends Repository
{
    public function model()
    {
        return app(Category::class);
    }
}