<?php

namespace App\Shared\Exceptions;

use Exception;
use Illuminate\Http\Response;

class ApplicationException extends Exception
{
    public function render(): Response
    {
        return response(["message" => $this->message], $this->getCode());
    }
}