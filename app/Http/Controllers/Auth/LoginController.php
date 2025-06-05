<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Other methods...

    protected function authenticated(Request $request, $user)
    {
        if ($user->role === 'manager') {
            return redirect()->route('manager.logs');
        }

        if ($user->role === 'employee') {
            return redirect()->route('employee.dashboard');
        }

        // Default fallback
        return redirect('/home');
    }
}
