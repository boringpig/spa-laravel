<?php

namespace App\Repositories;

use App\Entities\Role;

class RoleRepository extends Repository
{
    public function model()
    {
        return app(Role::class);
    }

    public function tag()
    {
        return 'role';
    }

    /**
     * 根據搜尋參數回傳符合條件的角色
     *
     * @param string $queryString 搜尋字串用來當作快取的key值
     * @param array $args 搜尋參數
     * @param string $perPage 分頁數量
     * @return Collection/Pagination
     */
    public function getByArgs($queryString = '', $args, $perPage = null, $sorts = [])
    {
        $condition = [];

        if(array_key_exists('name', $args) && $args['name'] != '') {
            $condition['name'] = ['$eq' => $args['name']];
        }

        if(array_key_exists('updated_at', $args) && !empty($args['updated_at'])) {
            $condition['updated_at'] = ['$gte' => new \MongoDB\BSON\UTCDateTime(strtotime("{$args['updated_at']} 00:00:00") * 1000),
                                        '$lte' => new \MongoDB\BSON\UTCDateTime(strtotime("{$args['updated_at']} 23:59:59") * 1000)];
        }

        return cache()->tags($this->tag())->remember($this->tag().".{$queryString}", 60, function() use ($perPage,$condition,$sorts) {
            $query = (count($condition) > 0)? $this->model()->whereRaw($condition) : $this->model();
            if(is_array($sorts) && count($sorts) > 0) {
                foreach($sorts as $field => $sort) {
                    $query = $query->orderBy($field, $sort);
                }
            }
            return is_null($perPage)? $query->get() : $query->paginate($perPage);
        });
    }
}