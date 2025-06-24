<?php

namespace App\Listeners;

use App\Events\TimeLogsExportRequested;
use App\Exports\TimeLogsExport;
use App\Mail\ExportReadyMail;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Contracts\Queue\ShouldQueue;

class HandleTimeLogsExport implements ShouldQueue
{
    public function handle(TimeLogsExportRequested $event)
    {
        $filters = $event->filters;
        $email = $event->email;

        // Apply filters and get logs
        $query = \App\Models\TimeLog::with(['user'])
            ->leftJoin('departments', 'time_logs.department', '=', 'departments.id')
            ->leftJoin('projects', 'time_logs.project', '=', 'projects.id')
            ->leftJoin('subprojects', 'time_logs.subproject', '=', 'subprojects.id')
            ->leftJoin('users', 'time_logs.employee_id', '=', 'users.id')
            ->select(
                'time_logs.*',
                'departments.name as department_name',
                'projects.name as project_name',
                'subprojects.name as subproject_name',
                'users.name as employee_name'
            )
            ->where('users.role', 'employee');

        if (!empty($filters['employee_id'])) {
            $query->where('employee_id', $filters['employee_id']);
        }

        if (!empty($filters['department_id'])) {
            $query->where('department', $filters['department_id']);
        }

        if (!empty($filters['project_id'])) {
            $query->where('project', $filters['project_id']);
        }

        if (!empty($filters['subproject_id'])) {
            $query->where('subproject', $filters['subproject_id']);
        }

        if (!empty($filters['from'])) {
            $query->whereDate('date', '>=', $filters['from']);
        }

        if (!empty($filters['to'])) {
            $query->whereDate('date', '<=', $filters['to']);
        }

        $logs = $query->get();

        // Generate unique file name and path
        $fileName = 'time_logs_' . now()->format('Ymd_His') . '.xlsx';
        $filePath = 'exports/' . $fileName;

        // ✅ Store the file on the `public` disk
        Excel::store(new TimeLogsExport($logs), $filePath, 'public');

        // ✅ Generate public URL
        $publicUrl = asset('storage/exports/' . $fileName);

        // Send the export email with the download link
        Mail::to($email)->send(new ExportReadyMail($publicUrl));
    }
}
