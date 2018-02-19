<?php

namespace App\CPS\Repositories;

use App\CPS\Entities\SCityArea;

class SCityAreaRepository
{

    public function model()
    {
        return app(SCityArea::class);
    }

    /**
     * 取得全部的縣市別地區
     *
     * @param string $perPage 分頁數量
     * @return Collection/Pagination
     */
    public function getAll($perPage = null)
    {
        return is_null($perPage)? $this->model()->get() : $this->model()->paginate($perPage);
    }
}