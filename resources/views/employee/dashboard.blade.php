@extends('layout')
@section('title', 'Employee Dashboard')
@section('content')
    <h2 class="text-xl font-bold mb-4">Welcome Employee: {{ Auth::user()->name }}</h2>
    <p>Log your work hours below.</p>
@endsection
