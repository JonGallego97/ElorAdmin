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
        if(!is_null($modules)) {
            return response()->json(['modules'=>$modules])->setStatusCode(Response::HTTP_OK);
        } else {
            return response()->json(['modules'=>$modules])->setStatusCode(Response::HTTP_NO_CONTENT);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
            return response()->json(['module'=>$module])->setStatusCode(Response::HTTP_CREATED);
        } else {
            return response()->json(['module'=>$module])->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Module $module)
    {
        if($module) {
            return response()->json(['module'=>$module])->setStatusCode(Response::HTTP_OK);
        } else {
            return response()->json(['module'=>$module])->setStatusCode(Response::HTTP_NO_CONTENT);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Module $module)
    {
        //
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
            return response()->json(['module'=>$module])->setStatusCode(Response::HTTP_OK);
        } else {
            return response()->json(['module'=>$module])->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Module $module)
    {
        $deleted = $module->delete();
        if($deleted) {
            return response()->json(['module'=>$module])->setStatusCode(Response::HTTP_OK);
        } else {
            return response()->json(['module'=>$module])->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
    }
}
