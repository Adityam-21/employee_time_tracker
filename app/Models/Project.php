<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function department()
    {
        return $this->belongsTo(Department::class);//many to one / child to parent
    }

    public function subprojects()
    {
        return $this->hasMany(Subproject::class);
    }
}
