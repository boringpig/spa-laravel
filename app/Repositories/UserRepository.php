<?php

namespace App\Repositories;

use App\User;

class UserRepository extends Repository
{

    public function model()
    {
        return app(User::class);
    }

    /**
     * 根據搜尋參數回傳符合條件的使用者
     */
    public function getByArgs($args, $perPage = null)
    {
        $condition = [];

        if(array_key_exists('status', $args) && $args['status'] != '') {
            $condition['status'] = ['$eq' => (int) $args['status']];
        }

        if(array_key_exists('username', $args) && !empty($args['username'])) {
            $condition['username'] = ['$eq' => $args['username']]; 
        }

        if(array_key_exists('role_id', $args) && !empty($args['role_id'])) {
            $condition['role_id'] = ['$eq' => $args['role_id']];
        }

        if(array_key_exists('updated_at', $args) && !empty($args['updated_at'])) {
            $condition['updated_at'] = ['$gte' => new \MongoDB\BSON\UTCDateTime(strtotime("{$args['updated_at']} 00:00:00") * 1000),
                                        '$lte' => new \MongoDB\BSON\UTCDateTime(strtotime("{$args['updated_at']} 23:59:59") * 1000)];
        }

        $query = $this->model()->whereRaw($condition)->orderBy('created_at','desc');

        return is_null($perPage)? $query->get() : $query->paginate($perPage);
    }
}