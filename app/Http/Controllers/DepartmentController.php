<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::orderBy('name')->get();
        return response()->json(['departments' => $departments])
        ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
       
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $deparment = new Department();
        $deparment->name = $request->name;
        $created = $deparment->save();
        if ($created) {
            return response()->json(['message' => 'Departamento creado correctamente'])
            ->setStatusCode(Response::HTTP_CREATED);
        } else {
            return response()->json(['message' => 'Error al crear el departamento'])
            ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        if ($department) {
            return response()->json(['department' => $department])
            ->setStatusCode(Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'Departamento no encontrado'])
            ->setStatusCode(Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $department->name = $request->name;
        $updated = $department->save();
        if ($updated) {
            return response()->json(['message' => 'Departamento actualizado correctamente'])
            ->setStatusCode(Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'Error al actualizar el departamento'])
            ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $deleted = $department->delete();
        if ($deleted) {
            return response()->json(['message' => 'Departamento eliminado correctamente'])
            ->setStatusCode(Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'Error al eliminar el departamento'])
            ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
    }
}
