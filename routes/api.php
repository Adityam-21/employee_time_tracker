<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\API\EmployeeApiController;
use App\Http\Controllers\API\ManagerApiController;


Route::post('register', [ApiController::class, 'register']);
Route::post('login', [ApiController::class, 'login']);


Route::middleware('auth:api')->group(function () {

    //Utility
    Route::post('refresh', [ApiController::class, 'refresh']);
    Route::get('me', [ApiController::class, 'me']);
    Route::post('logout', [ApiController::class, 'logout']);

    //Employee
    Route::post('/log-time', [EmployeeApiController::class, 'logTime']);
    Route::get('/my-logs', [EmployeeApiController::class, 'myLogs']);

    //Manager
    Route::get('/logs', [ManagerApiController::class, 'getAllLogs']);
    Route::post('/register-employee', [ManagerApiController::class, 'registerEmployee']);
});
