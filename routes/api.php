<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiController;

Route::post('register', [ApiController::class, 'register']);
Route::post('login', [ApiController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('refresh', [ApiController::class, 'refresh']);
    Route::get('me', [ApiController::class, 'me']);
    Route::post('logout', [ApiController::class, 'logout']);
});
