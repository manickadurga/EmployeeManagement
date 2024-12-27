<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('employees')->get();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('projects.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'url' => 'nullable|url',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'employees' => 'nullable|array',
        ]);

        $project = Project::create($validatedData);
        $project->employees()->sync($request->employees);

        return redirect()->route('projects.index')->with('success', 'Project added successfully');
    }

    public function edit($id)
    {
    $project = Project::findOrFail($id);
    $employees = Employee::all(); 
    return view('projects.edit', compact('project', 'employees'));
    }


    public function update(Request $request, Project $project)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'url' => 'nullable|url',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'employees' => 'nullable|array',
        ]);

        $project->update($validatedData);
        $project->employees()->sync($request->employees);

        return redirect()->route('projects.index')->with('success', 'Project updated successfully');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully');
    }
}
