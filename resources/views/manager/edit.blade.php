@extends('layout')
@section('title', 'Edit Log')

@section('content')
    <h2 class="text-xl font-bold mb-4">Edit Log Entry</h2>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('manager.update', $log->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium">Date:</label>
            <input type="date" name="date" value="{{ $log->date }}" class="border p-2 rounded w-full" required>
        </div>

        <div>
            <label class="block font-medium">Time:</label>
            <input type="text" name="time" value="{{ $log->time }}" class="border p-2 rounded w-full" required>
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>

            <a href="{{ route('manager.logs') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Back to Logs</a>
        </div>
    </form>
@endsection
