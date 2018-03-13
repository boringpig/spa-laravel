<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\ArticleRepository;
use App\Repositories\AdvertisementRepository;
use App\Repositories\AreaGroupRepository;
use App\Repositories\CategoryRepository;
use App\CPS\Repositories\StationRepository;
use App\CPS\Repositories\SCityRepository;

class HomeController extends Controller
{
    protected $userRepository;
    protected $articleRepository;
    protected $advertisementRepository;
    protected $stationRepository;
    protected $areaGroupRepository;
    protected $categoryRepository;
    protected $sCityRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        UserRepository $userRepository,
        ArticleRepository $articleRepository,
        AdvertisementRepository $advertisementRepository,
        StationRepository $stationRepository,
        AreaGroupRepository $areaGroupRepository,
        CategoryRepository $categoryRepository,
        SCityRepository $sCityRepository
    ) {
        $this->middleware('auth');
        $this->userRepository = $userRepository;
        $this->articleRepository = $articleRepository;
        $this->advertisementRepository = $advertisementRepository;
        $this->stationRepository = $stationRepository;
        $this->areaGroupRepository = $areaGroupRepository;
        $this->categoryRepository = $categoryRepository;
        $this->sCityRepository = $sCityRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $station_count = $this->stationRepository->getTotalCount()->map(function($item) {
            $scitys = $this->sCityRepository->getAll()->pluck('city_cn','country_id')->toArray();
            return [
                'county_name'   => array_get($scitys, $item['county'],''),
                'count'         => $item['count'],
            ];
        })->toArray();

        return view('dashboard', [
            'user_total'          => $this->userRepository->getAllTotal(),
            'article_total'       => $this->articleRepository->getAllTotal(),
            'advertisement_total' => $this->advertisementRepository->getAllTotal(),
            'areagroup_total'     => $this->areaGroupRepository->getAllTotal(),
            'category_total'      => $this->categoryRepository->getAllTotal(),
            'station_total'       => $this->stationRepository->getAllTotal(),
            'station_count'       => $station_count
        ]);
    }

    public function sendEmail()
    {
        // \Mail::to(\Auth::user())->queue(new \App\Mail\LoginSuccessMail('testTitle'));
        dispatch(new \App\Jobs\SendReminderEmail(\Auth::user()));
        return 'success';
    }
}
