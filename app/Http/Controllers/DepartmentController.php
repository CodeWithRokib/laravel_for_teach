<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Storage;

class DepartmentController extends Controller
{

    public function index()
    {
        $departments = Department::all();
        return view('departments.index',compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Validate image
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $imagePath;
        }

        Department::create($validatedData);

        return redirect()->route('departments.index')->with('success', 'Department created successfully!');
    }

    public function show(Department $department)
    {
        return view('departments.show',compact('department'));
    }

    public function edit(Department $department)
    {
        return view('departments.edit',compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Validate image
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($department->image && Storage::exists('public/' . $department->image)) {
                Storage::delete('public/' . $department->image);
            }

            // Store new image
            $imagePath = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $imagePath;
        }

        $department->update($validatedData);

        return redirect()->route('departments.index')->with('success', 'Department updated successfully!');
    }

    public function destroy(Department $department)
    {
        if ($department->image && Storage::exists('public/' . $department->image)) {
            Storage::delete('public/' . $department->image);
        }
        $department->delete();
        return redirect()->back()->with('success','Department Deleted Successfully');
    }
}
