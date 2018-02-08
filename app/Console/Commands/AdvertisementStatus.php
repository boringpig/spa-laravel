<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\AdvertisementRepository;
use App\Repositories\ScheduleRepository;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AdvertisementStatus extends Command
{
    protected $advertisementRepository;
    protected $scheduleRepository;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AdvertisementStatus:switch {--D|date= : 日期格式:Y-m-d}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '每天凌晨12点将预发布的广告转变成啟动状态';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        AdvertisementRepository $advertisementRepository,
        ScheduleRepository $scheduleRepository
    ) {
        parent::__construct();
        $this->advertisementRepository = $advertisementRepository;
        $this->scheduleRepository = $scheduleRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        preg_match('/^(.*)\{?/',$this->signature, $match);
        $command = trim($match[1]);
        try {
            $start = microtime(true);
            echo __('message.start_time', ['time' => date('Y-m-d H:i:s')])."\n";
            $date = empty($this->option('date'))? Carbon::now()->toDateString() : trim($this->option('date'));
            // 檢查日期格式
            $check_result = checkDateFormat($date);
            if(! $check_result['result']) {
                throw new \Exception($check_result['error']);
            };
            // 啟動符合當日的廣告狀態
            $result = $this->advertisementRepository->enableStatusAtSpecificDate($date);
            if(!$result) {
                throw new \Exception(__('message.enable_status_fail'));
            }
            // 紀錄排程執行時間
            $this->scheduleRepository->createOrUpdate($command, $this->description, 1440);
            $end = microtime(true);
            echo __('message.end_time', ['time' => date('Y-m-d H:i:s')])."\n";
            echo __('message.total_time_spent', ['success_message' => __('message.enable_status_success'), 'second' => round($end-$start,2)])."\n";
        } catch (\Exception $e) {
            $this->scheduleRepository->createOrUpdate($command, $this->description, 1440, $e->getMessage());
            echo __('message.end_time', ['time' => date('Y-m-d H:i:s')])."\n";
            echo __('message.error_message', ['message' => $e->getMessage()])."\n";
            Log::error("AdvertisementStatus:switch，".__('message.error_message', ['message' => $e->getMessage()]));
        }
    }
}
