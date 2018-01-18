<?php

namespace App\CPS\Repositories;

use App\CPS\Entities\Station;

class StationRepository
{

    public function model()
    {
        return app(Station::class);
    }

    public function getAll($perPage = null)
    {
        return is_null($perPage)? $this->model()->get() : $this->model()->paginate($perPage);
    }

    public function getByArgs($args, $perPage = null)
    {
        $condition = [];

        if(array_key_exists('station', $args) && !empty($args['station'])) {
            $condition['s_no'] = new \MongoDB\BSON\Regex("^{$args['station']}");
        }

        if(array_key_exists('area', $args) && $args['area'] != '') {
            $condition['area_id'] = ['$eq' => (int) $args['area']];
        }

        $query = (count($condition) > 0)? $this->model()->whereRaw($condition) : $this->model();

        return is_null($perPage)? $query->get() : $query->paginate($perPage);
    }

    public function findOneByStation($station)
    {
        return $this->model()->where('s_no', $station)->first();
    }
}