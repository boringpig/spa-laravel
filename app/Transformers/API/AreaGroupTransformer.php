<?php

namespace App\Transformers\API;

use Illuminate\Database\Eloquent\Collection;
use App\Entities\AreaGroup;

class AreaGroupTransformer
{
    public function transform($data)
    {
        switch($data) {
            case $data instanceOf \App\Entities\AreaGroup:
                return $this->format($data);
                break;
            case $data instanceOf Collection:
                return $data->map(function($article) {
                    return $this->format($article);
                });    
                break;
        }
    }

    private function format(AreaGroup $group)
    {
        return [
            'parent_area'  => array_get($group, 'parent_area', ''),
            'child_area'   => array_get($group, 'child_area', ''),
        ];
    }
}