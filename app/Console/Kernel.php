<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\AdvertisementStatus',
        'App\Console\Commands\HashStation',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('AdvertisementStatus:switch')
                 ->dailyAt('14:47')
                 ->withoutOverlapping()
                 ->after(function() {
                    Log::info('AdvertisementStatus:switch 每天凌晨12点将预发布的广告转变成啟动状态');
                 });

        $schedule->command('hash:station')
                 ->everyFiveMinutes()
                 ->withoutOverlapping()
                 ->after(function() {
                    Log::info('hash:station 每五分钟取得cps的场站代号产生token');
                 });
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
