<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\GoogleOAuthController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::prefix('/auth/google')->group(function () {
    Route::get('redirect', [GoogleOAuthController::class, 'redirect']);
    Route::get('callback', [GoogleOAuthController::class, 'callback']);
});


Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [ProfileController::class, 'me']);
    Route::patch('me', [ProfileController::class, 'update']);
    Route::patch('me/password', [ProfileController::class, 'updatePassword']);
    Route::delete('me', [ProfileController::class, 'destroy']);
});
