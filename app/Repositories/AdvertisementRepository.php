<?php

namespace App\Repositories;

use App\Entities\Advertisement;

class AdvertisementRepository extends Repository
{
    public function model()
    {
        return app(Advertisement::class);
    }

    public function tag()
    {
        return 'advertisement';
    }

    /**
     * 根據搜尋參數回傳符合條件的廣告
     *
     * @param string $queryString 搜尋字串用來當作快取的key值
     * @param array $args 搜尋參數
     * @param string $perPage 分頁數量
     * @return Collection/Pagination
     */
    public function getByArgs($queryString = '', $args, $perPage = null)
    {
        $condition = [];

        foreach(['status', 'round_time'] as $field) {
            if(array_key_exists($field, $args) && $args[$field] != '') {
                $condition[$field] = ['$eq' => (int) $args[$field]];
            }    
        }

        if(array_key_exists('name', $args) && $args['name'] != '') {
            $condition['name'] = ['$eq' => $args['name']];
        }

        if(array_key_exists('s_city', $args) && !empty($args['s_city'])) {
            $condition['broadcast_area'] = ['$in' => [$args['s_city']]];
        }

        $query = (count($condition) > 0)? $this->model()->whereRaw($condition)->orderBy('created_at','desc') : $this->model()->orderBy('created_at','desc');

        return is_null($perPage)? $query->get() : $query->paginate($perPage);
    }

    /**
     * 回傳特定地區權限的搜尋資料
     *
     * @param array $args 搜尋參數
     * @param string $perPage 分頁
     * @return collection
     */
    public function getByArgsWithPermission($args, $perPage = null)
    {
        $condition = [];

        foreach(['status', 'round_time'] as $field) {
            if(array_key_exists($field, $args) && $args[$field] != '') {
                $condition[$field] = ['$eq' => (int) $args[$field]];
            }    
        }

        if(array_key_exists('name', $args) && $args['name'] != '') {
            $condition['name'] = ['$eq' => $args['name']];
        }

        if(array_key_exists('s_city', $args) && !empty($args['s_city'])) {
            $condition['broadcast_area'] = ['$in' => [$args['s_city']]];
        }

        if(array_key_exists('updated_at', $args) && !empty($args['updated_at'])) {
            $condition['updated_at'] = ['$gte' => new \MongoDB\BSON\UTCDateTime(strtotime("{$args['updated_at']} 00:00:00") * 1000),
                                        '$lte' => new \MongoDB\BSON\UTCDateTime(strtotime("{$args['updated_at']} 23:59:59") * 1000)];
        }

        return cache()->tags($this->tag())->remember($this->tag().".{$queryString}", 60, function() use ($perPage,$condition) {
            $query = (count($condition) > 0)? $this->model()->areaPermission()->whereRaw($condition)->orderBy('created_at','desc') : $this->model()->areaPermission()->orderBy('created_at','desc');
            return is_null($perPage)? $query->get() : $query->paginate($perPage);
        });
    }

    /**
     * 將預發佈的廣告更改為啟動狀態
     *
     * @param string $date 發佈日期
     * @return boolean
     */
    public function enableStatusAtSpecificDate($date)
    {
        $condition = [
            'publish_at' => [
                '$gte' => new \MongoDB\BSON\UTCDateTime(strtotime("{$date} 00:00:00") * 1000),
                '$lte' => new \MongoDB\BSON\UTCDateTime(strtotime("{$date} 23:59:59") * 1000),
            ]
        ];
        $result = true;
        $count = $this->model()->whereRaw($condition)->count();
        if($count) {
            $result = $this->model()->whereRaw($condition)
                           ->update(['status' => 1], ['upsert' => true, 'multi' => true]);
        }
        return $result;
    }
}