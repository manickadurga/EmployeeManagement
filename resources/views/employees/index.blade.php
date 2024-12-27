@extends('layouts.app')

@section('content')
    <h1>Manage Employees</h1>
    <a href="{{ route('employees.create') }}" class="btn btn-primary add-button">Add Employee</a>
    <div id="action-buttons" style="display: none; position: absolute; top: 90px; right: 60px; z-index: 1000;">
        <a id="edit-button" class="btn btn-warning" href="#" style="background-color:#3baea0; color:white; border:none;">Edit</a>
        <form id="delete-form" action="#" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" style="background-color:#1f6f78; border:none;">Delete</button>
        </form>
    </div>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Start Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                <tr data-id="{{ $employee->id }}" data-edit-url="{{ route('employees.edit', $employee) }}" data-delete-url="{{ route('employees.destroy', $employee) }}">
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->username }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->start_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        document.querySelectorAll('tbody tr').forEach(row => {
            row.addEventListener('click', function() {
                const actionButtons = document.getElementById('action-buttons');
                const editButton = document.getElementById('edit-button');
                const deleteForm = document.getElementById('delete-form');

                editButton.href = this.getAttribute('data-edit-url');
                deleteForm.action = this.getAttribute('data-delete-url');
                actionButtons.style.display = 'block';
                actionButtons.style.top = `${row.getBoundingClientRect().top}px`;  // Align with the row
                actionButtons.style.left = `${row.getBoundingClientRect().right + 10}px`; // Adjust as needed
            });
        });
    </script>
@endsection






