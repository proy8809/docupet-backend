<?php

namespace App\Shared\Controllers;

use JsonSerializable;
use Illuminate\Http\JsonResponse;

abstract class Controller
{
    /**
     * @param JsonSerializable|array<int|string,mixed> $body
     */
    public function ok(JsonSerializable|array $body): JsonResponse
    {
        return response()->json($body, 200);
    }

    /**
     * @param JsonSerializable|array<int|string,mixed> $body
     */
    public function saved(JsonSerializable|array $body): JsonResponse
    {
        return response()->json($body, 201);
    }
}