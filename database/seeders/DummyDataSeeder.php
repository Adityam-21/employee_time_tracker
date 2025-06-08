<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TimeLog;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TimeLog::create([
            'user_id' => 2,
            'date' => now(),
            'department' => 'Development',
            'project' => 'Time Tracker',
            'subproject' => 'Export Feature',
            'time' => 3,
            'total' => 3
        ]);

        TimeLog::create([
            'user_id' => 3,
            'date' => now(),
            'department' => 'QA',
            'project' => 'Time Tracker',
            'subproject' => 'Testing',
            'time' => 4,
            'total' => 4
        ]);
    }
}
