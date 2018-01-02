<?php

namespace App\Repositories;

use App\User;

class UserRepository 
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * 回傳所有使用者並以註冊日期最新排序
     */
    public function getAll($perPage = null)
    {
        $query = $this->model->orderBy('created_at','desc');

        return is_null($perPage)? $query->get() : $query->paginate($perPage);
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

        $query = $this->model->whereRaw($condition)->orderBy('created_at','desc');
        
        return is_null($perPage)? $query->get() : $query->paginate($perPage);
    }
    
    /**
     * 回傳單一使用者
     */
    public function findOneById($id)
    {
        return $this->model->find($id);
    }

    /**
     * 建立新的使用者並回傳該物件 
     */
    public function create($args)
    {
        return $this->model->create($args);
    }

    /**
     * 儲存修改後的使用者並回傳該物件
     */
    public function update($id, $args)
    {
        return $this->model->where('id', $id)->update($args);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }
}