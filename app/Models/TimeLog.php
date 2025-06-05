<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeLog extends Model
{
    public function subproject()
    {
        return $this->belongsTo(Subproject::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
