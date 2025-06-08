<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show register page
    public function showRegister()
    {
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:employee,manager'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => ucfirst($request->role),
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('login')->with('success', 'Account created!');
    }

    // Show login page
    public function showLogin()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return $this->authenticated($request, Auth::user());
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    // Handle logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    // Role-based redirect after login
    protected function authenticated(Request $request, $user)
    {
        if (strcasecmp($user->role, 'Manager') === 0) {
            return redirect()->route('manager.logs');
        }

        if (strcasecmp($user->role, 'Employee') === 0) {
            return redirect()->route('employee.dashboard');
        }

        return redirect('/home');
    }
}
