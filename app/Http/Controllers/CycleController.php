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

class CycleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $adminRoute = (new ControllerFunctions)->checkAdminRoute();
        if ($adminRoute) {
            $perPage = $request->input('per_page', 10);
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
            //si no es admin

        }
        $cycle = Cycle::orderBy('name','asc')->get();
        return view('cycles.index',['cycles'=>$cycle]);
    }
    public function indexPerson()
    {
         // Obtener todos los ciclos formativos
         $cycle = Cycle::all();

         // Obtener todos los módulos ordenados alfabéticamente
         $module = Module::orderBy('name', 'asc')->get();

         return view('persons.cycles.index', compact('cycle', 'module'));
     }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cycles.edit_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cycle = new Cycle();
        $cycle->name = $request->name;
        $cycle->save();
        return redirect()->route('cycles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Cycle $cycle)
    {
        $adminRoute = (new ControllerFunctions)->checkAdminRoute();
        if ($adminRoute) {

            $cycleId = $cycle->id;
            $cycle->count_students = $this->cycleCountStudents($cycleId);
            $cycle->modules = $this->cycleModule($request, $cycleId);
            foreach ($cycle->modules as $module) {
                $module->count_teachers = $this->moduleTeachersCount($module->id);
                $module->count_students = $this->moduleStudentsCount($module->id);
            }
            $cycle->department = Department::find($cycle->department_id);
            return view('admin.cycles.show', compact('cycle'));
        }else {
            //si no es admin

        }

        return view('cycles.show',['cycle'=>$cycle]);
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
        $perPage = $request->input('per_page', 10);
        return Module::join('cycle_module', 'modules.id', '=', 'cycle_module.module_id')
        ->where('cycle_module.cycle_id', $cycleId)
        ->select('modules.*')
        ->paginate($perPage);
    }

    private function moduleTeachersCount($moduleId){
        return Module::join('module_user_cycle', 'modules.id', '=', 'module_user_cycle.module_id')
        ->join('users', 'module_user_cycle.user_id', '=', 'users.id')
        ->join('role_users', 'users.id', '=', 'role_users.user_id')
        ->where('role_users.role_id', '=', 2)
        ->where('modules.id', '=', $moduleId)
        ->count();
    }

    private function moduleStudentsCount($moduleId){
        return Module::join('module_user_cycle', 'modules.id', '=', 'module_user_cycle.module_id')
        ->join('users', 'module_user_cycle.user_id', '=', 'users.id')
        ->join('role_users', 'users.id', '=', 'role_users.user_id')
        ->where('role_users.role_id', '=', 3)
        ->where('modules.id', '=', $moduleId)
        ->count();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $adminRole = (new ControllerFunctions)->checkAdminRole();
        $adminRoute = (new ControllerFunctions)->checkAdminRoute();
        if ($adminRole && $adminRoute) {
            return view('admin.cycles.edit_create');
        } else {
            return view('admin.cycles.edit_create');
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cycle $cycle)
    {
        $cycle->name = $request->name;
        $cycle->save();

        return view('cycles.show',['cycle'=>$cycle]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $cycleId)
    {
        $redirectRoute = 'cycles.index';

        if ($request->is('admin*')) {
            //si es admin
            $cycle = Cycle::find($cycleId);
            if ($cycle) {
                $cycle->delete();
                return redirect()->route($redirectRoute)->with('success', 'Usuario eliminado exitosamente.');
            } else {
                return redirect()->back()->with('error', 'Usuario no encontrado.');
            }
        }else {
        }
    }
    public function destroyCycleModule(Request $request, $cycleId, $moduleId){
        $redirectRoute = 'admin.cycles.show';
        if ($request->is('admin*')) {
            $cycle = Cycle::find($cycleId);
            if ($cycle) {
                $cycle->modules()->detach($moduleId);
                $cycle->count_students = $this->cycleCountStudents($cycleId);
                $cycle->modules = $this->cycleModule($request, $cycleId);
                foreach ($cycle->modules as $module) {
                    $module->count_teachers = $this->moduleTeachersCount($module->id);
                    $module->count_students = $this->moduleStudentsCount($module->id);
                }
                $cycle->department = Department::find($cycle->department_id);
                return view('admin.cycles.show',['cycle'=>$cycle]);
            } else {

            }

        }else {
        }
    }

    public function getCyclesByDepartment($departmentId){
        $cycles = Cycle::where('department_id',$departmentId)->get();
        dd($cycles);
        return response()->json($cycles);
    }
}
