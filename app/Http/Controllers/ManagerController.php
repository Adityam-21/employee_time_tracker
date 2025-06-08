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
    // EMPLOYEE REGISTRATION METHOD
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

        $logs = TimeLog::with(['user', 'employee'])->select('time_logs.*', 'departments.name as department_name', 'projects.name as project_name', 'subprojects.name as subproject_name')
            ->leftJoin('departments', 'time_logs.department', '=', 'departments.id')
            ->leftJoin('projects', 'time_logs.project', '=', 'projects.id')
            ->leftJoin('subprojects', 'time_logs.project', '=', 'subprojects.id')
            ->get();

        return view('manager.logs', compact('employees', 'departments', 'logs'));
    }

    public function logs()
    {
        $logs = TimeLog::with('employee')->get();
        return view('manager.logs', compact('logs'));
    }

    public function edit($id)
    {
        $log = TimeLog::with('subproject.project.department')->findOrFail($id);
        return view('manager.edit-log', compact('log'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        $log = TimeLog::findOrFail($id);
        $start = strtotime($request->start_time);
        $end = strtotime($request->end_time);
        $hours = round(($end - $start) / 3600, 2);

        $log->update([
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'total_hours' => $hours,
        ]);

        return redirect()->route('manager.logs')->with('success', 'Log updated.');
    }

    public function destroy($id)
    {
        TimeLog::findOrFail($id)->delete();
        return back()->with('success', 'Log deleted.');
    }

    public function export(Request $request)
    {
        $logs = TimeLog::with(['user', 'subproject', 'project', 'department', 'employee'])
            ->get();

        return Excel::download(new TimeLogsExport($logs), 'time_logs.csv');
    }
}
