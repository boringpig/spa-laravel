<?php

namespace App\Repositories;

abstract class Repository
{
    public abstract function model();
    public abstract function tag();

    /**
     * 回傳所有使用者並以註冊日期最新排序
     */
    public function getAll($perPage = null, $releation = [])
    {
        return cache()->tags($this->tag())->remember($this->tag().'.all', 60, function() use ($perPage,$releation) {
            if(!empty($releation)) {
                $query = $this->model()->with($releation)->orderBy('created_at','desc');
            } else {
                $query = $this->model()->orderBy('created_at','desc');
            }
            return is_null($perPage)? $query->get() : $query->paginate($perPage);
        });
    }

    /**
     * 回傳所有使用者的數量
     */
    public function getAllTotal()
    {
        return cache()->tags($this->tag())->remember($this->tag().'.total', 60, function() {
            return $this->model()->count();
        });
    }

    /**
     * 回傳單一使用者
     */
    public function findOneById($id)
    {
        return cache()->tags($this->tag())->remember($this->tag().'.findOne', 60, function() use($id) {
            return $this->model()->find($id);
        });
    }

    /**
     * 建立新的使用者並回傳該物件 
     */
    public function create($args)
    {
        $this->clearCache();
        return $this->model()->create($args);
    }

    /**
     * 建立多筆資料
     */
    public function insertMany($rows)
    {
        $this->clearCache();
        return $this->model()->insert($rows);
    }

    /**
     * 儲存修改後的使用者並回傳該物件
     */
    public function update($id, $args)
    {
        $this->clearCache();
        $model = $this->model()->find($id);
        return $model->update($args);
    }

    /**
     * 刪除特定的使用者
     */
    public function delete($id)
    {
        $this->clearCache();
        return $this->model()->destroy($id);
    }

    /**
     * 清空資料表
     */
    public function truncate()
    {
        $this->clearCache();
        return $this->model()->truncate();
    }

    /**
     * 清除單一快取
     */
    public function clearCache()
    {
        return cache()->tags($this->tag())->flush();
    }

    /**
     * 清除所有快取
     */
    public function clearAllCache()
    {
        return cache()->flush();
    }
}