<?php

namespace App\CPS\Repositories;

use App\CPS\Entities\Station;
use App\CPS\Entities\KioskStatus;

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
        $query = $this->model()->orderBy('s_no');

        return is_null($perPage)? $query->get() : $query->paginate($perPage);
    }

    /**
     * 取得有地區權限的資料
     *
     * @param string $perPage 分頁數量
     * @return Collection/Pagination
     */
    public function getAllWithPermission($perPage = null)
    {
        $query = $this->model()->areaPermission()->orderBy('s_no');

        return is_null($perPage)? $query->get() : $query->paginate($perPage);
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
        $kioskQuery = new KioskStatus();

        if(array_key_exists('county', $args) && !empty($args['county'])) {
            $condition['s_no'] = new \MongoDB\BSON\Regex("^01{$args['county']}");
        }

        if(array_key_exists('version', $args) && !empty($args['version'])) {
            $snos = $kioskQuery->where('kversion', $args['version'])->pluck('s_no')->toArray();
            $condition['s_no'] = ['$in' => $snos];
        }
        
        if(array_key_exists('sno', $args) && !empty($args['sno'])) {
            $condition['$or'][] = ['s_no' => new \MongoDB\BSON\Regex("{$args['sno']}")];
        }

        if(array_key_exists('sname', $args) && !empty($args['sname'])) {
            $condition['$or'][] = ['s_name.cn' => new \MongoDB\BSON\Regex("{$args['sname']}")];
        }

        if(array_key_exists('area', $args) && $args['area'] != '') {
            $condition['area_id'] = ['$eq' => (int) $args['area']];
        }
        
        $query = (count($condition) > 0)? $this->model()->areaPermission()->whereRaw($condition) : $this->model()->areaPermission();

        return is_null($perPage)? $query->orderBy('s_no')->get() : $query->orderBy('s_no')->paginate($perPage);
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
     * 取得全部資料的個數
     *
     * @return int
     */
    public function getAllTotal()
    {
        return $this->model()->count();
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
                    's_no' => ['$regex' => new \MongoDB\BSON\Regex("^010")],
                ]
            ],
            [
                '$project' => [
                    'county' => ['$substr' => ['$s_no', 2, 2]],
                ]
            ],
            [
                '$group' => [
                    '_id' => ['county' => '$county'],
                    'county' => ['$first' => '$county'],
                    'count' => ['$sum' => 1],
                ]
            ],
            [
                '$sort' => ['county' => 1]
            ]
        ];
        return $this->model()->raw(function($collection) use ($pipeline) {
            return $collection->aggregate($pipeline);
        });
    }
}