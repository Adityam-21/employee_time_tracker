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
        //dd($request->all());
        $validated = $request->validate([
            //'name' => 'required|string',
            //'email' => 'required|email|unique:employees,email',
            //'password' => 'required|string|confirmed',
            'department_id' => 'required',
            'project_id' => 'required',
            'subproject_id' => 'required',
            'date' => 'required|date|before_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);


        //if ($request->has('name') && $request->has('email') && $request->has('password')) {
        //    $employee = new Employee();
        //    $employee->name = $validated['name'];
        //    $employee->email = $validated['email'];
        //    $employee->password = bcrypt($validated['password']);
        //    $employee->save();
        //
        //    return redirect()->route('manager.logs')->with('success', 'Employee registered successfully!');
        //}

        $startTime = new DateTime($request->get('start_time'));
        $endTime = new DateTime($request->get('end_time'));
        $totalHrs = $startTime->diff($endTime);
        // dd($totalHrs);
        $status = TimeLog::create([
            'employee_id' => Auth::id(),
            'department' => $request->department_id,
            'project' => $request->project_id,
            'subproject' => $request->subproject_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'time' => \Carbon\Carbon::now()->format('h:i:s'),
            'total_hours' => $totalHrs->format('%H:%I')


            //'logged_manually' => true,
        ]);

        return redirect()->route('employee.dashboard')->with('success', 'Time log added!');
    }


    public function dashboard()
    {

        $logs = TimeLog::with(['user', 'employee'])
            ->select('time_logs.*', 'departments.name as department_name', 'projects.name as project_name', 'subprojects.name as subproject_name')
            ->leftJoin('departments', 'time_logs.department', '=', 'departments.id')
            ->leftJoin('projects', 'time_logs.project', '=', 'projects.id')
            ->leftJoin('subprojects', 'time_logs.subproject', '=', 'subprojects.id')
            ->join('users', 'time_logs.employee_id', '=', 'users.id')
            ->where('users.role', 'employee')->get();

            

        return view('employee.dashboard', compact('logs'));
    }


    public function index(Request $request)
    {
        $employees = Employee::all();
        $logs = TimeLog::with('employee')->get();

        return view('manager.logs', compact('employees', 'logs'));
    }
}
