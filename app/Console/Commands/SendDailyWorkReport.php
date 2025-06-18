<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TimeLog;
use App\Models\User;
use App\Mail\DailyWorkReportMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendDailyWorkReport extends Command
{
    protected $signature = 'report:dailywork';
    protected $description = 'Send daily work report to employees';

    public function handle()
    {
        $yesterday = Carbon::yesterday()->toDateString();

        $logs = TimeLog::get();
        // ->groupBy('employee_id');
        // dd($logs);
        foreach ($logs as $log) {
            $totalHours = 0;
            // foreach ($employeeLogs as $log) {
            $start = Carbon::parse($log->start_time);
            $end = Carbon::parse($log->end_time);
            $totalHours += $start->diffInHours($end);
            // }

            $employee = User::find($log->employee_id);
            // dd($employee);
            if ($employee && $employee->email) {
                // dd($employee);
                Mail::to($employee->email)->send(new DailyWorkReportMail($employee, $totalHours));
            }
        }

        $this->info('Daily work report emails sent successfully!');
    }
}
