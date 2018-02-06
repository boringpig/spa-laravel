<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\CPS\Repositories\StationRepository;
use App\Repositories\KioskTokenRepository;

class HashStation extends Command
{
    protected $stationRepository;
    protected $kioskTokenRepository;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hash:station';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '每五分鐘取得cps的場站代號並 hash 產生 token';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        StationRepository $stationRepository,
        KioskTokenRepository $kioskTokenRepository
    ) {
        parent::__construct();
        $this->stationRepository = $stationRepository;
        $this->kioskTokenRepository = $kioskTokenRepository;
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
            $snos = $this->stationRepository->getAll()->pluck('s_no')->toArray();
            if(empty($snos)) {
                throw new \Exception(__('message.no_data'));
            }
            $tokens = collect($snos)->map(function($item) {
                return [
                    'station_no'  => $item,
                    'token' => hash('sha256', $item)
                ];
            })->toArray();
            // 清空资料表
            $this->kioskTokenRepository->truncate();
            if(!$this->kioskTokenRepository->insertMany($tokens)) {
                throw new \Exception(__('message.insert_many_fail'));
            }
            $end = microtime(true);
            echo __('message.end_time', ['time' => date('Y-m-d H:i:s')])."\n";
            echo __('message.total_time_spent', ['success_message' => __('message.insert_many_success'), 'second' => round($end-$start,2)])."\n";
        } catch (\Exception $e) {
            echo __('message.end_time', ['time' => date('Y-m-d H:i:s')])."\n";
            echo __('message.error_message', ['message' => $e->getMessage()])."\n";
            Log::error("hash:station，".__('message.error_message', ['message' => $e->getMessage()]));
        }
    }
}
