<?php

namespace App\Shared\Exceptions;

use App\Shared\Exceptions\ApplicationException;

class ValidationException extends ApplicationException
{
    private const CODE = 422;

    public function __construct(string $message)
    {
        parent::__construct($message, self::CODE);
    }
}
