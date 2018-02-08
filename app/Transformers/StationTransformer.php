<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\CPS\Entities\Station;
use App\CPS\Repositories\KioskStatusRepository;
use App\CPS\Repositories\SCityAreaRepository;
use Carbon\Carbon;

class StationTransformer
{
    protected $kiosk_status = [];
    protected $scity_areas = [];

    public function __construct(
        KioskStatusRepository $kioskStatusRepository,
        SCityAreaRepository $sCityAreaRepository
    ) {
        $this->kiosk_status = $kioskStatusRepository->getAll()->keyBy('s_no')->toArray();
        $this->scity_areas = $sCityAreaRepository->getAll()->keyBy(function($item) {
            return "{$item['province']}{$item['country_id']}{$item['area_id']}";
        })->toArray();;
    }

    public function transform($data)
    {
        if ($data instanceOf \App\CPS\Entities\Station) {
            return $this->format($data);
        } elseif ($data instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $collection = $data->getCollection()->map(function($station) {
                return $this->format($station);
            });
            return new LengthAwarePaginator($collection->toArray(), $data->total(), $data->perPage());
        } else {
            return $data->map(function($station) {
                return $this->format($station);
            });
        }
    }

    private function format(Station $station)
    {
        $touch_screen = "";
        if(!empty($this->kiosk_status[$station['s_no']]['touch'])) {
            $touch_screen = ($this->kiosk_status[$station['s_no']]['touch'] == 'True')? __('message.working_normally') : __('message.connection_interrupted');
        }
        $camera = "";
        if(!empty($this->kiosk_status[$station['s_no']]['camera'])) {
            $camera = ($this->kiosk_status[$station['s_no']]['camera'] == 'True')? __('message.working_normally') : __('message.connection_interrupted');
        }
        $card_reader = "";
        if(!empty($this->kiosk_status[$station['s_no']]['easycard'])) {
            $card_reader = ($this->kiosk_status[$station['s_no']]['easycard'] == 'True')? __('message.working_normally') : __('message.connection_interrupted');
        }
        $connection_status = "";
        if(!empty($this->kiosk_status[$station['s_no']]['easycard'])) {
            $connection_status = (Carbon::now()->diffInMinutes(Carbon::createFromFormat('Y-m-d H:i:s', $this->kiosk_status[$station['s_no']]['update'])) > 5)? 0 : 1;
        }
        return [
            'station_name'          => array_get($station, "s_name.cn", ""),
            'station_number'        => array_get($station, 's_no', ""),
            'station_ip'            => array_get($station, "s_ip", ""),
            'station_area'          => array_get($this->scity_areas, substr($station['s_no'],0,4)."{$station['area_id']}.s_area.cn", ""),
            'identification'        => empty($station['s_no'])? '' : hash('sha256', $station->s_no),
            'version'               => array_get($this->kiosk_status, "{$station['s_no']}.kversion", ""),
            'internal_temperature'  => array_get($this->kiosk_status, "{$station['s_no']}.temperatureinsidebox", ""),
            'external_temperature'  => array_get($this->kiosk_status, "{$station['s_no']}.temperatureoutsidebox", ""),
            'internal_humidity'     => array_get($this->kiosk_status, "{$station['s_no']}.humidityinsidebox", ""),
            'external_humidity'     => array_get($this->kiosk_status, "{$station['s_no']}.humidityoutsidebox", ""),
            'touch_screen'          => $touch_screen,
            'camera'                => $camera,
            'card_reader'           => $card_reader,
            'connection_status'     => $connection_status,
            'connection_status_name'=> ($connection_status)? __('form.normal') : __('form.abnormal'),
        ];
    }
}