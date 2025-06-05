<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Project;
use App\Models\Subproject;
use App\Models\TimeLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function logTimeForm()
    {
        $departments = Department::all();
        return view('employee.log-time', compact('departments'));
    }

    public function getProjects(Department $department)
    {
        return response()->json($department->projects);
    }

    public function getSubprojects(Project $project)
    {
        return response()->json($project->subprojects);
    }

    public function storeLog(Request $request)
    {
        $request->validate([
            'subproject_id' => 'required|exists:subprojects,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time'
        ]);

        $start = strtotime($request->start_time);
        $end = strtotime($request->end_time);
        $hours = round(($end - $start) / 3600, 2);

        TimeLog::create([
            'user_id' => Auth::id(),
            'subproject_id' => $request->subproject_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'total_hours' => $hours,
        ]);

        return redirect()->route('employee.logs')->with('success', 'Log submitted!');
    }

    public function viewLogs()
    {
        $logs = TimeLog::where('user_id', Auth::id())->with('subproject.project.department')->latest()->get();
        return view('employee.view-logs', compact('logs'));
    }
}
