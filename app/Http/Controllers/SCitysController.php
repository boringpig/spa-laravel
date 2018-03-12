<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CPS\Repositories\SCityRepository;
use App\CPS\Repositories\SCityAreaRepository;

class SCitysController extends Controller
{
    protected $sCityRepository;
    protected $sCityAreaRepository;

    public function __construct(
        SCityRepository $sCityRepository,
        SCityAreaRepository $sCityAreaRepository
    ) {
        $this->middleware('auth');
        $this->sCityRepository = $sCityRepository;
        $this->sCityAreaRepository = $sCityAreaRepository;
    }

    public function dropdown() 
    {
        $scitys = $this->sCityRepository->getAll()->map(function($item) {
            $areas = $this->sCityAreaRepository->getByArgs(['province' => $item['province'], 'county' => $item['country_id']])->pluck('s_area.cn','area_id')->toArray();
            return [
                'county'         => $item['country_id'],
                'county_name'    => $item['city_cn'],
                'areas'          => $areas,
            ];
        })->toArray();

        return response()->json(successOutput($scitys));
    }
}