@extends('layout')
@section('title', 'Employee Dashboard')

@section('content')
    <h2 class="text-xl font-bold mb-4">Welcome Employee: {{ Auth::user()->name }}</h2>
    <p class="mb-6">Your Logged Hours</p>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

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
                    <td class="px-4 py-2">{{ $log->department_name ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $log->project_name ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $log->subproject_name ?? 'N/A' }}</td>
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

    <a href="{{ route('employee.log-time') }}">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">
            Log New Work Hours
        </button>
    </a>
@endsection
