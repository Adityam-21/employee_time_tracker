<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Database\Capsule\Manager;

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:manager'])->group(function () { //2 middlewares route grp
    Route::get('/manager/dashboard', [ManagerController::class, 'index'])->name('manager.dashboard');
    Route::get('/manager/logs', [ManagerController::class, 'index'])->name('manager.logs');
    Route::get('/manager/logs/export', [ManagerController::class, 'export'])->name('manager.logs.export');
    Route::get('/manager/logs/{id}/edit', [ManagerController::class, 'edit'])->name('manager.logs.edit');
    Route::put('/manager/update/{id}', [ManagerController::class, 'update'])->name('manager.update');

    Route::delete('/manager/logs/{id}', [ManagerController::class, 'destroy'])->name('manager.logs.destroy');
    Route::post('/employee/logs', [ManagerController::class, 'registerEmployee'])->name('employee.logs');
});

Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::get('/employee/dashboard', [EmployeeController::class, 'dashboard'])->name('employee.dashboard');
    Route::get('/employee/log-time', [EmployeeController::class, 'create'])->name('employee.log-time');
    Route::post('/employee/log-time', [EmployeeController::class, 'store'])->name('employeFe.log-time.store');
    Route::get('/employee/view-log', [EmployeeController::class, 'viewLogs'])->name('employee.view-log');
});


Route::get('/manager/{id}/edit', [ManagerController::class, 'edit'])->name('manager.edit');
Route::put('/manager/{id}', [ManagerController::class, 'update'])->name('manager.update');
Route::delete('/manager/{id}', [ManagerController::class, 'destroy'])->name('manager.destroy');


Route::get('/', function () { //anonymous funnction for some root URL
    return view('home');
});
