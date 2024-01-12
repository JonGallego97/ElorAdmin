<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
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
        $module = new Module();
        return view('admin.modules.create', ['module' => $module]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'name.required' => __('errorMessageNameEmpty'),
            'name.unique' => __('errorMessageNameUnique'),
            'code.required' => __('errorMessageCodeEmpty'),
            'code.integer' => __('errorMessageCodeInteger'),
            'hours.required' => __('errorMessageHoursEmpty'),
            'hours.integer' => __('errorMessageHoursInteger'),
        ];

        $request->validate([
            'name' => 'required|unique:roles',
            'code' => 'required|integer',
            'hours' => 'required|integer',
        ], $messages);

        $module = new Module();
        $module->code = $request->code;
        $module->name = $request->name;
        $module->hours = $request->hours;

        $created = $module->save();
        if($created) {
            $module->teachers = $this->teachers($request, $module);;
            $module->students = $this->students($request, $module);;
            return view('admin.modules.show', ['module' => $module]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Module $module)
    {
        $module->teachers = $this->teachers($request, $module);
        $module->students = $this->students($request, $module);
        return view('admin.modules.show',['module'=>$module]);
    }
    public function edit(Module $module)
    {
        return view('admin.modules.create', ['module' => $module]);
    }

    private function teachers(Request $request, Module $module){
        $perPage = $request->input('per_page', 10);
        return $teachers = User::join('module_user', 'users.id', '=', 'module_user.user_id')
            ->join('role_users', 'users.id', '=', 'role_users.user_id')
            ->where('role_users.role_id', 2)
            ->where('module_user.module_id', $module->id)
            ->select('users.*')
            ->paginate($perPage);
    }

    private function students(Request $request, Module $module){
        $perPage = $request->input('per_page', 10);
        return $students = User::join('module_user', 'users.id', '=', 'module_user.user_id')
            ->join('role_users', 'users.id', '=', 'role_users.user_id')
            ->where('role_users.role_id', 3)
            ->where('module_user.module_id', $module->id)
            ->select('users.*')
            ->paginate($perPage);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Module $module)
    {
        $messages = [
            'name.required' => __('errorMessageNameEmpty'),
            'name.unique' => __('errorMessageNameUnique'),
            'code.required' => __('errorMessageCodeEmpty'),
            'code.integer' => __('errorMessageCodeInteger'),
            'hours.integer' => __('errorMessageHoursInteger'),
        ];

        $request->validate([
            'name' => 'required|unique:roles',
            'code' => 'required|integer',
            'hours' => 'integer',
        ], $messages);

        $module->code = $request->code;
        $module->name = $request->name;
        $module->hours = $request->hours;

        $updated = $module->save();
        if($updated) {
            $module->teachers = $this->teachers($request, $module);
            $module->students = $this->students($request, $module);
            return view('admin.modules.show', ['module' => $module]);
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

    public function destroyModuleUser(Request $request, $moduleId, $userId){
        $redirectRoute = 'admin.modules.show';
        if ($request->is('admin*')) {
            $module = Module::find($moduleId);
            if ($module) {
                $module->users()->detach($userId);
                $module->teachers = $this->teachers($request, $module);
                $module->students = $this->students($request, $module);
                return view('admin.modules.show',['module'=>$module]);
            } else {

            }

        }else {
        }
    }
}
