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
    /**
     * 建立或更新排程狀態的資料
     *
     * @param string $command 排程名稱
     * @param string $description 排程作動的描述
     * @param string $frequence 排程啟動的頻率
     * @param string $error 排程錯誤訊息
     * @return void
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