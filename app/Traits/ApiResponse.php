<?php

namespace App\Traits;

trait ApiResponse
{
    /**
     * Success Response
     */
    public function successResponse($data = [], $message = 'Operation successful', $status = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    /**
     * Error Response
     */
    public function errorResponse($message = 'An error occurred', $errors = [], $status = 500)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
}
