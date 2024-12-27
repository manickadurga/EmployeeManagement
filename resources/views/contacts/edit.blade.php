@extends('layouts.app')

@section('content')
    <h1>Edit Contact</h1>
    <form action="{{ route('contacts.update', $contact) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $contact->name) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $contact->email) }}" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $contact->phone) }}" required>
        </div>

        <div class="form-group">
            <label for="projects">Projects</label>
            <div class="dropdown">
                <textarea id="project-dropdown" class="form-control" readonly placeholder="Select projects...">{{ implode(', ', $contact->projects->pluck('name')->toArray()) }}</textarea>
                <div id="project-list" class="dropdown-menu">
                    @foreach ($projects as $project)
                        <div class="dropdown-item">
                            <input type="checkbox" name="projects[]" value="{{ $project->id }}" id="project_{{ $project->id }}" class="project-checkbox" 
                                {{ $contact->projects->pluck('id')->contains($project->id) ? 'checked' : '' }}>
                            <label for="project_{{ $project->id }}">{{ $project->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update Contact</button>
    </form>
@endsection

@section('scripts')
    <script>
        // JavaScript to toggle dropdown
        document.getElementById('project-dropdown').addEventListener('click', function(event) {
            event.stopPropagation(); // Prevent click from closing the dropdown
            document.getElementById('project-list').classList.toggle('show');
        });

        // Update textarea with selected project names
        document.querySelectorAll('.project-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                updateSelectedProjects();
            });
        });

        function updateSelectedProjects() {
            var selectedProjects = [];
            document.querySelectorAll('.project-checkbox:checked').forEach(function(checkedBox) {
                selectedProjects.push(checkedBox.nextElementSibling.textContent);
            });
            document.getElementById('project-dropdown').value = selectedProjects.join(', ');
        }

        // Close dropdown when clicking outside
        window.addEventListener('click', function(event) {
            if (!event.target.closest('.dropdown')) {
                document.getElementById('project-list').classList.remove('show');
            }
        });
    </script>
@endsection
