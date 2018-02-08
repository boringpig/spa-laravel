<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Entities\Schedule;
use Carbon\Carbon;

class ScheduleTransformer
{

    public function transform($data)
    {
        if ($data instanceOf \App\Entities\Schedule) {
            return $this->format($data);
        } elseif ($data instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $collection = $data->getCollection()->map(function($command) {
                return $this->format($command);
            });
            return new LengthAwarePaginator($collection->toArray(), $data->total(), $data->perPage());
        } else {
            return $data->map(function($command) {
                return $this->format($command);
            });
        }
    }

    private function format(Schedule $command)
    {
        $status = 0;
        if(!empty($command->runtime) && !empty($command->frequence)) {
            $minutes = Carbon::now()->diffInMinutes($command->runtime);
            $status = ($minutes < $command->frequence)? 1 : 0;
        }

        return [
            'command'       => array_get($command, "command", ""),
            'description'   => array_get($command, "description", ""),
            'frequence'     => array_get($command, "frequence", ""),
            'status'        => $status,
            'error'         => array_get($command, "error", ""),
            'runtime'       => empty($command->runtime)? '' : $command->runtime->toDateTimeString(),
        ];
    }
}