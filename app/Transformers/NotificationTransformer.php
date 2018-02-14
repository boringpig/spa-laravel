<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class NotificationTransformer
{
    public function transform($data)
    {
        if ($data instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $collection = $data->getCollection()->map(function($notification) {
                return $this->format($notification);
            });
            return new LengthAwarePaginator($collection->toArray(), $data->total(), $data->perPage());
        } else {
            return $data->map(function($notification) {
                return $this->format($notification);
            });
        }
    }

    private function format($notification)
    {
        return [
            'id'                    => $notification->_id,
            'type'                  => $notification->type, 
            'read_at'               => $notification->read_at, 
            'data'                  => $notification->data,
            'created_at'            => $notification->created_at->toDateTimeString(),
        ];
    }
}