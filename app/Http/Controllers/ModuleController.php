<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\User;
use App\Models\Department;
use App\Models\Cycle;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class ModuleController extends Controller
{
    private $ControllerFunctions;

    function __construct() {
        $this->ControllerFunctions = new ControllerFunctions;
    }
    //$this->ControllerFunctions->checkAdminRoute()
    //$this->ControllerFunctions->checkAdminRole()

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($this->ControllerFunctions->checkAdminRoute() && $this->ControllerFunctions->checkAdminRole()) {
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
    }

    public function create(Request $request)
    {
        if($this->ControllerFunctions->checkAdminRoute() && $this->ControllerFunctions->checkAdminRole()){
            $module = new Module();
            $departmentsWithCycles = Department::has('cycles')->with('cycles')->get();
            $moduleCyclesIds = $module->cycles->pluck('id')->toArray();
            return view('admin.modules.edit_create', ['module' => $module,'departmentsWithCycles' => $departmentsWithCycles,'moduleCyclesIds'=>$moduleCyclesIds]);
        } else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }
        
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($this->ControllerFunctions->checkAdminRoute() && $this->ControllerFunctions->checkAdminRole()) {
            $messages = [
                'name.required' => __('errorMessageNameEmpty'),
                'name.regex' => __('errorMessageNameLettersOnly'),
                'code.required' => __('errorMessageCodeEmpty'),
                'code.integer' => __('errorMessageCodeInteger'),
                'code.unique' => __('errorModuleCodeExists'),
                'hours.required' => __('errorMessageHoursEmpty'),
                'hours.integer' => __('errorMessageHoursInteger'),
                'cycles.required' => __('errorCycleRequired'),
                'cycles.array' => __('errorCycleRequired'),
            ];
    
            $request->validate([
                'name' => ['required', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s]+$/u'],
                'code' => ['required', 'integer', 'unique:modules'],
                'hours' => ['required', 'integer'],
                'cycles' => ['required','array'],
            ], $messages);

    
            $module = new Module();
            $module->code = $request->code;
            $module->name = ucfirst(strtolower($request->name));
            $module->hours = $request->hours;
    
            $created = $module->save();
    
            //$cycles = $request->cycle;
            $cycles = $request->input('cycles', []);
            $module->cycles()->attach($cycles);
            
            if($created) {
                return redirect()->route('modules.show',['module'=>$module])->with('success',__('successCreate'));
            } else {
                return redirect()->back()->withErrors(['error' => __('errorCreate')]);
            }
        } else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Module $module)
    {
        if($this->ControllerFunctions->checkAdminRoute() && $this->ControllerFunctions->checkAdminRole()){
            $module->teachers = $this->teachers($request, $module);
            $module->students = $this->students($request, $module);


            foreach ($module->cycles as $cycle) {
                $studentCount = User::whereHas('cycles', function ($query) use ($cycle) {
                    $query->where('cycle_id', $cycle->id);
                })->whereHas('roles', function ($query) {
                    $query->where('name', "ALUMNO");
                })->count();
                $cycleInfo = [
                    'id' => $cycle->id,
                    'name' => $cycle->name,
                    'department' => $cycle->department()->pluck('name')->toArray(),
                    'students' => $studentCount
                ];
        
                $resultArray[] = $cycleInfo;
            }
            return view('admin.modules.show',['module'=>$module,'cyclesArray' => $resultArray]);
        } else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }

        
    }
    public function edit(Request $request,Module $module)
    {
        if ($this->ControllerFunctions->checkAdminRoute() && $this->ControllerFunctions->checkAdminRole()){
            $departmentsWithCycles = Department::has('cycles')->with('cycles')->get();
            $moduleCyclesIds = $module->cycles->pluck('id')->toArray();
            return view('admin.modules.edit_create', ['module' => $module,'departmentsWithCycles' => $departmentsWithCycles,'moduleCyclesIds'=>$moduleCyclesIds]);
        } else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }
        
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
        if ($this->ControllerFunctions->checkAdminRoute() && $this->ControllerFunctions->checkAdminRole()){
            $messages = [
                'name.required' => __('errorMessageNameEmpty'),
                'name.regex' => __('errorMessageNameLettersOnly'),
                'code.required' => __('errorMessageCodeEmpty'),
                'code.integer' => __('errorMessageCodeInteger'),
                'code.unique' => __('errorModuleCodeExists'),
                'hours.required' => __('errorMessageHoursEmpty'),
                'hours.integer' => __('errorMessageHoursInteger'),
                'cycles.required' => __('errorCycleRequired'),
                'cycles.array' => __('errorCycleRequired'),
            ];

            $request->validate([
                'name' => ['required', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s]+$/u'],
                'code' => ['required', 'integer', Rule::unique('modules')->ignore($module->id)],
                'hours' => ['required', 'integer'],
                'cycles' => ['required','array'],
            ], $messages);

            $module->code = $request->code;
            $module->name = ucfirst(strtolower($request->name));
            $module->hours = $request->hours;

            $updated = $module->save();

            //$cycles = $request->cycle;
            $cycles = $request->input('cycles', []);
            $module->cycles()->sync($cycles);

            if($updated) {
                return redirect()->route('modules.show',['module'=>$module])->with('success',__('successUpdate'));
            } else {
                return redirect()->back()->withErrors('error', __('errorUpdate'));
            }
        } else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($moduleId)
    {

        if ($this->ControllerFunctions->checkAdminRoute() && $this->ControllerFunctions->checkAdminRole()) {
            //si es admin
            $module = Module::find($moduleId);
            if ($module) {
                $module->delete();
                return redirect()->route('modules.index')->with('success', __('successDelete'));
            } else {
                return redirect()->back()->withErrors('error', __('errorDelete'));
            }
        }else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }
    }

    public function destroyModuleUser(Request $request, $moduleId, $userId){
        if ($this->ControllerFunctions->checkAdminRoute() && $this->ControllerFunctions->checkAdminRole()) {
            $module = Module::find($moduleId);
            if ($module) {
                $module->users()->detach($userId);
                
                return redirect()->route('modules.show',['$module'=>$module])->with('success',__('successDelete'));
            } else {
                return redirect()->back()->withErrors('error',__('errorDelete'));
            }

        }else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }
    }
}
