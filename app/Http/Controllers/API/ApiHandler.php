<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ApiHandler extends Controller
{
    /**
     * Get response
     *
     * @param mixed $data
     * @param string $message
     * @param string $status
     * @return JsonResponse
     */
    public function getResponse($data, string $message, string $status): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => $status
        ]);
    }
}
