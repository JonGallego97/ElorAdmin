<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\User;
use Illuminate\Http\Request;


class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->is('admin*')) {
            $perPage = $request->input('per_page', 10);
            $modules = Module::orderBy('name','asc')->paginate($perPage);
            foreach ($modules as $module) {
                $module->count_teachers = Module::join('module_user', 'modules.id', '=', 'module_user.module_id')
                    ->join('users', 'module_user.user_id', '=', 'users.id')
                    ->join('role_users', 'users.id', '=', 'role_users.user_id')
                    ->where('role_users.role_id', '=', 2)
                    ->where('modules.id', '=', $module->id)
                    ->count();
                $module->count_students = Module::join('module_user', 'modules.id', '=', 'module_user.module_id')
                    ->join('users', 'module_user.user_id', '=', 'users.id')
                    ->join('role_users', 'users.id', '=', 'role_users.user_id')
                    ->where('role_users.role_id', '=', 3)
                    ->where('modules.id', '=', $module->id)
                    ->count();

            }
            $modules->totalModules = Module::count();
            return view('admin.modules.index', compact('modules'));
        }else {
            //si no es admin

        }

        return view('modules.index',['modules'=>$modules]);
    }

    public function create()
    {
        return view('modules.create');
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $module = new Module();
        $module->code = $request->code;
        $module->name = $request->name;
        $module->hours = $request->hours;

        $created = $module->save();
        if($created) {
            return redirect()->route('modules.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Module $module)
    {
        $perPage = $request->input('per_page', 10);
        $teachers = User::join('module_user', 'users.id', '=', 'module_user.user_id')
            ->join('role_users', 'users.id', '=', 'role_users.user_id')
            ->where('role_users.role_id', 2)
            ->where('module_user.module_id', $module->id)
            ->select('users.*')
            ->paginate($perPage);
        $students = User::join('module_user', 'users.id', '=', 'module_user.user_id')
            ->join('role_users', 'users.id', '=', 'role_users.user_id')
            ->where('role_users.role_id', 3)
            ->where('module_user.module_id', $module->id)
            ->select('users.*')
            ->paginate($perPage);
        $module->teachers = $teachers;
        $module->students = $students;
       return view('admin.modules.show',['module'=>$module]);
    }
    public function edit()
    {
        return view('modules.create');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Module $module)
    {
        $module->code = $request->code;
        $module->name = $request->name;
        $module->hours = $request->hours;

        $updated = $module->save();
        if($updated) {
            return redirect()->route('modules.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $moduleId)
    {
        $redirectRoute = 'modules.index';

        if ($request->is('admin*')) {
            //si es admin
            $module = Module::find($moduleId);
            if ($module) {
                $module->delete();
                return redirect()->route($redirectRoute)->with('success', 'Modulo eliminado exitosamente.');
            } else {
                return redirect()->back()->with('error', 'Departamento no encontrado.');
            }
        }else {
        }
    }
}
