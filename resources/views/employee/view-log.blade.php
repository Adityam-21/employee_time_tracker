@extends('layout')
@section('title', 'Your Time Logs')
@section('content')
    <h2 class="text-xl font-bold mb-4">Your Logged Hours</h2>

    @if (session('success'))
        <div class="bg-green-200 p-2 rounded mb-4 text-green-800">{{ session('success') }}</div>
    @endif

    <table class="w-full border text-left">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2">Date</th>
                <th class="p-2">Start</th>
                <th class="p-2">End</th>
                <th class="p-2">Department</th>
                <th class="p-2">Project</th>
                <th class="p-2">Subproject</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
                <tr class="border-t">
                    <td class="p-2">{{ $log->date }}</td>
                    <td class="p-2">{{ $log->start_time }}</td>
                    <td class="p-2">{{ $log->end_time }}</td>
                    <td class="p-2">{{ $log->department->name }}</td>
                    <td class="p-2">{{ $log->project->name }}</td>
                    <td class="p-2">{{ $log->subproject->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
