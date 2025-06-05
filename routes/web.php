<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\EmployeeController;

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:manager'])->group(function () {
    Route::get('/manager/dashboard', [ManagerController::class, 'index'])->name('manager.dashboard');
    Route::get('/manager/logs', [ManagerController::class, 'index'])->name('manager.logs');
    Route::get('/manager/logs/export', [ManagerController::class, 'export'])->name('manager.logs.export');
    Route::get('/manager/logs/{id}/edit', [ManagerController::class, 'edit'])->name('manager.logs.edit');
    Route::put('/manager/logs/{id}', [ManagerController::class, 'update'])->name('manager.logs.update');
    Route::delete('/manager/logs/{id}', [ManagerController::class, 'destroy'])->name('manager.logs.destroy');
});

Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::get('/employee/dashboard', [EmployeeController::class, 'index'])->name('employee.dashboard');
});

Route::get('/employee/log-time', [EmployeeController::class, 'logTimeForm'])->name('employee.logTimeForm');
Route::post('/employee/log-time', [EmployeeController::class, 'storeLog'])->name('employee.storeLog');

Route::get('/employee/logs', [EmployeeController::class, 'viewLogs'])->name('employee.logs');

Route::get('/projects/{department}', [EmployeeController::class, 'getProjects']);
Route::get('/subprojects/{project}', [EmployeeController::class, 'getSubprojects']);

Route::get('/', function () {
    return view('home');
});
