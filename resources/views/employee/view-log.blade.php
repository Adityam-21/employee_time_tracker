@extends('layout')
@section('title', 'Your Time Logs')
@section('content')
    <h2 class="text-xl font-bold mb-4">Your Logged Hours</h2>

    <table class="w-full border text-left">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2">Date</th>
                <th class="p-2">Department</th>
                <th class="p-2">Project</th>
                <th class="p-2">Subproject</th>
                <th class="p-2">Start</th>
                <th class="p-2">End</th>
                <th class="p-2">Total (hrs)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
                <tr class="border-t">
                    <td class="p-2">{{ $log->date }}</td>
                    <td class="p-2">{{ $log->subproject->project->department->name }}</td>
                    <td class="p-2">{{ $log->subproject->project->name }}</td>
                    <td class="p-2">{{ $log->subproject->name }}</td>
                    <td class="p-2">{{ $log->start_time }}</td>
                    <td class="p-2">{{ $log->end_time }}</td>
                    <td class="p-2">{{ $log->total_hours }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
