<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        {
            
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:employees',
                'email' => 'required|string|email|max:255|unique:employees',
                'password' => 'required|string|min:6',
                'start_date' => 'required|date',
            ]);
    
            
            Employee::create([
                'name' => $validatedData['name'],
                'username' => $validatedData['username'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'start_date' => $validatedData['start_date'],
            ]);
    
            return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
        }
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:employees,username,' . $employee->id,
        'email' => 'required|string|email|max:255|unique:employees,email,' . $employee->id,
        'password' => 'nullable|string|min:8|confirmed',
        'start_date' => 'required|date',
    ]);

        $employee->name = $validatedData['name'];
        $employee->username = $validatedData['username'];
        $employee->email = $validatedData['email'];
        if (!empty($validatedData['password'])) {
            $employee->password = bcrypt($validatedData['password']);
        }
        $employee->start_date = $validatedData['start_date'];

        $employee->save();

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully');
    }
}

