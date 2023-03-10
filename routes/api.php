<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Problems\CountOfNumbers;
use App\Http\Controllers\Problems\StepNumber;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {

    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    // Route::post('refresh', 'AuthController@refresh');
    // Route::post('me', 'AuthController@me');
});

Route::middleware('auth:api')->group(function () {
    Route::apiResource('users', UserController::class);
});

// problem solving APIs
Route::get('count-of-numbers', [CountOfNumbers::class, 'count']);
Route::get('steps-number', [StepNumber::class, 'calcStepsToReduceNumberToZero']);