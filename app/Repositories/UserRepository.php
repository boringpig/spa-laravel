<?php

namespace App\Repositories;

use App\User;

class UserRepository extends Repository
{
    public function model()
    {
        return app(User::class);
    }

    public function tag()
    {
        return 'user';
    }

    /**
     * 根據搜尋參數回傳符合條件的使用者
     */
    public function getByArgs($queryString = '', $args, $perPage = null)
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

        return cache()->tags($this->tag())->remember($this->tag().".{$queryString}", 60, function() use ($perPage, $condition){
            $query = (count($condition) > 0)? $this->model()->whereRaw($condition)->orderBy('created_at','desc') : $this->model()->orderBy('created_at','desc');
            return is_null($perPage)? $query->get() : $query->paginate($perPage);
        });
    }

    /**
     * 根據帳號找使用者
     *
     * @param string $username 帳號
     * @return Model
     */
    public function findByUsername($username)
    {
        return $this->model()->where('username', $username)->first();
    }
}