<?php

namespace App\Repositories;

abstract class Repository
{
    public abstract function model();
    public abstract function tag();

    /**
     * 回傳所有的資料並用建立日期遞增排序
     *
     * @param string $perPage 分頁數量
     * @param array $releation 關聯資料表
     * @return Collection/Pagination
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
     * 回傳有地區權限限制的資料
     *
     * @param string $perPage 分頁
     * @param array $releation 關聯表
     * @return collection
     */
    public function getAllWithPermission($perPage = null, $releation = [])
    {
        return cache()->tags($this->tag())->remember($this->tag().'.permission_all', 60, function() use ($perPage, $releation) {
            if(!empty($releation)) {
                $query = $this->model()->areaPermission()->with($releation)->orderBy('created_at','desc');
            } else {
                $query = $this->model()->areaPermission()->orderBy('created_at','desc');
            }
            return is_null($perPage)? $query->get() : $query->paginate($perPage);
        });
    }

    /**
     * 回傳全部資料的總數量
     *
     * @return int 總數量
     **/
    public function getAllTotal()
    {
        return cache()->tags($this->tag())->remember($this->tag().'.total', 60, function() {
            return $this->model()->count();
        });
    }

    /**
     * 回傳單一符合的資料
     *
     * @param string $id 資料的ID
     * @return Model
     */
    public function findOneById($id)
    {
        return cache()->tags($this->tag())->remember($this->tag().'.findOne', 60, function() use($id) {
            return $this->model()->find($id);
        });
    }

    /**
     * 建立一筆資料並回傳該物件
     *
     * @param array $args 建立參數
     * @return Model
     */
    public function create($args)
    {
        $this->clearCache();
        return $this->model()->create($args);
    }

    /**
     * 建立多筆資料
     *
     * @param array $rows 多筆參數的陣列
     * @return boolean
     */
    public function insertMany($rows)
    {
        $this->clearCache();
        return $this->model()->insert($rows);
    }

    /**
     * 修改符合條件資料的內容
     *
     * @param string $id 資料的ID
     * @param array $args 更新參數
     * @return boolean
     */
    public function update($id, $args)
    {
        $this->clearCache();
        $model = $this->model()->find($id);
        return $model->update($args);
    }

    /**
     * 刪除符合條件的資料
     *
     * @param string $id 資料的ID
     * @return boolean
     */
    public function delete($id)
    {
        $this->clearCache();
        return $this->model()->destroy($id);
    }

    /**
     * 清空資料表
     *
     * @return boolean
     */
    public function truncate()
    {
        $this->clearCache();
        return $this->model()->truncate();
    }

    /**
     * 清除同類型的快取資料
     *
     * @return void
     */
    public function clearCache()
    {
        return cache()->tags($this->tag())->flush();
    }

    /**
     * 清除所有快取資料
     *
     * @return void
     */
    public function clearAllCache()
    {
        return cache()->flush();
    }
}