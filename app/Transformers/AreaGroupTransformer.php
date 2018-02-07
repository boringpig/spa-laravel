<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Entities\AreaGroup;

class AreaGroupTransformer
{
    private $scity_names = [];

    public function __construct()
    {
        $this->scity_names = getSCityArray(); 
    }

    public function transform($data)
    {
        if ($data instanceOf \App\Entities\AreaGroup) {
            return $this->format($data);
        } elseif ($data instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $collection = $data->getCollection()->map(function($group) {
                return $this->format($group);
            });
            return new LengthAwarePaginator($collection->toArray(), $data->total(), $data->perPage());
        } else {
            return $data->map(function($group) {
                return $this->format($group);
            });
        }
    }

    private function format(AreaGroup $group)
    {
        $child_area = [];
        if(!empty($group['child_area'])) {
            $child_area = collect($group['child_area'])->map(function($item) {
                return array_get($this->scity_names, $item, '')."({$item})";
            })->toArray();
        }
        return [
            'id'                 => array_get($group, '_id', ''),
            'parent_area'        => array_get($group, 'parent_area', ''),
            'parent_area_name'   => empty($group['parent_area'])? '' : array_get($this->scity_names, $group['parent_area'], '')."({$group['parent_area']})",
            'child_area'         => array_get($group, 'child_area', ''),
            'child_area_name'    => implode('、', $child_area),
        ];
    }
}