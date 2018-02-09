<?php

namespace App\Repositories;

use App\Entities\AreaGroup;
use App\CPS\Entities\SCity;

class AreaGroupRepository extends Repository
{
    public function model()
    {
        return app(AreaGroup::class);
    }
    
    /**
     * 回傳全部地區群組並新增沒有的地區資料
     */
    public function getAllOrCreateNewArea($perPage = null)
    {
        $scityModel = new SCity();
        $scitys = $scityModel->orderBy('province','asc')->orderBy('country_id','asc')->get()
                    ->map(function($item) {
                        return "{$item['province']}{$item['country_id']}";
                    })->toArray();
        $areagroups = $this->model()->get();
        // 新增cps內scity有，地區群組沒有的地區
        $diff_area = array_diff($scitys,$areagroups->pluck('parent_area')->toArray());
        if(count($diff_area) > 0) {
            $insert_data = [];
            foreach($diff_area as $area) {
                $insert_data [] = [
                    'parent_area' => $area,
                    'child_area'  => [$area]
                ];
            }
            $this->model()->insert($insert_data);
        }
        // 新增群組內無本身地區
        foreach($areagroups as $group) {
            if (!in_array($group['parent_area'],$group['child_area'])) {
                $temp = $group['child_area'];
                $temp[] = $group['parent_area'];
                $group->child_area = $temp;
                $group->save();
            }
        }
        
        return is_null($perPage)? $this->model()->orderBy('parent_area','asc')->get() : $this->model()->orderBy('parent_area','asc')->paginate($perPage);
    }

    public function getByArgs($args, $perPage = null)
    {
        $condition = [];

        if(array_key_exists('s_city', $args) && !empty($args['s_city'])) {
            $condition['parent_area'] = ['$eq' => $args['s_city']];
        }

        $query = (count($condition) > 0)? $this->model()->whereRaw($condition)->orderBy('parent_area','asc') : $this->model()->orderBy('parent_area','asc');

        return is_null($perPage)? $query->get() : $query->paginate($perPage);
    }
}