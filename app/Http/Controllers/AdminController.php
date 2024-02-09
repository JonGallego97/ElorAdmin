<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use App\Models\Cycle;
use App\Models\Module;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index()
    {
        $roleIdAlumno = $this->getStudentRoleId();
        $roleIdProfesor = $this->getTeacherRoleId();

        $students = User::whereHas('roles', function ($query) use ($roleIdAlumno) {
            $query->where('id', $roleIdAlumno);
        })->count();
        $teachers = User::whereHas('roles', function ($query) use ($roleIdProfesor) {
            $query->where('id', $roleIdProfesor);
        })->count();

        $users = User::with('roles')->get();
        $departments = Department::all()->count();
        $cycles = Cycle::all()->count();
        $modules = Module::all()->count();
        $usersWithoutRole = User::whereDoesntHave('roles')->count();
        $personal = $users = User::whereHas('roles', function ($query) {
            $query->whereNotIn('name', ['alumno', 'profesor','administrador']);
        })->count();
        return view('admin.index',['users'=>$users, 'departments'=> $departments, 'cycles'=> $cycles, 'students' => $students, 'teachers' => $teachers,'usersWithoutRole'=>$usersWithoutRole,'modules'=>$modules,'personal'=>$personal]);
    }
}
