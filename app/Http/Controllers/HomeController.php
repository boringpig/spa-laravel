<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\ArticleRepository;
use App\Repositories\AdvertisementRepository;
use App\CPS\Repositories\StationRepository;

class HomeController extends Controller
{
    protected $userRepository;
    protected $articleRepository;
    protected $advertisementRepository;
    protected $stationRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository,
                                ArticleRepository $articleRepository,
                                AdvertisementRepository $advertisementRepository,
                                StationRepository $stationRepository
    ) {
        $this->middleware('auth');
        $this->userRepository = $userRepository;
        $this->articleRepository = $articleRepository;
        $this->advertisementRepository = $advertisementRepository;
        $this->stationRepository = $stationRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $station_count = collect($this->stationRepository->getTotalCount());
        $areas = getSCityAreaArray();
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
            'station_count'       => $station_count
        ]);
    }
}
