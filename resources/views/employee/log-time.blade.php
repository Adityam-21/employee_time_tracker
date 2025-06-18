@extends('layout')

@section('title', 'Log Time')

@section('content')
    <div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-6 text-blue-700">Log Your Time</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('employee.log-time.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="date" class="block mb-2 text-sm font-medium text-gray-700">Date</label>
                <input type="date" name="date" id="date" value="{{ request('date', date('Y-m-d')) }}"
                    class="w-full px-4 py-2 border rounded text-black" required>
            </div>

            <div class="mb-4">
                <label for="department_id" class="block mb-2 text-sm font-medium text-gray-700">Department</label>
                <select name="department_id" id="department_id" class="w-full px-4 py-2 border rounded text-black" required>
                    <option value="">Select Department</option>
                    @foreach ($departments as $dept)
                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="project_id" class="block mb-2 text-sm font-medium text-gray-700">Project</label>
                <select name="project_id" id="project_id" class="w-full px-4 py-2 border rounded text-black" required>
                    <option value="">Select Project</option>
                    @foreach ($projects as $proj)
                        <option value="{{ $proj->id }}">{{ $proj->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="subproject_id" class="block mb-2 text-sm font-medium text-gray-700">Subproject</label>
                <select name="subproject_id" id="subproject_id" class="w-full px-4 py-2 border rounded text-black" required>
                    <option value="">Select Subproject</option>
                    @foreach ($subprojects as $sub)
                        <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="start_time" class="block mb-2 text-sm font-medium text-gray-700">Start Time</label>
                <input type="time" name="start_time" id="start_time" class="w-full px-4 py-2 border rounded text-black"
                    required>
            </div>

            <div class="mb-6">
                <label for="end_time" class="block mb-2 text-sm font-medium text-gray-700">End Time</label>
                <input type="time" name="end_time" id="end_time" class="w-full px-4 py-2 border rounded text-black"
                    required>
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">
                    Submit
                </button>

                <a href="{{ route('employee.dashboard') }}"
                    class="bg-gray-400 hover:bg-gray-600 text-white px-4 py-2 rounded transition">
                    Back to Dashboard
                </a>
            </div>
        </form>
    </div>
@endsection
