<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponseTrait;

class UserController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        return $this->apiResponse(UserResource::collection(User::paginate())->response()->getData(true));
    }

    public function show(User $user)
    {
        return $this->apiResponse(new UserResource($user));
    }


    public function update(UserRequest $request, User $user)
    {
        $data =  $request->validated();

        $data['date_of_birth'] = formatDate($request->date_of_birth);

        $user->update($data);
        return $this->apiResponse(new UserResource($user), 'Updated Successfully');
    }


    public function destroy(User $user)
    {
        $user->delete();
        return $this->apiResponse(null, 'User Deleted Successfully');
    }
}
