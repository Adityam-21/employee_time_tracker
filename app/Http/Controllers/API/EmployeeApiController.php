<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Project;
use App\Models\Subproject;
use App\Models\TimeLog;
use Illuminate\Support\Facades\Auth;

class EmployeeApiController extends Controller
{
    public function logTime(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'project_id' => 'required|exists:projects,id',
            'subproject_id' => 'required|exists:subprojects,id',
            'work_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $log = new TimeLog($validated);
        $log->employee_id = Auth::id();
        $log->save();

        return response()->json(['message' => 'Log created successfully', 'log' => $log]);
    }

    public function myLogs()
    {
        $logs = TimeLog::where('employee_id', Auth::id())->get();
        return response()->json($logs);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([

            'department_id' => 'required',
            'project_id' => 'required',
            'subproject_id' => 'required',
            'date' => 'required|date|before_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);
    }
}
