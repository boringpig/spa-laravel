<?php

namespace App\Repositories;

use App\Entities\Setting;

class SettingRepository extends Repository
{
    public function model()
    {
        return app(Setting::class);
    }

    public function tag()
    {
        return 'setting';
    }

    /**
     * 找出第一筆系統設定
     *
     * @return setting
     */
    public function findOne()
    {
        return $this->model()->first();
    }

    /**
     * 建立或更新系統資料
     *
     * @param array $args 參數
     * @return boolean
     */
    public function createOrUpdate($args)
    {
        $setting = $this->model()->first();
        
        if(is_null($setting)) {
            return $this->model()->create($args);
        }
        
        return $this->model()->where('_id',$setting->_id)->update($args);
    }
}