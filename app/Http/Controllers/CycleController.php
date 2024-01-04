<?php

namespace App\Http\Controllers;

use App\Models\Cycle;
use App\Models\Module;
use App\Models\Department;
use Illuminate\Http\Request;

class CycleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->is('admin*')) {
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
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cycles.create');
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
        if ($request->is('admin*')) {
            $perPage = $request->input('per_page', 10);
            $cycleId = $cycle->id;

            $cycle->count_students = Cycle::join('cycle_users', 'cycles.id', '=', 'cycle_users.cycle_id')
                ->join('users', 'cycle_users.user_id', '=', 'users.id')
                ->join('role_users', 'users.id', '=', 'role_users.user_id')
                ->where('role_users.role_id', '=', 3)
                ->where('cycles.id', '=', $cycleId)
                ->count();

            $cycle->modules = Module::join('cycle_module', 'modules.id', '=', 'cycle_module.module_id')
                ->where('cycle_module.cycle_id', $cycleId)
                ->select('modules.*')
                ->paginate($perPage);

            foreach ($cycle->modules as $module) {
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
            $cycle->department = Department::find($cycle->department_id);
            return view('admin.cycles.show', compact('cycle'));
        }else {
            //si no es admin

        }

        return view('cycles.show',['cycle'=>$cycle]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return view('cycles.create');
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
}
