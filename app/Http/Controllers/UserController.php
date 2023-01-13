<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        return $this->apiResponse(UserResource::collection(User::paginate())->response()->getData(true));
    }

    public function show($id)
    {
        $user = User::where('id', $id)->first();

        if (!$user) {
            return $this->apiResponse(null, 'This User is not exist', 404);
        }

        return $this->apiResponse(new UserResource($user));
    }
}
