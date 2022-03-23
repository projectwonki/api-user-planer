<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PlanController;
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

Route::prefix('auth')->group(function () {

    Route::post('register', [AuthController::class, 'register']);
    
    Route::post('login', [AuthController::class, 'login']);

});

Route::prefix('user')->group(function () {

    Route::get('/plan', [PlanController::class, 'index'])->middleware('auth:api');

    Route::get('/plan/{id}', [PlanController::class, 'show']);

    Route::put('/plan/{id}', [PlanController::class, 'edit']);

    Route::post('/plan', [PlanController::class, 'store']);

    Route::delete('/plan/{id}', [PlanController::class, 'destroy']);

});