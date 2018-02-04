<?php

namespace App\Repositories;

use App\Entities\Actionlog;

class ActionlogRepository extends Repository
{

    public function model()
    {
        return app(Actionlog::class);
    }

    /**
     * 回傳所有使用者並以註冊日期最新排序
     */
    public function getAll($perPage = null)
    {
        $query = $this->model()->with(['user'])->orderBy('created_at','desc');

        return is_null($perPage)? $query->get() : $query->paginate($perPage);
    }

    /**
     * 根據搜尋參數回傳符合條件的使用者
     */
    public function getByArgs($args, $perPage = null)
    {
        $condition = [];
        $userModel = new \App\User();
        // 搜尋角色
        if(array_key_exists('operate_role', $args) && $args['operate_role'] != '') {
            $users = $userModel->where('role_id', $args['operate_role'])->get(['_id'])->pluck('_id')->toArray();
            $condition['user_id'] = ['$in' => $users];
        }

        // 搜尋使用者
        if(array_key_exists('operate_user', $args) && !empty($args['operate_user'])) {
            $user = $userModel->where('name', $args['operate_user'])->first();
            $condition['user_id'] = ['$eq' => is_null($user)? '' : $user->_id]; 
        }

        // 搜尋選單
        if(array_key_exists('operate_menu', $args) && !empty($args['operate_menu'])) {
            $condition['menu'] = ['$eq' => $args['operate_menu']];
        }

        // 搜尋操作時間
        if(array_key_exists('created_at', $args) && !empty($args['created_at'])) {
            list($start,$end) = breakupDateRange($args['created_at']);
            $condition['created_at'] = ['$gte' => new \MongoDB\BSON\UTCDateTime(strtotime($start) * 1000),
                                        '$lte' => new \MongoDB\BSON\UTCDateTime(strtotime($end) * 1000)];
        }

        $query = (count($condition) > 0)? $this->model()->whereRaw($condition)->orderBy('created_at','desc') : $this->model()->orderBy('created_at','desc');

        return is_null($perPage)? $query->get() : $query->paginate($perPage);
    }
}