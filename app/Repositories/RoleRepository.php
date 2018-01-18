<?php

namespace App\Repositories;

use App\Role;

class RoleRepository extends Repository
{

    public function model()
    {
        return app(Role::class);
    }

    /**
     * 回傳所有使用者並以註冊日期最新排序
     */
    public function getAll($perPage = null)
    {
        $query = $this->model()->with('users')->orderBy('created_at','desc');

        return is_null($perPage)? $query->get() : $query->paginate($perPage);
    }

    /**
     * 根據搜尋參數回傳符合條件的使用者
     */
    public function getByArgs($args, $perPage = null)
    {
        $condition = [];

        if(array_key_exists('name', $args) && $args['name'] != '') {
            $condition['name'] = ['$eq' => $args['name']];
        }

        if(array_key_exists('updated_at', $args) && !empty($args['updated_at'])) {
            $condition['updated_at'] = ['$gte' => new \MongoDB\BSON\UTCDateTime(strtotime("{$args['updated_at']} 00:00:00") * 1000),
                                        '$lte' => new \MongoDB\BSON\UTCDateTime(strtotime("{$args['updated_at']} 23:59:59") * 1000)];
        }
        
        $query = (count($condition) > 0)? $this->model()->whereRaw($condition)->orderBy('created_at','desc') : $this->model()->orderBy('created_at','desc');

        return is_null($perPage)? $query->get() : $query->paginate($perPage);
    }
    
    /**
     * 回傳角色名稱陣列 
     */
    public function getPluckNameArray()
    {
        return $this->model()->get()->pluck('name','id')->toArray();
    }
}