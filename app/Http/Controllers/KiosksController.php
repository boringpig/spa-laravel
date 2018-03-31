<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CPS\Repositories\StationRepository;
use App\CPS\Repositories\SCityRepository;
use App\Transformers\StationTransformer;
use Illuminate\Support\Facades\Route;
use PLC;

class KiosksController extends Controller
{
    protected $stationRepository;
    protected $stationTransformer;
    protected $sCityRepository;

    public function __construct(
        StationRepository $stationRepository,
        StationTransformer $stationTransformer,
        SCityRepository $sCityRepository
    ) {
        $this->middleware(['auth','record.actionlog']);
        $this->middleware('role.auth', ['only' => 'index', 'edit', 'search']);
        $this->stationRepository = $stationRepository;
        $this->stationTransformer = $stationTransformer;
        $this->sCityRepository = $sCityRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kiosks = $this->stationRepository->getAllWithPermission(config('website.perPage'));
        $kiosks = (count($kiosks) > 0)? $this->stationTransformer->transform($kiosks)->setPath("/".Route::current()->uri()) : [];
        return view('kiosks.index', [
            'kiosks'     => $kiosks,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($station)
    {
        $kiosk = $this->stationRepository->findOneByStation($station);
        if(is_null($kiosk)) {
            session()->flash('error', __('form.no_data'));
            return redirect()->back();
        }
        $kiosk = $this->stationTransformer->transform($kiosk);
        // 檢查是否斷線
        if(!$kiosk['connection_status']) {
            session()->flash('error', __('message.connection_interrupted', ['message' => __('message.unable_to_operate')]));
            return redirect()->back();
        }
        $plc = new PLC($kiosk['station_ip']);
        // 取得各類型的燈號狀態
        $kiosk['stoboard_light'] = $plc->searchLightStatus('stoboard');
        $kiosk['card_reader_light'] = $plc->searchLightStatus('card_reader');
        $kiosk['collision_warning_light'] = $plc->searchLightStatus('collision_warning');
        // 取得各門位狀態
        $kiosk = array_merge($kiosk, $plc->searchDoorStatus());
        // 取得各類型的電源狀態
        $kiosk['xps1'] = $plc->searchPowerStatus('xps1');
        $kiosk['xps2'] = $plc->searchPowerStatus('xps2');
        $kiosk['router'] = $plc->searchPowerStatus('router');
        $kiosk['atur'] = $plc->searchPowerStatus('atur');
        $kiosk['card_reader'] = $plc->searchPowerStatus('card_reader');
        $kiosk['camera'] = $plc->searchPowerStatus('camera');
        $kiosk['show_screen'] = $plc->searchPowerStatus('screen');
        $kiosk['touch_function'] = $plc->searchPowerStatus('touch');
        $kiosk['ac_sockets'] = $plc->searchPowerStatus('ac_sockets');
        $kiosk['fot'] = $plc->searchPowerStatus('fot');
        // 取得各類型的風扇狀態
        $kiosk['into_fan1'] = $plc->searchFanStatus('into1');
        $kiosk['into_fan2'] = $plc->searchFanStatus('into2');
        $kiosk['exhaust_fan1'] = $plc->searchFanStatus('exhaust1');
        $kiosk['exhaust_fan2'] = $plc->searchFanStatus('exhaust2');
        $kiosk['exhaust_fan3'] = $plc->searchFanStatus('exhaust3');
        return view('kiosks.edit', [
            'kiosk'         => $kiosk,
        ]);
    }

    public function search(Request $request)
    {
        $kiosks = $this->stationRepository->getByArgs($request->all(),config('website.perPage'));
        $kiosks = (count($kiosks) > 0)? $this->stationTransformer->transform($kiosks)->appends($request->all())->setPath("/".Route::current()->uri()) : [];
        $request->flash();
        return view('kiosks.index', [
            'kiosks'   => $kiosks,
        ]);
    }

    public function export(Request $request)
    {
        ini_set('memory_limit','32G');
		set_time_limit(0);
        $kiosks = $this->stationRepository->getByArgs($request->all());
        $kiosks = (count($kiosks) > 0)? $this->stationTransformer->transform($kiosks) : [];
        $title = implode(',', [__('form.station'),__('form.area'),__('form.ip_address'),__('form.kiosk_identification'),__('form.version'),__('form.connection_status')]);
		$content = "{$title}\r\n";
		foreach ($kiosks as $key => $value) {
			$content = $content. "{$value['station_number']} {$value['station_name']},{$value['station_area']},{$value['station_ip']},";
			$content = $content. "{$value['identification']},{$value['version']},{$value['connection_status_name']}\r\n";
        }
		return response($content, 200, [
            "Content-Type" => 'application/force-download',
            "Content-Type" => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"". __('pageTitle.kiosks_page').".csv\""
        ]);
    }

    public function controlLight(Request $request, $station)
    {
        try {
            $kiosk = $this->stationRepository->findOneByStation($station);
            if(is_null($kiosk)) {
                throw new \Exception(__('message.no_data'));
            }
            $start_time = empty($request->start_time)? '0000' : replaceTimeColon($request->start_time,true);
            $end_time = empty($request->end_time)? '2359' : replaceTimeColon($request->end_time,true);
            if($request->action_type) {
                $cmd = "10{$request->light_type}{$request->launch_type}{$request->action_type}{$start_time}{$end_time}";
            } else {
                $cmd = "10{$request->light_type}00{$start_time}{$end_time}";
            }
            $plc = new PLC($kiosk->s_ip);
            if(!$plc->controlStatus($cmd)) {
                throw new \Exception(__('message.change_status_fail'));
            }
            return response()->json(successOutput($kiosk), 200);
        } catch (\Exception $e) {
            return response()->json(errorOutput($e->getMessage()), 500);
        }
    }

    public function controlPower(Request $request, $station)
    {
        try {
            $kiosk = $this->stationRepository->findOneByStation($station);
            if(is_null($kiosk)) {
                throw new \Exception(__('message.no_data'));
            }
            $cmd = "30{$request->power_type}{$request->action_type}";
            $plc = new PLC($kiosk->s_ip);
            if(!$plc->controlStatus($cmd)) {
                throw new \Exception(__('message.change_status_fail'));
            }
            return response()->json(successOutput($kiosk), 200);
        } catch (\Exception $e) {
            return response()->json(errorOutput($e->getMessage()), 500);
        }
    }

    public function controlFan(Request $request, $station)
    {
        try {
            $kiosk = $this->stationRepository->findOneByStation($station);
            if(is_null($kiosk)) {
                throw new \Exception(__('message.no_data'));
            }
            $cmd = "40{$request->fan_type}{$request->launch_type}{$request->open_temperature}{$request->close_temperature}";
            $plc = new PLC($kiosk->s_ip);
            if(!$plc->controlStatus($cmd)) {
                throw new \Exception(__('message.change_status_fail'));
            }
            return response()->json(successOutput($kiosk), 200);
        } catch (\Exception $e) {
            return response()->json($this->errorOutput($e->getMessage()), 500);
        }
    }

    public function calculateStation()
    {
        $data = $this->stationRepository->getTotalCount()->map(function($item, $key) {
            $total_count = $this->stationRepository->getAllTotal();
            $scitys = $this->sCityRepository->getAll()->pluck('city_cn','country_id')->toArray();
            $colors = ["#2091CF","#68BC31","#AF4E96","#DA5430","#FEE074"];

            return [
                'label' => array_get($scitys, $item['county'],''),
                'data'  => round($item['count']/$total_count*100,2),
                'color' => array_get($colors,$key,"#AF4E96"),
            ];
        })->toArray();
        
        return response()->json(successOutput($data), 200);
    }
}