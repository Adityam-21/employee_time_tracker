@extends('layout')
@section('title', 'Log Time')
@section('content')
    <h2 class="text-xl font-semibold mb-4">Log Your Work Hours</h2>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('employee.storeLog') }}" class="space-y-4">
        @csrf

        <select id="department" class="w-full p-2 border rounded" required>
            <option value="">Select Department</option>
            @foreach ($departments as $department)
                <option value="{{ $department->id }}">{{ $department->name }}</option>
            @endforeach
        </select>

        <select id="project" class="w-full p-2 border rounded" required>
            <option value="">Select Project</option>
        </select>

        <select name="subproject_id" id="subproject" class="w-full p-2 border rounded" required>
            <option value="">Select Subproject</option>
        </select>

        <input type="date" name="date" class="w-full p-2 border rounded" required>
        <input type="time" name="start_time" class="w-full p-2 border rounded" required>
        <input type="time" name="end_time" class="w-full p-2 border rounded" required>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Log Time</button>
    </form>

    <script>
        document.getElementById('department').addEventListener('change', function() {
            fetch(`/projects/${this.value}`)
                .then(res => res.json())
                .then(data => {
                    let projectSelect = document.getElementById('project');
                    projectSelect.innerHTML = `<option value="">Select Project</option>`;
                    data.forEach(p => projectSelect.innerHTML += `<option value="${p.id}">${p.name}</option>`);
                });
        });

        document.getElementById('project').addEventListener('change', function() {
            fetch(`/subprojects/${this.value}`)
                .then(res => res.json())
                .then(data => {
                    let subSelect = document.getElementById('subproject');
                    subSelect.innerHTML = `<option value="">Select Subproject</option>`;
                    data.forEach(s => subSelect.innerHTML += `<option value="${s.id}">${s.name}</option>`);
                });
        });
    </script>
@endsection
