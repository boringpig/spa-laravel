<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\ArticleRepository;
use App\Repositories\AdvertisementRepository;
use App\Repositories\AreaGroupRepository;
use App\Repositories\CategoryRepository;
use App\CPS\Repositories\StationRepository;

class HomeController extends Controller
{
    protected $userRepository;
    protected $articleRepository;
    protected $advertisementRepository;
    protected $stationRepository;
    protected $areaGroupRepository;
    protected $categoryRepository;

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
        CategoryRepository $categoryRepository
    ) {
        $this->middleware('auth');
        $this->userRepository = $userRepository;
        $this->articleRepository = $articleRepository;
        $this->advertisementRepository = $advertisementRepository;
        $this->stationRepository = $stationRepository;
        $this->areaGroupRepository = $areaGroupRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 取得泉州全部場站的數量
        $station_count = collect($this->stationRepository->getTotalCount());
        $areas = getSCityAreaArray();
        $station_total = $station_count->sum('count');
        $station_count = $station_count->map(function ($item) use ($areas) {
            return [
                'area' => array_get($areas,$item['area'],""),
                'count' => array_get($item,'count',0),
            ];
        })->toArray();

        return view('dashboard', [
            'user_total'          => $this->userRepository->getAllTotal(),
            'article_total'       => $this->articleRepository->getAllTotal(),
            'advertisement_total' => $this->advertisementRepository->getAllTotal(),
            'areagroup_total'     => $this->areaGroupRepository->getAllTotal(),
            'category_total'      => $this->categoryRepository->getAllTotal(),
            'station_total'       => $station_total,
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
