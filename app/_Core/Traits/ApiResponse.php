<?php

namespace App\_Core\Traits;

trait ApiResponse
{
    protected function success($data, $message = 'OK', $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data
        ], $code);
    }

    protected function error($message = 'Error', $code = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data'    => null
        ], $code);
    }
}
