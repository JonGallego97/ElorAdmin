<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modules = Module::orderBy('name','asc')->get();
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
    public function show(Module $module)
    {
       return view('modules.show',['module'=>$module]);
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
    public function destroy(Module $module)
    {
        $module->delete();
        return redirect()->route('modules.index');
    }
}
