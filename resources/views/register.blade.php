@extends('layout')
@section('title', 'Register')
@section('content')
    <h2 class="text-2xl mb-4">Register</h2>
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf
        <input name="name" placeholder="Name" class="w-full p-2 border rounded" required>
        <input type="email" name="email" placeholder="Email" class="w-full p-2 border rounded" required>
        <input type="password" name="password" placeholder="Password" class="w-full p-2 border rounded" required>
        <select name="role" class="w-full p-2 border rounded" required>
            <option value="">Select Role</option>
            <option value="employee">Employee</option>
            <option value="manager">Manager</option>
        </select>
        <button class="bg-blue-500 text-white px-4 py-2 rounded" type="submit">Register</button>
    </form>
@endsection
