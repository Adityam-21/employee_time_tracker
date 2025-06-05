@extends('layout')
@section('title', 'Welcome')
@section('content')
<div class="text-center mt-12">
    <h1 class="text-3xl font-bold">Welcome to the Employee Time Tracker</h1>
    <p class="text-gray-600 mt-2">Please <a href="{{ route('login') }}" class="text-blue-600">Login</a> or <a href="{{ route('register') }}" class="text-green-600">Register</a></p>
</div>
@endsection
