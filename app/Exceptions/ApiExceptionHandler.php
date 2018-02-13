<?php

namespace App\Exceptions;

use Illuminate\Contracts\Support\Responsable;

class ApiExceptionHandler extends \Exception implements Responsable
{
    protected $errCode;
    protected $errMessage;

    public function getErrCode()
    {
        return $this->errCode;
    }

    public function getErrMessage()
    {
        return $this->errMessage;
    }

    public function toResponse($request)
    {
        return response()->json([
            'RetCode' => 0,
            'RetMsg'  => $this->getErrMessage(),
        ]);
    }
}
