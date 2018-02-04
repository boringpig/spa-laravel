<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Entities\Actionlog;

class ActionlogTransformer
{
    public function transform($data)
    {
        if ($data instanceOf \App\Entities\Actionlog) {
            return $this->format($data);
        } elseif ($data instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $collection = $data->getCollection()->map(function($actionlog) {
                return $this->format($actionlog);
            });
            return new LengthAwarePaginator($collection->toArray(), $data->total(), $data->perPage());
        } else {
            return $data->map(function($actionlog) {
                return $this->format($actionlog);
            });
        }
    }

    private function format(Actionlog $actionlog)
    {
        return [
            'id'                    => $actionlog->_id, 
            'role_name'             => $actionlog->user->role->name,
            'name'                  => $actionlog->user->name,
            'menu'                  => array_get(config('menu'), $actionlog->menu, ''),
            'action'                => array_get(config('actionlog'), $actionlog->button, ''),
            'created_at'            => $actionlog->created_at->toDateTimeString(),
        ];
    }
}