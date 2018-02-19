<?php

namespace App\CPS\Repositories;

use App\CPS\Entities\Station;

class StationRepository
{

    public function model()
    {
        return app(Station::class);
    }

    /**
     * 取得全部的場站
     *
     * @param string $perPage 分頁數量
     * @return Collection/Pagination
     */
    public function getAll($perPage = null)
    {
        return is_null($perPage)? $this->model()->get() : $this->model()->paginate($perPage);
    }

    /**
     * 根據搜尋參數回傳符合條件的場站
     *
     * @param array $args 搜尋參數
     * @param string $perPage 分頁數量
     * @return Collection/Pagination
     */
    public function getByArgs($args, $perPage = null)
    {
        $condition = [];

        if(array_key_exists('station', $args) && !empty($args['station'])) {
            $condition['s_no'] = new \MongoDB\BSON\Regex("^{$args['station']}");
        }

        if(array_key_exists('area', $args) && $args['area'] != '') {
            $condition['area_id'] = ['$eq' => (int) $args['area']];
        }

        $query = (count($condition) > 0)? $this->model()->whereRaw($condition) : $this->model();

        return is_null($perPage)? $query->get() : $query->paginate($perPage);
    }

    /**
     * 根據場站代號回傳單一場站資料
     *
     * @param string $station 場站代號
     * @return Station
     */
    public function findOneByStation($station)
    {
        return $this->model()->where('s_no', $station)->first();
    }

    /**
     * 計算泉州各地區的場站數量
     *
     * @return Array
     */
    public function getTotalCount()
    {
        $pipeline = [
            [
                '$match' => [
                    's_no' => ['$regex' => new \MongoDB\BSON\Regex("^0101")],
                    'area_id' => ['$exists' => true]
                ]
            ],
            [
                '$project' => [
                    'area' => '$area_id',
                ]
            ],
            [
                '$group' => [
                    '_id' => ['area' => '$area'],
                    'area' => ['$first' => '$area'],
                    'count' => ['$sum' => 1],
                ]
            ]
        ];
        return $this->model()->raw(function($collection) use ($pipeline) {
            return $collection->aggregate($pipeline);
        })->toArray();
    }
}