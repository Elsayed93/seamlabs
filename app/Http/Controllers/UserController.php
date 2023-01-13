<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

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


    public function update(Request $request, User $user)
    {
        $data =  $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => ['required', Password::min(6)->mixedCase()],
            'date_of_birth' => 'required|date',
            'phone' => 'required|regex:/(01)[0-9]{9}/|max:11'
        ]);
        
        $data['date_of_birth'] = formatDate($request->date_of_birth);

        $user->update($data);
        return $this->apiResponse(new UserResource($user));
    }
}
