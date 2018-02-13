<?php

namespace App\Exceptions;

class ExpectsJsonException extends ApiExceptionHandler
{
    public function __construct($errMessage = 'Request must be json!', $errCode = 'E9905')
    {
        $this->errCode = $errCode;
        $this->errMessage = $errMessage;
    }
}
