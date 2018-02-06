<?php

namespace App\Repositories;

use App\Entities\Advertisement;

class AdvertisementRepository extends Repository
{

    public function model()
    {
        return app(Advertisement::class);
    }

    /**
     * 根據搜尋參數回傳符合條件的使用者
     */
    public function getByArgs($args, $perPage = null)
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

        if(array_key_exists('publish_at', $args) && !empty($args['publish_at'])) {
            $condition['publish_at'] = ['$gte' => new \MongoDB\BSON\UTCDateTime(strtotime("{$args['publish_at']} 00:00:00") * 1000),
                                        '$lte' => new \MongoDB\BSON\UTCDateTime(strtotime("{$args['publish_at']} 23:59:59") * 1000)];
        }

        $query = (count($condition) > 0)? $this->model()->whereRaw($condition)->orderBy('created_at','desc') : $this->model()->orderBy('created_at','desc');

        return is_null($perPage)? $query->get() : $query->paginate($perPage);
    }

    public function enableStatusAtSpecificDate($date)
    {
        $condition = [
            'publish_at' => [
                '$gte' => new \MongoDB\BSON\UTCDateTime(strtotime("{$date} 00:00:00") * 1000),
                '$lte' => new \MongoDB\BSON\UTCDateTime(strtotime("{$date} 23:59:59") * 1000),
            ]
        ];
        
        return $this->model()->whereRaw($condition)
                            ->update(['status' => 1], ['upsert' => true, 'multi' => true]);
    }
}