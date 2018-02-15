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
     * 找出第一筆
     *
     * @return void
     */
    public function findOne()
    {
        return $this->model()->first();
    }

    /**
     * 建立或更新資料
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