<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Cycle;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/* class PersonController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $usera = User::All();

        $cycle = cycle::find($user->id);
        //dd($cycle);

        // Verificar si el usuario autenticado tiene el rol deseado
        if (User::find($user->id)->roles->first()->id == 2) {
            // Si tiene el rol deseado, filtrar los usuarios por ese rol
            $usera = User::whereHas('roles', function ($query) {
                $query->where('id', 2);
            })->get();
        }
    // Obtener los ciclos y módulos del usuario
    $cycles = $user->cycles;

    $usersInRole3ByModule=[];
//dd($cycles);
    foreach ($cycles as $cycles) {
        foreach ($cycles as $users) {
            if ($user->roles->first()->id == 2) {
            $usersInRole3ByModule=$users;
            //dd($usersInRole3ByModule);
        }
        }
    }


    // Obtener los datos adicionales del usuario autenticado
    $user = User::with('roles', 'cycles.modules', 'modules')->where('id', $user->id)->first();


    return view('persons.index', compact('user','usersInRole3ByModule','usera', 'cycle'));
    }

    public function staff(Request $request)
    {
    $user = Auth::user(); // Obtener el usuario autenticado

    if (User::find($user->id)->roles->first()->id == 2) {
        $perPage = $request->input('per_page', App::make('paginationCount'));
        $users = User::whereHas('roles', function ($query) {
            $query->where('id', 2);
        })
            ->orderBy('name', 'asc')
            ->paginate($perPage, ['id', 'email', 'name', 'surname1', 'surname2', 'DNI', 'address', 'phone_number1', 'phone_number2', 'image', 'is_dual', 'first_login', 'year', 'created_at', 'updated_at']);
        $totalUsers = User::whereHas('roles', function ($query) {
            $query->where('id', 2);
        })->count();

        $users->totalUsers = $totalUsers;
    } else {

    }
    return view('persons.staff.index', ['users' => $users]);
    }

    public function staffShow(Request $request, $user1, $user2)
    {
        // Lógica para obtener la información de los usuarios según sus identificadores ($user1 y $user2)
        $user1Data = User::findOrFail($user1);
        $user2Data = User::findOrFail($user2);

        $user1= Auth::user(); // Obtener el usuario autenticado
        // Lógica adicional...

        // Retornar la vista con los datos de los usuarios
    return view('persons.staff.show', compact('user1Data', 'user2Data'), ['user1' => $user1]);
    }
}
 */