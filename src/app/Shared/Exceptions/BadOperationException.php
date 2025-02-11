<?php

namespace App\Shared\Exceptions;

class BadOperationException extends ApplicationException
{
    private const CODE = 400;

    public function __construct(string $message)
    {
        parent::__construct($message, self::CODE);
    }
}