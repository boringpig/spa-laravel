<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\CPS\Repositories\SCityAreaRepository;

class SCityAreaComposer
{
    private $areas = [];

    public function __construct(SCityAreaRepository $sCityAreaRepository)
    {
        $this->areas = $sCityAreaRepository->getPluckAreaArray();
    }

    public function compose(View $view)
    {
        $view->with('areas', $this->areas);
    }
}