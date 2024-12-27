<?php

// app/Http/Controllers/ContactController.php
namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Project;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::with('projects')->get();
        return view('contacts.index', compact('contacts'));
    }

    public function create()
    {
        $projects = Project::all();
        return view('contacts.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:15',
            'projects' => 'nullable|array',
        ]);

        $contact = Contact::create($validatedData);
        $contact->projects()->sync($request->projects);

        return redirect()->route('contacts.index')->with('success', 'Contact added successfully');
    }

    public function edit(Contact $contact)
    {
        $projects = Project::all();
        return view('contacts.edit', compact('contact', 'projects'));
    }

    public function update(Request $request, Contact $contact)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:15',
            'projects' => 'nullable|array',
        ]);

        $contact->update($validatedData);
        $contact->projects()->sync($request->projects);

        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully');
    }
}

