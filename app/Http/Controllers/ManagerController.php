<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\TimeLog;
use App\Models\Department;
use App\Exports\TimeLogsExport;
use Maatwebsite\Excel\Facades\Excel;

class ManagerController extends Controller
{
    public function registerEmployee(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'employee',
        ]);

        return redirect()->back()->with('success', 'Employee registered successfully.');
    }

    public function index(Request $request)
    {
        $employees = User::where('role', 'employee')->get();
        $departments = Department::with('projects.subprojects')->get();

        $query = TimeLog::with(['user', 'employee'])
            ->select('time_logs.*', 'departments.name as department_name', 'projects.name as project_name', 'subprojects.name as subproject_name')
            ->leftJoin('departments', 'time_logs.department', '=', 'departments.id')
            ->leftJoin('projects', 'time_logs.project', '=', 'projects.id')
            ->leftJoin('subprojects', 'time_logs.subproject', '=', 'subprojects.id')
            ->join('users', 'time_logs.employee_id', '=', 'users.id')
            ->where('users.role', 'employee');

        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->filled('department_id')) {
            $query->where('department', $request->department_id);
        }

        if ($request->filled('project_id')) {
            $query->where('project', $request->project_id);
        }

        if ($request->filled('subproject_id')) {
            $query->where('subproject', $request->subproject_id);
        }

        if ($request->filled('from')) {
            $query->whereDate('date', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('date', '<=', $request->to);
        }

        $logs = $query->get();

        // ✅ Dynamic Chart Data for Total Hours per Employee
        $employeeHours = TimeLog::with('employee')
            ->selectRaw('employee_id, SUM(TIMESTAMPDIFF(HOUR, start_time, end_time)) as total_hours')
            ->groupBy('employee_id')
            ->get()
            ->map(function ($log) {
                return [
                    'name' => $log->employee->name,
                    'hours' => $log->total_hours
                ];
            });

        return view('manager.logs', compact('employees', 'departments', 'logs', 'employeeHours'));
    }

    public function logs()
    {
        $logs = TimeLog::with('employee')->get();
        return view('manager.logs', compact('logs'));
    }

    public function edit($id)
    {
        $log = TimeLog::findOrFail($id);
        return view('manager.edit', compact('log'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required|string',
        ]);

        $log = TimeLog::findOrFail($id);
        $log->date = $request->date;
        $log->time = $request->time;
        $log->save();

        return redirect()->route('manager.logs')->with('success', 'Log updated successfully.');
    }

    public function destroy($id)
    {
        $log = TimeLog::findOrFail($id);
        $log->delete();
        return back()->with('success', 'Log deleted.');
    }

    public function export(Request $request)
    {
        $query = TimeLog::with(['user', 'employee'])
            ->select('time_logs.*', 'departments.name as department_name', 'projects.name as project_name', 'subprojects.name as subproject_name')
            ->leftJoin('departments', 'time_logs.department', '=', 'departments.id')
            ->leftJoin('projects', 'time_logs.project', '=', 'projects.id')
            ->leftJoin('subprojects', 'time_logs.subproject', '=', 'subprojects.id')
            ->join('users', 'time_logs.employee_id', '=', 'users.id')
            ->where('users.role', 'employee');

        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->filled('department_id')) {
            $query->where('department', $request->department_id);
        }

        if ($request->filled('project_id')) {
            $query->where('project', $request->project_id);
        }

        if ($request->filled('subproject_id')) {
            $query->where('subproject', $request->subproject_id);
        }

        if ($request->filled('from')) {
            $query->whereDate('date', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('date', '<=', $request->to);
        }

        $logs = $query->get();

        return Excel::download(new TimeLogsExport($logs), 'time_logs.csv');
    }

    public function charts()
    {
        // Optional separate chart route
    }

    public function dashboard()
    {
        $employeeHours = TimeLog::with('employee')
            ->selectRaw('employee_id, SUM(TIMESTAMPDIFF(HOUR, start_time, end_time)) as total_hours')
            ->groupBy('employee_id')
            ->get()
            ->map(function ($log) {
                return [
                    'name' => $log->employee->name,
                    'hours' => $log->total_hours
                ];
            });

        return view('manager.dashboard', compact('employeeHours'));
    }
}
