<?php

namespace App\CPS\Repositories;

use App\CPS\Entities\SCityArea;

class SCityAreaRepository
{

    public function model()
    {
        return app(SCityArea::class);
    }

    public function getAll($perPage = null)
    {
        return is_null($perPage)? $this->model()->get() : $this->model()->paginate($perPage);
    }
}