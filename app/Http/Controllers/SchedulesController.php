<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ScheduleRepository;
use App\Transformers\ScheduleTransformer;
use Illuminate\Support\Facades\Route;

class SchedulesController extends Controller
{
    private $scheduleRepository;
    private $scheduleTransformer;

    public function __construct(
        ScheduleRepository $scheduleRepository,
        ScheduleTransformer $scheduleTransformer
    ) {
        $this->middleware(['auth','role.auth']);
        $this->scheduleRepository = $scheduleRepository;
        $this->scheduleTransformer = $scheduleTransformer;
    }

    public function index()
    {
        $commands = $this->scheduleRepository->getAll(config('website.perPage'));
        $commands = (count($commands) > 0)? $this->scheduleTransformer->transform($commands)->setPath("/".Route::current()->uri()) : [];
        return view('schedules.index', [
            'commands' => $commands
        ]);
    }
}