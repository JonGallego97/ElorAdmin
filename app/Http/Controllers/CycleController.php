<?php

namespace App\Http\Controllers;

use App\Models\Cycle;
use App\Models\Module;
use App\Models\Department;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\App;

class CycleController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($this->checkAdminRole() && $this->checkAdminRoute()) {
            $perPage = $request->input('per_page', App::make('paginationCount'));
            $cycles = Cycle::orderBy('name', 'asc')->paginate($perPage);
            foreach ($cycles as $cycle) {
                $cycle->count_students = Cycle::join('cycle_users', 'cycles.id', '=', 'cycle_users.cycle_id')
                    ->join('users', 'cycle_users.user_id', '=', 'users.id')
                    ->join('role_users', 'users.id', '=', 'role_users.user_id')
                    ->where('role_users.role_id', '=', 3)
                    ->where('cycles.id', '=', $cycle->id)
                    ->count();
                $cycle->department = Department::find($cycle->department_id);
            }
            $cycles->totalCycles = Cycle::count();
            return view('admin.cycles.index', compact('cycles'));
        }else {
            // Obtener todos los ciclos formativos
            $cycle = Cycle::all();

            // Obtener todos los módulos ordenados alfabéticamente
            $module = Module::orderBy('name', 'asc')->get();

            return view('cycles.index', compact('cycle', 'module'));

        }
        /* $cycle = Cycle::orderBy('name','asc')->get();
        return view('cycles.index',['cycles'=>$cycle]); */
    }
    public function indexPerson()
    {
         
     }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if($this->checkAdminRole() && $this->checkAdminRoute()){
            $departments = Department::select('id','name')->orderBy('name','asc')->get();
            $modules = Module::orderBy('name','asc')->get();
            return view('admin.cycles.edit_create',['departments'=>$departments,'modules'=>$modules]);
        } else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($this->checkAdminRole() && $this->checkAdminRoute()){
            $messages = [
                'name.required' => __('errorMessageNameEmpty'),
                'name.regex' => __('errorMessageNameLettersOnly'),
                'modules.required' => __('errorModulesRequired'),
                'modules.array' => __('errorModulesRequired'),
            ];
    
            $request->validate([
                'name' => ['required', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s]+$/u'],
                'modules' => ['required','array'],
            ], $messages);

    
            $cycle = new Cycle();
            $cycle->name = strtoupper($request->name);
            $cycle->department_id = $request->department;
            $result = $cycle->save();
    
            if($result) {
                $modules = $request->input('modules', []);
                $cycle->modules()->attach($modules);
                return redirect()->route('admin.cycles.show',['cycle'=>$cycle])->with('success',__('successCreate'));
            } else {
                return redirect()->back()->withErrors('success',__('successUpdate'));
            }
            
        } else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Cycle $cycle)
    {
        if ($this->checkAdminRoute()){
            $cycleId = $cycle->id;
            $cycle->count_students = $this->cycleCountStudents($cycleId);
            $cycle->modules = $this->cycleModule($request, $cycleId);
            foreach ($cycle->modules as $module) {
                $module->count_teachers = $this->moduleTeachersCount($module->id,$cycle->id);
                $module->count_students = $this->moduleStudentsCount($module->id,$cycle->id);
            }
            $cycle->department = Department::find($cycle->department_id);
            return view('admin.cycles.show', compact('cycle'));
        } else {
            return view('cycles.show',['cycle'=>$cycle]);
        }        
    }

    private function cycleCountStudents($cycleId){
        return Cycle::join('cycle_users', 'cycles.id', '=', 'cycle_users.cycle_id')
        ->join('users', 'cycle_users.user_id', '=', 'users.id')
        ->join('role_users', 'users.id', '=', 'role_users.user_id')
        ->where('role_users.role_id', '=', 3)
        ->where('cycles.id', '=', $cycleId)
        ->count();
    }

    private function cycleModule(Request $request, $cycleId){
        $perPage = $request->input('per_page', App::make('paginationCount'));
        return Module::join('cycle_module', 'modules.id', '=', 'cycle_module.module_id')
        ->where('cycle_module.cycle_id', $cycleId)
        ->select('modules.*')
        ->paginate($perPage);
    }

    private function moduleStudentsCount($moduleId, $cycleId) {
        return Module::join('module_user_cycle', 'modules.id', '=', 'module_user_cycle.module_id')
            ->join('users', 'module_user_cycle.user_id', '=', 'users.id')
            ->join('role_users', 'users.id', '=', 'role_users.user_id')
            ->where('role_users.role_id', '=', 3)
            ->where('modules.id', '=', $moduleId)
            ->where('module_user_cycle.cycle_id', '=', $cycleId)
            ->count();
    }
    private function moduleTeachersCount($moduleId, $cycleId) {
        return Module::join('module_user_cycle', 'modules.id', '=', 'module_user_cycle.module_id')
            ->join('users', 'module_user_cycle.user_id', '=', 'users.id')
            ->join('role_users', 'users.id', '=', 'role_users.user_id')
            ->where('role_users.role_id', '=', 2)
            ->where('modules.id', '=', $moduleId)
            ->where('module_user_cycle.cycle_id', '=', $cycleId)
            ->count();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,Cycle $cycle)
    {
        if($this->checkAdminRoute() && $this->checkAdminRole()){
            $departments = Department::select('id','name')->orderBy('name','asc')->get();
            $cycle = Cycle::with('modules')->where('id',$cycle->id)->get();
            $allModules = Module::orderBy('name','asc')->get();
            return view('admin.cycles.edit_create',['cycle'=>$cycle['0'],'allModules'=>$allModules,'departments'=>$departments]);
        } else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cycle $cycle)
    {
        if($this->checkAdminRoute() && $this->checkAdminRole()){
            $messages = [
                'name.required' => __('errorMessageNameEmpty'),
                'name.regex' => __('errorMessageNameLettersOnly'),
                'modules.required' => __('errorModulesRequired'),
                'modules.array' => __('errorModulesRequired'),
            ];
    
            $request->validate([
                'name' => ['required', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s]+$/u'],
                'modules' => ['required','array'],
            ], $messages);


            $cycle->name = strtoupper($request->name);
            $cycle->department_id = $request->department;
            $cycle->modules()->sync($request->input('modules', []));
            $result = $cycle->save();

            if ($result) {
                return redirect()->route('admin.cycles.show',['cycle'=>$cycle])->with('success',__('successUpdate'));
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
    public function destroy(Request $request, $cycleId)
    {
        if($this->checkAdminRoute() && $this->checkAdminRole()){
            $cycle = Cycle::find($cycleId);
            if ($cycle) {
                $cycle->delete();
                return redirect()->route('admin.cycles.index')->with('success', __('successDelete'));
            } else {
                return redirect()->back()->withErrors('error',__('errorDelete'));
            }
        } else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }
    }
    public function destroyCycleModule(Request $request, $cycleId, $moduleId){
        if ($this->checkAdminRoute() && $this->checkAdminRole()) {
            $cycle = Cycle::find($cycleId);
            if ($cycle) {
                $cycle->modules()->detach($moduleId);
                return redirect()->route('admin.cycles.show',['cycle'=>$cycle])->with('success',__('successDelete'));
            } else {
                return redirect()->back()->withErrors('error',__('errorDelete'));
            }
        }else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }
    }

    public function getCyclesByDepartment($departmentId){
        $cycles = Cycle::where('department_id',$departmentId)->get();
        dd($cycles);
        return response()->json($cycles);
    }
}
