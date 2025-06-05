<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TimeLog;
use App\Models\Department;
use App\Exports\TimeLogsExport;
use Maatwebsite\Excel\Facades\Excel;

class ManagerController extends Controller
{
    public function index(Request $request)
    {
        $employees = User::where('role', 'employee')->get();
        $departments = Department::with('projects.subprojects')->get();

        $logs = TimeLog::with('user', 'subproject.project.department')
            ->when($request->user_id, fn($q) => $q->where('user_id', $request->user_id))
            ->when($request->subproject_id, fn($q) => $q->where('subproject_id', $request->subproject_id))
            ->when($request->from, fn($q) => $q->whereDate('date', '>=', $request->from))
            ->when($request->to, fn($q) => $q->whereDate('date', '<=', $request->to))
            ->latest()
            ->get();

        return view('manager.logs', compact('employees', 'departments', 'logs'));
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
        $logs = TimeLog::with('user', 'subproject.project.department')
            ->when($request->user_id, fn($q) => $q->where('user_id', $request->user_id))
            ->when($request->subproject_id, fn($q) => $q->where('subproject_id', $request->subproject_id))
            ->when($request->from, fn($q) => $q->whereDate('date', '>=', $request->from))
            ->when($request->to, fn($q) => $q->whereDate('date', '<=', $request->to))
            ->latest()
            ->get();

        return Excel::download(new TimeLogsExport($logs), 'time_logs.csv');
    }
}
