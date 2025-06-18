@extends('layout')

@section('title', 'Employee Dashboard')

@section('content')
    <div class="max-w-6xl mx-auto bg-black p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-4 text-blue-700">Welcome, {{ auth()->user()->name }}</h2>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('employee.log-time') }}" method="GET" class="mb-6">
            <label for="date" class="block mb-2 text-sm font-medium text-gray-700">Select Date</label>
            <input type="date" id="date" name="date" value="{{ request('date') }}" max="{{ date('Y-m-d') }}"
                class="w-full px-4 py-2 border rounded text-black" required>

            <button type="submit" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">
                Log Time
            </button>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-black border">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="px-4 py-2 border">Date</th>
                        <th class="px-4 py-2 border">Department</th>
                        <th class="px-4 py-2 border">Project</th>
                        <th class="px-4 py-2 border">Subproject</th>
                        <th class="px-4 py-2 border">Start Time</th>
                        <th class="px-4 py-2 border">End Time</th>
                        <th class="px-4 py-2 border">Total Hours</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border text-center">
                                {{ \Carbon\Carbon::parse($log->date)->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 border text-center">{{ $log->department_name }}</td>
                            <td class="px-4 py-2 border text-center">{{ $log->project_name }}</td>
                            <td class="px-4 py-2 border text-center">{{ $log->subproject_name }}</td>
                            <td class="px-4 py-2 border text-center">
                                {{ \Carbon\Carbon::parse($log->start_time)->format('H:i') }}</td>
                            <td class="px-4 py-2 border text-center">
                                {{ \Carbon\Carbon::parse($log->end_time)->format('H:i') }}</td>
                            <td class="px-4 py-2 border text-center">{{ $log->total_hours }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-4 border text-center text-black-500">No logs available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($logs->count() > 0)
            <div class="mt-4 text-sm text-black-600">
                Total Records: {{ $logs->count() }}
            </div>
        @endif
    </div>
@endsection
