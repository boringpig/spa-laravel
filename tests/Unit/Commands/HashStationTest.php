<?php

namespace Tests\Feature;

use Tests\TestCase;

class HashStationTest extends TestCase
{
    protected $stationRepositoryMock = null;
    protected $kioskRepositoryMock = null;
    protected $scheduleRepositoryMock = null;

    public function setUp()
    {
        parent::setUp();
        $this->stationRepositoryMock = $this->initMock('App\CPS\Repositories\StationRepository');
        $this->kioskRepositoryMock = $this->initMock('App\Repositories\KioskTokenRepository');
        $this->scheduleRepositoryMock = $this->initMock('App\Repositories\ScheduleRepository');
    }   

    public function tearDown()
    {
        $this->stationRepositoryMock = null;
        $this->kioskRepositoryMock = null;
        $this->scheduleRepositoryMock = null;
        parent::tearDown();
    }

    /**
     * @group command
     */
    public function test成功產生hash後的場站代碼()
    {
        // arrange
        // 讀取場站資料並產生hash後的token
        $station = collect([
            ['s_no' => '01010001'],
            ['s_no' => '01010002']
        ]);
        $snos = $station->pluck('s_no')->toArray();
        $tokens = $this->hashToken($snos);
        $this->stationRepositoryMock->shouldReceive('getAll')
                                    ->once()
                                    ->withAnyArgs()
                                    ->andReturn($station);
        // 寫入kiosk_token資料表
        $this->kioskRepositoryMock->shouldReceive('truncate')
                                  ->once()
                                  ->andReturn(true);
        $this->kioskRepositoryMock->shouldReceive('insertMany')
                                  ->once()
                                  ->with($tokens)
                                  ->andReturn(true);
        // 寫入schedule資料表
        $this->scheduleRepositoryMock->shouldReceive('createOrUpdate')
                                     ->once()
                                     ->with('hash:station','每五分钟取得cps的场站代号产生token',5)
                                     ->andReturn(true);
        // act
        $this->artisan('hash:station');
        // assert
        $this->assertTrue(True);
    }

    /**
     * @group command
     */
    public function test無場站的例外錯誤()
    {
        // arrange
        $this->stationRepositoryMock->shouldReceive('getAll')
                                    ->once()
                                    ->withAnyArgs()
                                    ->andReturn(collect([]));
        $this->scheduleRepositoryMock->shouldReceive('createOrUpdate')
                                     ->once()
                                     ->withAnyArgs()
                                     ->andReturn(true);
        // act
        $this->artisan('hash:station');
        // assert
        $this->assertTrue(True);
    }

    /**
     * @group command
     */
    public function test插入資料失敗的例外錯誤()
    {
        // arrange
        $station = collect([
            ['s_no' => '01010001'],
            ['s_no' => '01010002']
        ]);
        $snos = $station->pluck('s_no')->toArray();
        $tokens = $this->hashToken($snos);
        $this->stationRepositoryMock->shouldReceive('getAll')
                                    ->once()
                                    ->withAnyArgs()
                                    ->andReturn($station);
        $this->kioskRepositoryMock->shouldReceive('truncate')
                                  ->once()
                                  ->andReturn(true);
        $this->kioskRepositoryMock->shouldReceive('insertMany')
                                  ->once()
                                  ->with($tokens)
                                  ->andReturn(false);
        $this->scheduleRepositoryMock->shouldReceive('createOrUpdate')
                                     ->once()
                                     ->withAnyArgs()
                                     ->andReturn(true);
        // act
        $this->artisan('hash:station');
        // assert
        $this->assertTrue(True);
    }

    /**
     * hash場站代號
     *
     * @param array $snos 場站代號
     * @return boolean
     */
    protected function hashToken($snos)
    {
        return collect($snos)->map(function($item) {
            return [
                'station_no' => $item,
                'token' => hash('sha256', $item)
            ];
        })->toArray();
    }
}
