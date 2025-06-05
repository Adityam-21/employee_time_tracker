<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subproject extends Model
{
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
