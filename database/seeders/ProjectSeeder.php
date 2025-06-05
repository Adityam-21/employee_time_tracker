<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Department;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        $eng = Department::where('name', 'Engineering')->first();
        $mkt = Department::where('name', 'Marketing')->first();

        if (!$eng || !$mkt) {
            $this->command->error('One or more departments not found. Please seed DepartmentSeeder correctly.');
            return;
        }

        Project::create([
            'department_id' => $eng->id,
            'name' => 'Website Revamp'
        ]);

        Project::create([
            'department_id' => $eng->id,
            'name' => 'Mobile App'
        ]);

        Project::create([
            'department_id' => $mkt->id,
            'name' => 'SEO Optimization'
        ]);
    }
}
