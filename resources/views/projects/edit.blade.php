@extends('layouts.app')

@section('content')
    <h1>Edit Project</h1>
    <form action="{{ route('projects.update', $project) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Project Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $project->name) }}" required>
        </div>

        <div class="form-group">
            <label for="code">Project Code</label>
            <input type="text" name="code" class="form-control" value="{{ old('code', $project->code) }}" required>
        </div>

        <div class="form-group">
            <label for="url">Project URL</label>
            <input type="text" name="url" class="form-control" value="{{ old('url', $project->url) }}" required>
        </div>

        <div class="form-group">
            <label for="employees">Add/Remove Employees</label>
            <div class="dropdown">
                <textarea id="employee-dropdown" class="form-control" readonly placeholder="Select employees..."></textarea>
                <div id="employee-list" class="dropdown-menu">
                    @foreach ($employees as $employee)
                        <div class="dropdown-item">
                            <input type="checkbox" name="employees[]" value="{{ $employee->id }}" id="employee_{{ $employee->id }}" class="employee-checkbox"
                                {{ $project->employees->contains($employee->id) ? 'checked' : '' }}>
                            <label for="employee_{{ $employee->id }}">{{ $employee->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $project->start_date)}}" required>
        </div>

        <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $project->end_date)}}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Project</button>
    </form>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const employeeDropdown = document.getElementById('employee-dropdown');
            const employeeList = document.getElementById('employee-list');
            const checkboxes = document.querySelectorAll('.employee-checkbox');

            // Initialize the textarea with selected employee names
            function updateSelectedEmployees() {
                const selectedEmployees = Array.from(checkboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.nextElementSibling.textContent);
                employeeDropdown.value = selectedEmployees.join(', ');
            }

            // Toggle dropdown visibility
            employeeDropdown.addEventListener('click', function (event) {
                event.stopPropagation();
                employeeList.classList.toggle('show');
            });

            // Update textarea when checkboxes change
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    updateSelectedEmployees();
                });
            });

            // Close dropdown when clicking outside
            window.addEventListener('click', function (event) {
                if (!event.target.closest('.dropdown')) {
                    employeeList.classList.remove('show');
                }
            });

            // Initialize textarea with pre-selected employees
            updateSelectedEmployees();
        });
    </script>
@endsection