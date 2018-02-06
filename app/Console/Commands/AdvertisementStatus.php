<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\AdvertisementRepository;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AdvertisementStatus extends Command
{
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
    protected $description = '每天凌晨12點檢查廣告資料的發佈日期是否為當日並轉換該廣告的狀態';

    protected $advertisementRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(AdvertisementRepository $advertisementRepository)
    {
        parent::__construct();
        $this->advertisementRepository = $advertisementRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
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
            $end = microtime(true);
            echo __('message.end_time', ['time' => date('Y-m-d H:i:s')])."\n";
            echo __('message.total_time_spent', ['success_message' => __('message.enable_status_success'), 'second' => round($end-$start,2)])."\n";
        } catch (\Exception $e) {
            echo __('message.end_time', ['time' => date('Y-m-d H:i:s')])."\n";
            echo __('message.error_message', ['message' => $e->getMessage()])."\n";
            Log::error("AdvertisementStatus:switch，".__('message.error_message', ['message' => $e->getMessage()]));
        }
    }
}
