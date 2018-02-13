<?php

namespace App\Exceptions;

class InvalidTokenException extends ApiExceptionHandler
{
    public function __construct($errMessage = 'invalid token', $errCode = 'E9905')
    {
        $this->errCode = $errCode;
        $this->errMessage = $errMessage;
    }
}
