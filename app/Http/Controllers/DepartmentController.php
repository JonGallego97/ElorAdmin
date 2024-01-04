<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->is('admin*')) {
            $perPage = $request->input('per_page', 10);
            $departments = Department::orderBy('name', 'asc')->paginate($perPage);
            foreach ($departments as $department) {
                $department->count_people = DB::table('users')->where('department_id', $department->id)->count();
            }
            $departments->totalDepartments = Department::count();
            return view('admin.departments.index', compact('departments'));
        }else {
            //si no es admin

        }
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
    public function show(Request $request, Department $department)
    {
        $perPage = $request->input('per_page', 10);
        $department->users = User::where('department_id', $department->id)->paginate($perPage);

        return view('admin.departments.show', ['department' => $department]);
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
    public function destroy(Request $request, $departmentId)
    {
        $redirectRoute = 'departments.index';

        if ($request->is('admin*')) {
            //si es admin
            $department = Department::find($departmentId);
            if ($department) {
                $department->delete();
                return redirect()->route($redirectRoute)->with('success', 'Usuario eliminado exitosamente.');
            } else {
                return redirect()->back()->with('error', 'Departamento no encontrado.');
            }
        }else {
        }
    }
}
