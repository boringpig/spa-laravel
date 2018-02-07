<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\AreaGroupRepository;
use App\Transformers\API\AreaGroupTransformer;

class AreaGroupsController extends Controller
{
    protected $areaGroupRepository;
    protected $areaGroupTransformer;

    public function __construct(
        AreaGroupRepository $areaGroupRepository,
        AreaGroupTransformer $areaGroupTransformer
    ) {
        $this->areaGroupRepository = $areaGroupRepository;
        $this->areaGroupTransformer = $areaGroupTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $groups = $this->areaGroupRepository->getByArgs($request->all());
        $groups = (count($groups) > 0)? $this->areaGroupTransformer->transform($groups) : [];
        return response()->json(successOutput($groups),200);
    }
}
