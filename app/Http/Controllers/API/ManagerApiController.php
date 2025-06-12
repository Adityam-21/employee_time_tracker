<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TimeLog;
use App\Models\Department;

class ManagerApiController extends Controller
{
    public function getAllLogs()
    {
        $logs = TimeLog::with('employee')->get();
        return response()->json($logs);
    }

    public function registerEmployee(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $employee = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'employee',
        ]);

        return response()->json(['message' => 'Employee registered successfully', 'user' => $employee]);
    }
}
