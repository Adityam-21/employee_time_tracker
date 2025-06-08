@extends('layout')
@section('title', 'Manage Logs')

@section('content')
    <h2 class="text-xl font-bold mb-4">Register New Employee</h2>

    {{-- Employee Registration Form --}}
    <form action="{{ route('employee.logs') }}" method="POST" class="mb-6 grid grid-cols-4 gap-4 items-end">
        @csrf
        <div>
            <label for="name" class="block font-medium">Name:</label>
            <input type="text" name="name" id="name" class="border p-2 rounded w-full" required>
        </div>

        <div>
            <label for="email" class="block font-medium">Email:</label>
            <input type="email" name="email" id="email" class="border p-2 rounded w-full" required>
        </div>

        <div>
            <label for="password" class="block font-medium">Password:</label>
            <input type="password" name="password" id="password" class="border p-2 rounded w-full" required>
        </div>

        <div>
            <label for="password_confirmation" class="block font-medium">Confirm Password:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="border p-2 rounded w-full"
                required>
        </div>

        <div class="col-span-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Register Employee</button>
        </div>
    </form>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    <h2 class="text-xl font-bold mb-4">All Employee Time Logs</h2>

    {{-- Filters --}}
    <form method="GET" class="grid grid-cols-4 gap-4 mb-4">
        <select name="employee_id" id="employee" class="form-control border p-2 rounded">
            <option value="">All Employees</option>
            @foreach ($employees as $employee)
                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
            @endforeach
        </select>

        <select name="subproject_id" class="border p-2 rounded">
            <option value="">All Subprojects</option>
            @foreach ($departments as $dept)
                @foreach ($dept->projects as $proj)
                    @foreach ($proj->subprojects as $sub)
                        <option value="{{ $sub->id }}">
                            {{ $dept->name }} > {{ $proj->name }} > {{ $sub->name }}
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

    {{-- Logs Table --}}
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
                <tr>
                    <td class="p-2">{{ $log->employee->name }}</td>
                    <td class="p-2">{{ $log->date }}</td>
                    <td class="p-2">{{ $log->department_name }}</td>
                    <td class="p-2">{{ $log->project_name }}</td>
                    <td class="p-2">{{ $log->subproject_name ?? '' }}</td>
                    <td class="p-2">{{ $log->time }}</td>
                    <td class="p-2">{{ $log->total_hours }}</td>
                    <td class="p-2">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
