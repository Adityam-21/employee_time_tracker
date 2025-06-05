@extends('layout')
@section('title', 'Edit Log')
@section('content')
    <h2 class="text-xl font-bold mb-4">Edit Log</h2>

    <form method="POST" action="{{ route('manager.logs.update', $log->id) }}" class="space-y-4">
        @csrf @method('PUT')

        <div>
            <label class="block font-semibold">Employee:</label>
            <p>{{ $log->user->name }}</p>
        </div>

        <div>
            <label class="block font-semibold">Subproject:</label>
            <p>{{ $log->subproject->name }}</p>
        </div>

        <div>
            <label class="block font-semibold">Date:</label>
            <p>{{ $log->date }}</p>
        </div>

        <input type="time" name="start_time" value="{{ $log->start_time }}" class="border p-2 rounded" required>
        <input type="time" name="end_time" value="{{ $log->end_time }}" class="border p-2 rounded" required>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
    </form>
@endsection
