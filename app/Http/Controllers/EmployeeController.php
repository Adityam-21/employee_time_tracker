<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Project;
use App\Models\Subproject;
use App\Models\TimeLog;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DateTime;

class EmployeeController extends Controller
{

    public function create()
    {
        $departments = Department::all();
        $projects = Project::all();
        $subprojects = Subproject::all();

        return view('employee.log-time', compact('departments', 'projects', 'subprojects'));
    }


    public function getProjects(Department $department)
    {
        return response()->json($department->projects);
    }


    public function getSubprojects(Project $project)
    {
        return response()->json($project->subprojects);
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

        $startTime = new DateTime($request->get('start_time'));
        $endTime = new DateTime($request->get('end_time'));
        $totalHrs = $startTime->diff($endTime);

        TimeLog::create([
            'employee_id' => Auth::id(),
            'department' => $request->department_id,
            'project' => $request->project_id,
            'subproject' => $request->subproject_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'time' => Carbon::now()->format('H:i:s'),
            'total_hours' => $totalHrs->format('%H:%I')
        ]);

        return redirect()->route('employee.dashboard')->with('success', 'Time log added successfully!');
    }


    public function dashboard()
    {
        $logs = TimeLog::select(
            'time_logs.*',
            'departments.name as department_name',
            'projects.name as project_name',
            'subprojects.name as subproject_name',
            'users.name as employee_name'
        )
            ->join('departments', 'time_logs.department', '=', 'departments.id')
            ->join('projects', 'time_logs.project', '=', 'projects.id')
            ->join('subprojects', 'time_logs.subproject', '=', 'subprojects.id')
            ->join('users', 'time_logs.employee_id', '=', 'users.id')
            ->where('time_logs.employee_id', Auth::id())
            ->orderBy('time_logs.date', 'desc')
            ->orderBy('time_logs.start_time', 'desc')
            ->get();

        return view('employee.dashboard', compact('logs'));
    }


    public function index(Request $request)
    {
        $employees = Employee::all();
        $logs = TimeLog::with('employee')->get();

        return view('manager.logs', compact('employees', 'logs'));
    }
}
