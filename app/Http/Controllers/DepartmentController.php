<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::orderBy('name', 'asc')->get();
        return view('departments.index', ['departments' => $departments]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $deparment = new Department();
        $deparment->name = $request->name;
        $created = $deparment->save();
        if ($created) {
            return redirect()->route('departments.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        return view('departments.show', ['department' => $department]);
    }

    public function edit()
    {
        return view('departments.create');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $department->name = $request->name;
        $department->save();
        return redirect()->route('departments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index');
    }
}
