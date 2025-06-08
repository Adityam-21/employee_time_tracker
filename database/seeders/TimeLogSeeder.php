<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TimeLog;
use App\Models\User;
use Carbon\Carbon;

class TimeLogSeeder extends Seeder
{
    public function run(): void
    {
        // Get an employee user
        $employee = User::where('role', 'employee')->first();

        // If no employee exists, create one
        if (!$employee) {
            $employee = User::create([
                'name' => 'Dummy Employee',
                'email' => 'employee@example.com',
                'password' => bcrypt('password'),
                'role' => 'employee',
            ]);
        }

        // Insert dummy logs
        TimeLog::create([
            'employee_id' => $employee->id,
            'date' => Carbon::now()->format('Y-m-d'),
            'department' => 'Engineering',
            'project' => 'Time Tracker App',
            'subproject' => 'Backend',
            'time' => '02:30',
            'total_hours' => 2.5,
        ]);
    }
}
