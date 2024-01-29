<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\User;
use App\Models\Department;
use App\Models\Role;
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

            $roleTeacher = Role::where('name','PROFESOR')->first();
            $roleStudent = Role::where('name','ALUMNO')->first();

            foreach ($modules as $module) {
                $module->count_teachers = Module::join('module_user_cycle', 'modules.id', '=', 'module_user_cycle.module_id')
                    ->join('users', 'module_user_cycle.user_id', '=', 'users.id')
                    ->join('role_users', 'users.id', '=', 'role_users.user_id')
                    ->where('role_users.role_id', '=', $roleTeacher->id)
                    ->where('modules.id', '=', $module->id)
                    ->count();
                $module->count_students = Module::join('module_user_cycle', 'modules.id', '=', 'module_user_cycle.module_id')
                    ->join('users', 'module_user_cycle.user_id', '=', 'users.id')
                    ->join('role_users', 'users.id', '=', 'role_users.user_id')
                    ->where('role_users.role_id', '=', $roleStudent->id)
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
        $departmentsWithCycles = Department::has('cycles')->with('cycles')->get();
        return view('admin.modules.edit_create', ['module' => $module,'departmentsWithCycles' => $departmentsWithCycles]);
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

        $cycles = $request->cycle;
        $module->cycles()->attach($cycles);
        

        if($created) {
            $module->teachers = $this->teachers($request, $module);
            $module->students = $this->students($request, $module);
            foreach ($module->cycles as $cycle) {
                $cycleInfo = [
                    'id' => $cycle->id,
                    'name' => $cycle->name,
                    'department' => $cycle->department()->pluck('name')->toArray(),
                ];
        
                $resultArray[] = $cycleInfo;
            }
            return view('admin.modules.show',['module'=>$module,'cyclesArray' => $resultArray]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Module $module)
    {

        $module->teachers = $this->teachers($request, $module);
        $module->students = $this->students($request, $module);


        foreach ($module->cycles as $cycle) {
            $cycleInfo = [
                'id' => $cycle->id,
                'name' => $cycle->name,
                'department' => $cycle->department()->pluck('name')->toArray(),
            ];
    
            $resultArray[] = $cycleInfo;
        }
        return view('admin.modules.show',['module'=>$module,'cyclesArray' => $resultArray]);
    }
    public function edit(Module $module)
    {
        $departmentsWithCycles = Department::has('cycles')->with('cycles')->get();
        return view('admin.modules.edit_create', ['module' => $module,'departmentsWithCycles' => $departmentsWithCycles]);
    }

    private function teachers(Request $request, Module $module){
        $perPage = $request->input('per_page', 10);
        return $teachers = User::join('module_user_cycle', 'users.id', '=', 'module_user_cycle.user_id')
            ->join('role_users', 'users.id', '=', 'role_users.user_id')
            ->where('role_users.role_id', 2)
            ->where('module_user_cycle.module_id', $module->id)
            ->select('users.*')
            ->paginate($perPage);
    }

    private function students(Request $request, Module $module){
        $perPage = $request->input('per_page', 10);
        return $students = User::join('module_user_cycle', 'users.id', '=', 'module_user_cycle.user_id')
            ->join('role_users', 'users.id', '=', 'role_users.user_id')
            ->where('role_users.role_id', 3)
            ->where('module_user_cycle.module_id', $module->id)
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

        $cycles = $request->cycle;
        $module->cycles()->sync($cycles);

        if($updated) {
            $module->teachers = $this->teachers($request, $module);
            $module->students = $this->students($request, $module);
            foreach ($module->cycles as $cycle) {
                $cycleInfo = [
                    'id' => $cycle->id,
                    'name' => $cycle->name,
                    'department' => $cycle->department()->pluck('name')->toArray(),
                ];
        
                $resultArray[] = $cycleInfo;
            }
            return view('admin.modules.show',['module'=>$module,'cyclesArray' => $resultArray]);
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
