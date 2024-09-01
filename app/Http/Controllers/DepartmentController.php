<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

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
        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:png,jgp,jpeg,gif,svg|max:2048',
        ]);
        
        if($request->hashFile('image')){
            $imageName = time(). '.' . $request->image->extension();
            $request->image->move(public_path('images', $imageName));
            $validateData['image']=$imageName;
        }

        Department::create($validateData);
        return redirect()->route('departments.index')->with('success','Department created Successfully');
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
        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:png,jgp,jpeg,gif,svg|max:2048',
        ]);

        if($request->hasFile('image')){
           if($department->image && file_exists(public_path('images/'.$department->image)));
           unlink(public_path('images/'.$department->image));

           $imageName = time(). '.'. $request->image->extension();
           $request->image->move(public_path('images', $imageName));
           $validateData['image'] = $imageName;
        }
        
        $department->update($validateData);
        return redirect()->route('departments.index')->with('success','Update data successfull');
        
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->back()->with('success','Department Deleted Successfully');
    }
}
