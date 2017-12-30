<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function successOutput($data)
    {
        return ['RetCode' => 1, 'RetVal' => $data];
    }

    public function errorOutput($message)
    {
        return ['RetCode' => 0, 'RetMsg' => $message];
    }
}
