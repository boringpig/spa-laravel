<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\CPS\Repositories\SCityRepository;
use App\CPS\Repositories\SCityAreaRepository;

class DropdownComposer
{
    private $counties = [];
    private $areas = [];

    public function __construct(
        SCityRepository $sCityRepository,
        SCityAreaRepository $sCityAreaRepository
    ) {
        $this->counties = $sCityRepository->getAll()->pluck('city_cn','country_id')->toArray();
        if(request('county') != '') {
            $this->areas = $sCityAreaRepository->getByArgs(['province' => '01', 'county' => request('county')])
                                               ->pluck('s_area.cn','area_id')->toArray();
        }
    }

    public function compose(View $view)
    {
        $view->with('counties', $this->counties);
        $view->with('areas', $this->areas);
    }
}