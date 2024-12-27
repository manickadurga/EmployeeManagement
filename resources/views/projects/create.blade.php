@extends('layouts.app')

@section('content')
    <h1>Add Project</h1>
    <form action="{{ route('projects.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Project Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="code">Project Code <span class="text-danger">*</span></label>
            <input type="text" name="code" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="url">Project URL</label>
            <input type="text" name="url" class="form-control">
        </div>
        <div class="form-group">
            <label for="employees">Add/Remove Employees</label>
            <div class="dropdown">
                <textarea id="employee-dropdown" class="form-control" readonly placeholder="Select employees..."></textarea>
                <div id="employee-list" class="dropdown-menu">
                    @foreach ($employees as $employee)
                        <div class="dropdown-item">
                            <input type="checkbox" name="employees[]" value="{{ $employee->id }}" id="employee_{{ $employee->id }}" class="employee-checkbox">
                            <label for="employee_{{ $employee->id }}">{{ $employee->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="start_date">Start Date <span class="text-danger">*</span></label>
            <input type="date" name="start_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="date" name="end_date" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Add Project</button>
    </form>
@endsection

@section('scripts')
    <script>
        // JavaScript to toggle dropdown
        document.getElementById('employee-dropdown').addEventListener('click', function(event) {
            event.stopPropagation(); // Prevent click from closing the dropdown
            document.getElementById('employee-list').classList.toggle('show');
        });

        // Update textarea with selected employee names
        document.querySelectorAll('.employee-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                updateSelectedEmployees();
            });
        });

        function updateSelectedEmployees() {
            var selectedEmployees = [];
            document.querySelectorAll('.employee-checkbox:checked').forEach(function(checkedBox) {
                selectedEmployees.push(checkedBox.nextElementSibling.textContent);
            });
            document.getElementById('employee-dropdown').value = selectedEmployees.join(', ');
        }

        // Close dropdown when clicking outside
        window.addEventListener('click', function(event) {
            if (!event.target.closest('.dropdown')) {
                document.getElementById('employee-list').classList.remove('show');
            }
        });
    </script>
@endsection
