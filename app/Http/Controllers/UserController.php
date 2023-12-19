<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RoleUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('name', 'asc')->get(['id', 'email', 'name', 'surname1', 'surname2', 'DNI', 'address', 'phoneNumber1', 'phoneNumber2', 'image', 'dual', 'firstLogin', 'year', 'created_at', 'updated_at']);
        return view('users.index',['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->role != 'ALUMNO' && $request->department_id == null) {
            return message('Debes seleccionar un departamento');
        }
        if($request->role == 'ALUMNO' && $request->department_id != null) {
            return message('Un alumno no puede tener un departamento');
        }


        $request->varidate([
            'email' =>'required|string',
            'password' => '<PASSWORD>',
            'name' =>'required|string',
            'surname1' =>'required|string',
            'surname2' =>'required|string',
            'DNI' =>'required|string',
            'address' =>'required|string',
            'phoneNumber1' =>'required|integer',
            'phoneNumber2' =>'required|integer',

        ]);
        $request->firstLogin = true;

        $user = new User();
        $user->email = $request->email;
        $user->password = ($request->password);
        $user->name = $request->name;
        $user->surname1 = $request->surname1;
        $user->surname2 = $request->surname2;
        $user->DNI = $request->DNI;
        $user->address = $request->address;
        $user->phoneNumber1 = $request->phoneNumber1;
        $user->phoneNumber2 = $request->phoneNumber2;
        $user->firstLogin = $request->firstLogin;
        $user->year = $request->year;
        $user->department_id = $request->department;

        $user->save();

        $role_user = new RoleUser();
        $role_user->role_id = $request->role;
        $role_user->user_id = $user->id;
        $role_user->save();

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cycle $user)
    {
        return view('users.show',['user'=>$user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cycle $user)
    {
        return view('users.create');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cycle $user)
    {
        $cycle->name = $request->name;
        $cycle->save();

        return view('cycles.show',['cycle'=>$cycle]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cycle $cycle)
    {
        $cycle->delete();
        return redirect()->route('cycles.index');
    }
}
