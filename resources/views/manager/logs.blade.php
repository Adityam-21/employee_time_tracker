@extends('layout')
@section('title', 'Manage Logs')
@section('content')
    <h2 class="text-xl font-bold mb-4">All Employee Time Logs</h2>

    <form method="GET" class="grid grid-cols-4 gap-4 mb-4">
        <select name="user_id" class="border p-2 rounded">
            <option value="">All Employees</option>
            @foreach ($employees as $e)
                <option value="{{ $e->id }}">{{ $e->name }}</option>
            @endforeach
        </select>

        <select name="subproject_id" class="border p-2 rounded">
            <option value="">All Subprojects</option>
            @foreach ($departments as $dept)
                @foreach ($dept->projects as $proj)
                    @foreach ($proj->subprojects as $sub)
                        <option value="{{ $sub->id }}">{{ $dept->name }} > {{ $proj->name }} > {{ $sub->name }}
                        </option>
                    @endforeach
                @endforeach
            @endforeach
        </select>

        <input type="date" name="from" class="border p-2 rounded" placeholder="From Date">
        <input type="date" name="to" class="border p-2 rounded" placeholder="To Date">

        <button class="bg-green-600 text-white px-4 py-2 rounded col-span-1">Filter</button>
        <a href="{{ route('manager.logs.export', request()->query()) }}"
            class="bg-blue-600 text-white px-4 py-2 rounded text-center col-span-1">Export CSV</a>
    </form>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    <table class="w-full text-left border">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-2">Employee</th>
                <th class="p-2">Date</th>
                <th class="p-2">Department</th>
                <th class="p-2">Project</th>
                <th class="p-2">Subproject</th>
                <th class="p-2">Time</th>
                <th class="p-2">Total</th>
                <th class="p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
                <tr class="border-t">
                    <td class="p-2">{{ $log->user->name }}</td>
                    <td class="p-2">{{ $log->date }}</td>
                    <td class="p-2">{{ $log->subproject->project->department->name }}</td>
                    <td class="p-2">{{ $log->subproject->project->name }}</td>
                    <td class="p-2">{{ $log->subproject->name }}</td>
                    <td class="p-2">{{ $log->start_time }} - {{ $log->end_time }}</td>
                    <td class="p-2">{{ $log->total_hours }}</td>
                    <td class="p-2 space-x-2">
                        <a href="{{ route('manager.logs.edit', $log->id) }}" class="text-blue-600">Edit</a>
                        <form action="{{ route('manager.logs.destroy', $log->id) }}" method="POST" class="inline-block">
                            @csrf @method('DELETE')
                            <button class="text-red-600" onclick="return confirm('Delete this log?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
