<?php

namespace App\CPS\Repositories;

use App\CPS\Entities\SCity;

class SCityRepository
{

    public function model()
    {
        return app(SCity::class);
    }

    public function getAll($perPage = null)
    {
        $query = $this->model()->orderBy('province','asc')->orderBy('country_id','asc');

        return is_null($perPage)? $query->get() : $query->paginate($perPage);
    }

    public function getByArgs($args, $perPage = null)
    {
        $condition = [];

        if(array_key_exists('s_city', $args) && !empty($args['s_city'])) {
            $condition['province'] = ['$eq' => substr($args['s_city'],0,2)];
            $condition['country_id'] = ['$eq' => substr($args['s_city'],2,2)];
        }
        
        $query = (count($condition) > 0)? $this->model()->whereRaw($condition)->orderBy('parent_area','asc') : $this->model()->orderBy('parent_area','asc');

        return is_null($perPage)? $query->get() : $query->paginate($perPage);
    }
}