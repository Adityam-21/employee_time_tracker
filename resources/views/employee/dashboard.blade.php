@extends('layout')
@section('title', 'Employee Dashboard')

@section('content')
    <h2 class="text-xl font-bold mb-4">Welcome Employee: {{ Auth::user()->name }}</h2>
    <p class="mb-6">Your Logged Hours</p>

    <table class="table-auto w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-gray-200 text-gray-700">
            <tr>
                <th class="px-4 py-2">Date</th>
                <th class="px-4 py-2">Department</th>
                <th class="px-4 py-2">Project</th>
                <th class="px-4 py-2">Subproject</th>
                <th class="px-4 py-2">Start</th>
                <th class="px-4 py-2">End</th>
                <th class="px-4 py-2">Total (hrs)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($log->date)->format('d M Y') }}</td>
                    <td class="px-4 py-2">{{ $log->subproject->project->department->name ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $log->subproject->project->name ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $log->subproject->name ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $log->start_time }}</td>
                    <td class="px-4 py-2">{{ $log->end_time }}</td>
                    <td class="px-4 py-2">{{ $log->total_hours }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-4 text-center text-gray-500">No logs found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
