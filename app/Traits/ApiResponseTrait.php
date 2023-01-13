<?php

namespace App\Traits;

trait ApiResponseTrait
{
    public function apiResponse($data = null, $error = null, $code = 200)
    {
        $array = [
            'data' => $data,
            'message' => $error,
            'status' => in_array($code, $this->successCode()) ? true : false
        ];

        return response($array, $code);
    }

    public function successCode()
    {
        return [200, 201, 202];
    }

    public function notFoundResponse()
    {
        return $this->apiResponse(null, 'Not Found!', 404);
    }

    //unKnown Error Functio
    public function unknownError()
    {
        return $this->apiResponse(null, 'UnKnown Error', 400);
    }

    //success response for Delete post
    function deleteResponse()
    {
        return $this->apiResponse(true, 'deleted was succeded', 200);
    }
}
