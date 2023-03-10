<?php

namespace App\Traits;

trait ApiResponseTrait
{
    public function apiResponse($data = null, $message = '', $error = null, $code = 200)
    {
        $array = [
            'data' => $data,
            'message' => $message,
            'error' => $error,
            'status' => in_array($code, $this->successCode()) ? true : false
        ];

        return response($array, $code);
    }

    public function successCode()
    {
        return [200, 201, 202];
    }
}
