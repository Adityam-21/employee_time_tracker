<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // If you're storing hashed passwords
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relationships
    public function logs()
    {
        return $this->hasMany(TimeLog::class);
    }
}
