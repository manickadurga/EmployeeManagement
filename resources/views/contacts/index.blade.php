@extends('layouts.app')

@section('content')
    <h1>Manage Contacts</h1>
    <a href="{{ route('contacts.create') }}" class="btn btn-primary add-button">Add Contact</a>
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
                <th>Email</th>
                <th>Phone</th>
                <th>Projects</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contacts as $contact)
                <tr data-id="{{ $contact->id }}" data-edit-url="{{ route('contacts.edit', $contact) }}" data-delete-url="{{ route('contacts.destroy', $contact) }}">
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->phone }}</td>
                    <td>
                        @foreach ($contact->projects as $project)
                            {{ $project->name }}<br>
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
