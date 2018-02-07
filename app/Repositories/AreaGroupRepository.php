<?php

namespace App\Repositories;

use App\Entities\AreaGroup;

class AreaGroupRepository extends Repository
{
    public function model()
    {
        return app(AreaGroup::class);
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