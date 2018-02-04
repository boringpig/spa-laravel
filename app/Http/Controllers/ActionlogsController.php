<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ActionlogRepository;
use App\Transformers\ActionlogTransformer;
use Illuminate\Support\Facades\Route;

class ActionlogsController extends Controller
{
    protected $actionlogRepository;
    protected $actionlogTransformer;

    public function __construct(
        ActionlogRepository $actionlogRepository,
        ActionlogTransformer $actionlogTransformer
    ) {
        $this->middleware(['auth','role.auth']);
        $this->actionlogRepository = $actionlogRepository;
        $this->actionlogTransformer = $actionlogTransformer;
    }

    public function index()
    {
        $actionlogs = $this->actionlogRepository->getAll(config('website.perPage'));
        $actionlogs = (count($actionlogs) > 0)? $this->actionlogTransformer->transform($actionlogs)->setPath("/".Route::current()->uri()) : [];
        return view('actionlogs.index', [
            'actionlogs'   => $actionlogs,
        ]);
    }

    public function search(Request $request)
    {
        $actionlogs = $this->actionlogRepository->getByArgs($request->all(), config('website.perPage'));
        $actionlogs = (count($actionlogs) > 0)? $this->actionlogTransformer->transform($actionlogs)->setPath("/".Route::current()->uri()) : [];
        $request->flash();
        return view('actionlogs.index', [
            'actionlogs'   => $actionlogs,
        ]);
    }
}