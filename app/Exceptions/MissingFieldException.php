<?php

namespace App\Exceptions;

use Exception;

class MissingFieldException extends Exception
{
    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    } 
}
