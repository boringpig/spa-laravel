<?php

namespace App\CPS\Repositories;

use App\CPS\Entities\SCity;

class SCityRepository
{

    public function model()
    {
        return app(SCity::class);
    }

    /**
     * 取得全部的縣市別
     *
     * @param string $perPage 分頁數量
     * @return Collection/Pagination
     */
    public function getAll($perPage = null)
    {
        $query = $this->model()->orderBy('province','asc')->orderBy('country_id','asc');

        return is_null($perPage)? $query->get() : $query->paginate($perPage);
    }

    /**
     * 根據搜尋參數回傳符合條件的縣市別
     *
     * @param array $args 搜尋參數
     * @param string $perPage 分頁數量
     * @return Collection/Pagination
     */
    public function getByArgs($args, $perPage = null)
    {
        $condition = [];

        if(array_key_exists('s_city', $args) && !empty($args['s_city'])) {
            $condition['province'] = ['$eq' => substr($args['s_city'],0,2)];
            $condition['country_id'] = ['$eq' => substr($args['s_city'],2,2)];
        }
        
        $query = (count($condition) > 0)? $this->model()->whereRaw($condition)->orderBy('parent_area','asc') : $this->model()->orderBy('parent_area','asc');

        return is_null($perPage)? $query->get() : $query->paginate($perPage);
    }
}