<?php

namespace App\Shared\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Shared\Exceptions\ValidationException;
use Illuminate\Contracts\Validation\Validator;

abstract class ApplicationRequest extends FormRequest
{
    abstract protected function getFailedValidationMessage(): string;

    protected function failedValidation(Validator $validator): void
    {
        throw new ValidationException($this->getFailedValidationMessage());
    }
}
