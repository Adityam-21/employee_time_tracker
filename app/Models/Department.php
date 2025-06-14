<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public function projects()
    {
        return $this->hasMany(Project::class);//one to many
    }
}
