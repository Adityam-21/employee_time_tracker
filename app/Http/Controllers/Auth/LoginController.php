<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt login
        if (Auth::attempt($request->only('email', 'password'))) {
            return $this->authenticated($request, Auth::user());
        } else {
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        }
    }

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

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
