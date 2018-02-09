<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\AreaGroupRepository;
use App\CPS\Repositories\SCityRepository;
use App\Transformers\API\AreaGroupTransformer;

class AreaGroupsController extends Controller
{
    protected $areaGroupRepository;
    protected $areaGroupTransformer;
    protected $sCityRepository;

    public function __construct(
        AreaGroupRepository $areaGroupRepository,
        AreaGroupTransformer $areaGroupTransformer,
        SCityRepository $sCityRepository
    ) {
        $this->areaGroupRepository = $areaGroupRepository;
        $this->areaGroupTransformer = $areaGroupTransformer;
        $this->sCityRepository = $sCityRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $groups = $this->areaGroupRepository->getByArgs($request->all());
        if(count($groups) > 0) {
            $groups = $this->areaGroupTransformer->transform($groups);
        } else {
            $groups = $this->sCityRepository->getByArgs($request->all())->map(function($item) {
                $area = "{$item['province']}{$item['country_id']}";
                return [
                    'parent_area'   => $area,
                    'child_area'    => [$area]
                ];
            })->toArray();
        }

        return response()->json(successOutput($groups),200);
    }
}
