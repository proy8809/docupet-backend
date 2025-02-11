<?php

namespace App\Shared\Exceptions;

class ResourceNotFoundException extends ApplicationException
{
    private const CODE = 404;

    public function __construct(string $message)
    {
        parent::__construct($message, self::CODE);
    }
}