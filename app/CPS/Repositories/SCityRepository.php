<?php

namespace App\CPS\Repositories;

use App\CPS\Entities\SCity;

class SCityRepository
{

    public function model()
    {
        return app(SCity::class);
    }

    public function getAll($perPage = null)
    {
        $query = $this->model()->orderBy('province','asc')->orderBy('country_id','asc');

        return is_null($perPage)? $query->get() : $query->paginate($perPage);
    }
}