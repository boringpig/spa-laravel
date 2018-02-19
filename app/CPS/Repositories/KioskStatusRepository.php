<?php

namespace App\CPS\Repositories;

use App\CPS\Entities\KioskStatus;

class KioskStatusRepository
{

    public function model()
    {
        return app(KioskStatus::class);
    }

    /**
     * 取得全部的場站的 kiosk 狀態
     *
     * @param string $perPage 分頁數量
     * @return Collection/Pagination
     */
    public function getAll($perPage = null)
    {
        return is_null($perPage)? $this->model()->get() : $this->model()->paginate($perPage);
    }
}