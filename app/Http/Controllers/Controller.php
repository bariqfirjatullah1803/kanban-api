<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

abstract class Controller
{
    /**
     * @param bool $success
     * @param int $status
     * @param array|Collection $data
     * @param string $message
     * @return JsonResponse
     */
    public function _apiResponse(bool $success = true, int $status = 200, array|Collection $data = [], string $message = 'ok'): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => $success,
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $status);
    }
}
