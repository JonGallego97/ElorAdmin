<?php

namespace App\Http\Controllers;

use App\Models\User;
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
    public function show(Cycle $cycle)
    {
        return view('cycles.show',['cycle'=>$cycle]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cycle $cycle)
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
    public function destroy(Cycle $cycle)
    {
        $cycle->delete();
        return redirect()->route('cycles.index');
    }
}
