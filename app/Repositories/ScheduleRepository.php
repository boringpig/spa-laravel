<?php

namespace App\Repositories;

use App\Entities\Schedule;

class ScheduleRepository extends Repository
{
    public function model()
    {
        return app(Schedule::class);
    }

    public function tag()
    {
        return 'schedule';
    }

    /**
     * 建立或更新資料
     */
    public function createOrUpdate($command, $description, $frequence, $error = "")
    {
        $schedule = $this->model()->where('command', $command)->first();
        $runtime = new \MongoDB\BSON\UTCDateTime(time() * 1000);
        $args = [
            'description'   => $description,
            'frequence'     => $frequence,
            'runtime'       => $runtime,
            'error'         => $error,
        ];
        if(is_null($schedule)) {
            $args['command'] = $command;
            return $this->model()->create($args);
        }
        return $this->model()->where('_id',$schedule->_id)->update($args, ['upsert' => true]);
    }
}