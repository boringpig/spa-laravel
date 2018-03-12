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

    public function getByArgs($args, $perPage = null)
    {
        $condition = [];

        if(array_key_exists('province', $args) && !empty($args['province'])) {
            $condition['province'] = ['$eq' => $args['province']];
        }

        if(array_key_exists('county', $args) && !empty($args['county'])) {
            $condition['country_id'] = ['$eq' => $args['county']];
        }

        $query = (count($condition) > 0)? $this->model()->whereRaw($condition)->orderBy('country_id')->orderBy('area_id') : $this->model()->orderBy('country_id')->orderBy('area_id');

        return is_null($perPage)? $query->get() : $query->paginate($perPage);
    }
}