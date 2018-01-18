<?php

namespace App\CPS\Repositories;

use App\CPS\Entities\KioskStatus;

class KioskStatusRepository
{

    public function model()
    {
        return app(KioskStatus::class);
    }

    public function getAll($perPage = null)
    {
        return is_null($perPage)? $this->model()->get() : $this->model()->paginate($perPage);
    }
}