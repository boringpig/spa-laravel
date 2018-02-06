<?php

namespace App\Repositories;

abstract class Repository
{
    public abstract function model();

    /**
     * 回傳所有使用者並以註冊日期最新排序
     */
    public function getAll($perPage = null, $releation = [])
    {
        if(!empty($releation)) {
            $query = $this->model()->with($releation)->orderBy('created_at','desc');
        } else {
            $query = $this->model()->orderBy('created_at','desc');
        }

        return is_null($perPage)? $query->get() : $query->paginate($perPage);
    }

    /**
     * 回傳所有使用者的數量
     */
    public function getAllTotal()
    {
        return $this->model()->count();
    }

    /**
     * 回傳單一使用者
     */
    public function findOneById($id)
    {
        return $this->model()->find($id);
    }

    /**
     * 建立新的使用者並回傳該物件 
     */
    public function create($args)
    {
        return $this->model()->create($args);
    }

    /**
     * 建立多筆資料
     */
    public function insertMany($rows)
    {
        return $this->model()->insert($rows);
    }

    /**
     * 儲存修改後的使用者並回傳該物件
     */
    public function update($id, $args)
    {
        return $this->model()->where('_id', $id)->update($args);
    }

    /**
     * 刪除特定的使用者
     */
    public function delete($id)
    {
        return $this->model()->destroy($id);
    }

    /**
     * 清空資料表
     */
    public function truncate()
    {
        return $this->model()->truncate();
    }
}