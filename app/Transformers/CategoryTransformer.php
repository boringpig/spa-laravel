<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Entities\Category;

class CategoryTransformer
{
    public function transform($data)
    {
        if ($data instanceOf \App\Entities\Category) {
            return $this->format($data);
        } elseif ($data instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $collection = $data->getCollection()->map(function($category) {
                return $this->format($category);
            });
            return new LengthAwarePaginator($collection->toArray(), $data->total(), $data->perPage());
        } else {
            return $data->map(function($category) {
                return $this->format($category);
            });
        }
    }

    private function format(Category $category)
    {
        return [
            'id'            => array_get($category, '_id', ''),
            'no'            => array_get($category, 'no', ''),
            'name'          => array_get($category, 'name', ''),
            'updated_at'    => empty($category->updated_at)? '' : $category->updated_at->toDateTimeString(),
        ];
    }
}