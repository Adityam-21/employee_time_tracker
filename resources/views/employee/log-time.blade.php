@extends('layout')
@section('title', 'Log Time')
@section('content')
    <h2 class="text-xl font-semibold mb-4">Log Your Work Hours</h2>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('employee.log-time.store') }}" class="space-y-4">
        @csrf

        <select name="department_id" class="w-full p-2 border rounded" required>
            <option value="">Select Department</option>
            @foreach ($departments as $department)
                <option value="{{ $department->id }}">{{ $department->name }}</option>
            @endforeach
        </select>

        <select name="project_id" class="w-full p-2 border rounded" required>
            <option value="">Select Project</option>
            @foreach ($projects as $project)
                <option value="{{ $project->id }}">{{ $project->name }}</option>
            @endforeach
        </select>

        <select name="subproject_id" class="w-full p-2 border rounded" required>
            <option value="">Select Subproject</option>
            @foreach ($subprojects as $subproject)
                <option value="{{ $subproject->id }}">{{ $subproject->name }}</option>
            @endforeach
        </select>

        <input type="date" name="date" class="w-full p-2 border rounded" max="{{ date('Y-m-d') }}" required>
        <input type="time" name="start_time" class="w-full p-2 border rounded" id="start_time" required>
        <input type="time" name="end_time" class="w-full p-2 border rounded" required>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Log Time</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.querySelector('input[name="date"]');
            const startTimeInput = document.querySelector('#start_time');

            function updateTimeValidation() {
                const selectedDate = dateInput.value;
                const today = new Date().toISOString().split('T')[0];

                if (selectedDate === today) {

                    const now = new Date();
                    const currentTime = now.getHours().toString().padStart(2, '0') + ':' +
                        now.getMinutes().toString().padStart(2, '0');
                    startTimeInput.setAttribute('min', currentTime);
                } else {

                    startTimeInput.removeAttribute('min');
                }
            }

            dateInput.addEventListener('change', updateTimeValidation);

            updateTimeValidation();
        });
    </script>
@endsection
