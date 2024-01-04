<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->is('admin*')) {
            $perPage = $request->input('per_page', 10);
            $roles = Role::orderBy('name', 'asc')->paginate($perPage);
            foreach ($roles as $role) {
                $role->count_people = DB::table('role_users')->where('role_id', $role->id)->count();
            }
            return view('admin.roles.index', compact('roles'));
        }else {
            //si no es admin

        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role = new Role();
        $role->name = $request->name;
        $role->save();
        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Role $role)
    {
        $perPage = $request->input('per_page', 10);
        $users = User::whereHas('roles', function ($query) use ($role) {
            $query->where('id', $role->id);
        })->paginate($perPage);

        $role->users = $users;
        return view('admin.roles.show',['role'=>$role]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('roles.create');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $role->name = $request->name;
        $role->save();

        return view('roles.show',['role'=>$role]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $roleId)
    {
        $redirectRoute = 'roles.index';

        if ($request->is('admin*')) {
            $role = Role::find($roleId);
            if ($role) {
                if($role->name != 'ADMINISTRADOR' && $role->name!= 'ALUMNO' && $role->name!= 'PROFESOR'){
                    $role->delete();
                    return redirect()->route($redirectRoute)->with('success', 'Rol eliminado exitosamente.');
                }else{
                    return redirect()->back()->with('error', 'No se puede eliminar el rol ADMINISTRADOR o ALUMNO o PROFES');
                }
            } else {
                return redirect()->back()->with('error', 'Departamento no encontrado.');
            }
        }else {
        }
    }
}
