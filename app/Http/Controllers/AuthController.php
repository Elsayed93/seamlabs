<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{

    use ApiResponseTrait;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }


    public function register(UserRequest $request)
    {
        $data = $request->validated();

        $data['password'] = Hash::make($request->password);
        $data['date_of_birth'] = formatDate($request->date_of_birth);

        $user = User::create($data);
        $credentials['email'] = $user->email;
        $credentials['password'] = $request->password;

        $token = $this->makeLogin($credentials);

        return $this->respondWithToken($token);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required|min:6',
            ],
        );

        // get user 
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return $this->apiResponse(null, 'Invalid Credentials', 422);
        }

        if (!Hash::check($request->password, $user->password)) {
            return $this->apiResponse(null, 'Invalid Credentials', 422);
        }

        $credentials = request(['email', 'password']);

        $token = $this->makeLogin($credentials);
        return $this->respondWithToken($token);
    }

    private function makeLogin($credentials)
    {
        if (!$token = auth('api')->attempt($credentials)) {
            return $this->apiResponse(null, 'Unauthorized', 401);
        }

        return $token;
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();
        return $this->apiResponse(null, 'Successfully logged out');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $user = auth('api')->user();
        $data['token'] = $token;
        $data['user'] = $user;

        return $this->apiResponse($data, "Welcome {$user->name} .. ");
    }
}
