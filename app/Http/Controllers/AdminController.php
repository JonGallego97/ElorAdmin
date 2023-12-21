<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use App\Models\Cycle;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $roleIdAlumno = 3;
        $roleIdProfesor = 2;

        $students = User::whereHas('roles', function ($query) use ($roleIdAlumno) {
            $query->where('id', $roleIdAlumno);
        })->count();
        $teachers = User::whereHas('roles', function ($query) use ($roleIdProfesor) {
            $query->where('id', $roleIdProfesor);
        })->count();

        $users = User::with('roles')->get();
        $departments = Department::all()->count();
        $cycles = Cycle::all()->count();
        return view('admin.index',['users'=>$users, 'departments'=> $departments, 'cycles'=> $cycles, 'students' => $students, 'teachers' => $teachers]);
    }
}
