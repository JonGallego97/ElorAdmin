<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Department;
use App\Models\Module;
use App\Models\Cycle;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        if($this->checkAdminRole()) {
            $fileName =    $this->createImageFromBase64($user);
            return view('admin.home',compact('user'))->with('imagePath','images/'.$fileName);;
        } else {
            $usera = User::All();
            $cycles=Cycle::All();

            //obtener el modulo del usuario
            $userId = Auth::user()->id;
            $moduleUserCycles = DB::table('module_user_cycle')
                ->where('user_id', $userId)
                ->get();
            //dd($moduleUserCycles);
            $moduleName = [];

            foreach ($moduleUserCycles as $moduleUserCycle) {
                $module = DB::table('modules')->where('id', $moduleUserCycle->module_id)->first();
                $moduleName[] = $module;

            }
            //dd($moduleName);

            //obtener los estudiantes con los modulos
            foreach ($moduleName as $moduleName1) {


                $moduleName1->students = \DB::table('users')
                ->join('role_users', 'users.id', '=', 'role_users.user_id')
                ->join('roles', 'role_users.role_id', '=', 'roles.id')
                ->join('module_user_cycle', 'users.id', '=', 'module_user_cycle.user_id')
                ->join('modules', 'module_user_cycle.module_id', '=', 'modules.id')
                ->where('roles.id', 3)
                ->where('modules.id', $moduleName1->id)
                ->select('users.*')
                ->get();
                //dd($moduleName1);
                //obtener los profesores segun el modulo
                $moduleName1->teachers = \DB::table('users')
                ->join('role_users', 'users.id', '=', 'role_users.user_id')
                ->join('roles', 'role_users.role_id', '=', 'roles.id')
                ->join('module_user_cycle', 'users.id', '=', 'module_user_cycle.user_id')
                ->join('modules', 'module_user_cycle.module_id', '=', 'modules.id')
                ->where('roles.id', 2)
                ->where('modules.id', $moduleName1->id)
                ->select('users.*')
                ->get();
                //dd($moduleName1->teachers);

            }

    
            // Verificar si el usuario autenticado tiene el rol deseado
            if (User::find($user->id)->roles->first()->id == 2) {
                // Si tiene el rol deseado, filtrar los usuarios por ese rol
                $usera = User::whereHas('roles', function ($query) {
                    $query->where('id', 2);
                })->get();
            }
          
            // Obtener los ciclos y módulos del usuario
            $cycles = $user->cycles;
           //dd($cycles);


            //obtener el departamento del usuario
            $usersInSameDepartment=[];
            if ($this->checkAdminRole()) {
                // ... (código existente para administradores)
            } else {
                // Obtener el departamento del usuario autenticado
                $department = $user->department;
                // Verificar si el usuario autenticado tiene el rol deseado
                if ($user->roles->first()->id == 2) {
                    // Si tiene el rol deseado, obtener los usuarios en el mismo departamento
                    $usersInSameDepartment = User::where('department_id', $department->id)->get();
                }
            }
           // dd($usersInSameDepartment);


            $user = User::with('roles', 'cycles.modules', 'modules')->where('id', $user->id)->first();

            return view('home',compact('user','usera','moduleName', 'usersInSameDepartment'));
        }
    }

}
