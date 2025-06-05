<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Subproject;

class SubprojectSeeder extends Seeder
{
    public function run()
    {
        $web = Project::where('name', 'Website Revamp')->first();
        $seo = Project::where('name', 'SEO Optimization')->first();

        Subproject::insert([
            ['project_id' => $web->id, 'name' => 'Frontend Module'],
            ['project_id' => $web->id, 'name' => 'Backend Module'],
            ['project_id' => $seo->id, 'name' => 'Keyword Research']
        ]);
    }
}
