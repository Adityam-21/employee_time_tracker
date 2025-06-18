@extends('layout')

@section('title', 'Manager Dashboard')

@section('content')
    <h2 class="text-xl font-bold mb-4">Welcome Manager: {{ Auth::user()->name }}</h2>
    <p>Manage employee time logs below.</p>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
