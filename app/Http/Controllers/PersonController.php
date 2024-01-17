<?php

namespace App\Http\Controllers;


use App\Models\User;

use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function index(User $user)
    {
        //dd($user);
        $user = User::with('roles', 'cycles.modules', 'modules')->where('id', $user->id)->first();
        return view('persons.index', ['user'=>$user]);
    }

}
