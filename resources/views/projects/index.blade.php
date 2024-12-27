@extends('layouts.app')
@section('content')
    <h1>Manage Projects</h1>
    <a href="{{ route('projects.create') }}" class="btn btn-primary add-button">Add Project</a>
    <div id="action-buttons" style="display: none; position: absolute; top: 90px; right: 60px; z-index: 1000;">
        <a id="edit-button" class="btn btn-warning" href="#" style="background-color:#3baea0; color:white; border:none;">Edit</a>
        <form id="delete-form" action="#" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger"  style="background-color:#1f6f78; border:none;">Delete</button>
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
                <th>Project Name</th>
                <th>Code</th>
                <th>URL</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Employees</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr data-id="{{ $project->id }}" data-edit-url="{{ route('projects.edit', $project) }}" data-delete-url="{{ route('projects.destroy', $project) }}">
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->code }}</td>
                    <td>
                        <a href="{{ $project->url }}" target="_blank">{{ $project->url }}</a>
                    </td>
                    <td>{{ $project->start_date }}</td>
                    <td>{{ $project->end_date }}</td>
                    <td>
                        @foreach ($project->employees as $employee)
                            {{ $employee->name }}<br>
                        @endforeach
                    </td>
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
