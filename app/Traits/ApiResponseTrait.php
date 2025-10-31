<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    protected function success($data = null, string $message = null): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    protected function conflict($errors = null, string $message = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], 409, [], JSON_UNESCAPED_UNICODE);
    }

    protected function notValid($errors = null, string $message = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], 422, [], JSON_UNESCAPED_UNICODE);
    }

    protected function noContent(): JsonResponse
    {
        return response()->json(null, 404);
    }
}
