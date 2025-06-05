@extends('layout')
@section('title', 'Login')
@section('content')
    <h2 class="text-2xl mb-4">Login</h2>
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <input type="email" name="email" placeholder="Email" class="w-full p-2 border rounded" required>
        <input type="password" name="password" placeholder="Password" class="w-full p-2 border rounded" required>
        <button class="bg-green-600 text-white px-4 py-2 rounded" type="submit">Login</button>
    </form>
@endsection
