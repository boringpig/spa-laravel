<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Advertisement;

class AdvertisementTransformer
{
    public function transform($data)
    {
        if ($data instanceOf \App\Advertisement) {
            return $this->format($data);
        } elseif ($data instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $collection = $data->getCollection()->map(function($advertisement) {
                return $this->format($advertisement);
            });
            return new LengthAwarePaginator($collection->toArray(), $data->total(), $data->perPage());
        } else {
            return $data->map(function($advertisement) {
                return $this->format($advertisement);
            });
        }
    }

    private function format(Advertisement $advertisement)
    {
        list($broadcast_start_time, $broadcast_end_time) = explode('~',$advertisement->broadcast_time);
        return [
            'id'                    => $advertisement->_id, 
            'name'                  => $advertisement->name,
            'path'                  => asset($advertisement->path),
            'sequence'              => $advertisement->sequence,
            'round_time'            => $advertisement->round_time,
            'weeks'                 => $advertisement->weeks,
            'status'                => $advertisement->status,
            'broadcast_time'        => $advertisement->broadcast_time,
            'broadcast_start_time'  => $broadcast_start_time,
            'broadcast_end_time'    => $broadcast_end_time,
            'publish_at'            => $advertisement->publish_at->toDateString(),
            'updated_at'            => $advertisement->updated_at->toDateTimeString(),
        ];
    }
}