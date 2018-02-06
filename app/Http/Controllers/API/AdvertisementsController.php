<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\AdvertisementRepository;
use App\Transformers\API\AdvertisementTransformer;

class AdvertisementsController extends Controller
{
    private $advertisementRepository;
    private $advertisementTransformer;

    public function __construct(
        AdvertisementRepository $advertisementRepository,
        AdvertisementTransformer $advertisementTransformer
    ) {
        $this->advertisementRepository = $advertisementRepository;
        $this->advertisementTransformer = $advertisementTransformer;
    }

    public function index(Request $request)
    {
        $args = $request->all();
        $args['status'] = 1;
        $advertisements = $this->advertisementRepository->getByArgs($args);
        $advertisements = (count($advertisements) > 0)? $this->advertisementTransformer->transform($advertisements)->toArray() : [];
        return response()->json(successOutput($advertisements), 200);
    }
}
