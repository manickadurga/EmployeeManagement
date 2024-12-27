@extends('layouts.app')

@section('content')
    <h1>Add Contact</h1>
    <form action="{{ route('contacts.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
        </div>

        <div class="form-group">
            <label for="projects">Projects</label>
            <div class="dropdown">
                <textarea id="project-dropdown" class="form-control" readonly placeholder="Select projects..."></textarea>
                <div id="project-list" class="dropdown-menu">
                    @foreach ($projects as $project)
                        <div class="dropdown-item">
                            <input type="checkbox" name="projects[]" value="{{ $project->id }}" id="project_{{ $project->id }}" class="project-checkbox">
                            <label for="project_{{ $project->id }}">{{ $project->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save Contact</button>
    </form>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const projectDropdown = document.getElementById('project-dropdown');
            const projectList = document.getElementById('project-list');
            const checkboxes = document.querySelectorAll('.project-checkbox');

            // Initialize the textarea with selected project names
            function updateSelectedProjects() {
                const selectedProjects = Array.from(checkboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.nextElementSibling.textContent);
                projectDropdown.value = selectedProjects.join(', ');
            }

            // Toggle dropdown visibility
            projectDropdown.addEventListener('click', function (event) {
                event.stopPropagation();
                projectList.classList.toggle('show');
            });

            // Update textarea when checkboxes change
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    updateSelectedProjects();
                });
            });

            // Close dropdown when clicking outside
            window.addEventListener('click', function (event) {
                if (!event.target.closest('.dropdown')) {
                    projectList.classList.remove('show');
                }
            });

            // Initialize textarea with pre-selected projects if any (if applicable)
            updateSelectedProjects();
        });
    </script>
@endsection

