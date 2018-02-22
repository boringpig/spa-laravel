<?php

namespace Tests\Feature;

use Tests\TestCase;
use Carbon\Carbon;

class AdvertisementStatusTest extends TestCase
{
    protected $advertisementRepositoryMock = null;
    protected $scheduleRepositoryMock = null;

    public function setUp()
    {
        parent::setUp();
        $this->advertisementRepositoryMock = $this->initMock('App\Repositories\AdvertisementRepository');
        $this->scheduleRepositoryMock = $this->initMock('App\Repositories\ScheduleRepository');
    }

    public function tearDown()
    {
        $this->advertisementRepositoryMock = null;
        $this->scheduleRepositoryMock = null;
        parent::tearDown();
    }

    /**
     * @group command
     *
     */
    public function test預播放廣告啟用()
    {
        // arrange
        $date = Carbon::now()->startOfDay()->toDateString();
        $this->advertisementRepositoryMock->shouldReceive('enableStatusAtSpecificDate')
                                          ->once()
                                          ->with($date)
                                          ->andReturn(true);
        $this->scheduleRepositoryMock->shouldReceive('createOrUpdate')
                                     ->once()
                                     ->with('AdvertisementStatus:switch','每天凌晨12点将预发布的广告转变成啟动状态',1440)
                                     ->andReturn(true);
        // act 
        $this->artisan('AdvertisementStatus:switch', ['--date' => $date]);
        // assert
        $this->assertTrue(True);
    }

    /**
     * @group command
     */
    public function test啟用狀態失敗()
    {
        // arrange
        $date = Carbon::now()->startOfDay()->toDateString();
        $this->advertisementRepositoryMock->shouldReceive('enableStatusAtSpecificDate')
                                          ->once()
                                          ->with($date)
                                          ->andReturn(false);
        $error = __('message.enable_status_fail');
        $this->scheduleRepositoryMock->shouldReceive('createOrUpdate')
                                     ->once()
                                     ->with('AdvertisementStatus:switch','每天凌晨12点将预发布的广告转变成啟动状态',1440,$error)
                                     ->andReturn(true);
        // act
        $this->artisan('AdvertisementStatus:switch', ['--date' => $date]);
        // assert
        $this->assertTrue(True);
    }

    /**
     * @group command
     */
    public function test時間格式錯誤()
    {
        // arrange
        $error = '日期格式错误，范例：Y-M-D';
        $this->scheduleRepositoryMock->shouldReceive('createOrUpdate')
                                     ->once()
                                     ->with('AdvertisementStatus:switch','每天凌晨12点将预发布的广告转变成啟动状态',1440,$error)
                                     ->andReturn(true);
        // act
        $this->artisan('AdvertisementStatus:switch', ['--date' => date('Ymd')]);
        // assert
        $this->assertTrue(True);
    }
}