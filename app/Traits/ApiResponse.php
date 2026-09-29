<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * Build a success response
     *
     * @return JsonResponse
     */
    protected function successResponse(string $message, mixed $data = [], int $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * Build an error response
     *
     * @return JsonResponse
     */
    protected function errorResponse(string $message, mixed $errors = [], int $code = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }
}
