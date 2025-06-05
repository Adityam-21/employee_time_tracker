<?php

namespace App\Exports;

use App\Models\TimeLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TimeLogsExport implements FromCollection, WithHeadings
{
    protected $logs;

    public function __construct($logs)
    {
        $this->logs = $logs;
    }

    public function collection()
    {
        return $this->logs->map(function ($log) {
            return [
                'Employee' => $log->user->name,
                'Date' => $log->date,
                'Department' => $log->subproject->project->department->name,
                'Project' => $log->subproject->project->name,
                'Subproject' => $log->subproject->name,
                'Start Time' => $log->start_time,
                'End Time' => $log->end_time,
                'Total Hours' => $log->total_hours,
            ];
        });
    }

    public function headings(): array
    {
        return ['Employee', 'Date', 'Department', 'Project', 'Subproject', 'Start Time', 'End Time', 'Total Hours'];
    }
}
