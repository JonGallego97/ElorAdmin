<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Department;
use App\Models\Module;
use App\Models\Cycle;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $ControllerFunctions;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->ControllerFunctions = new ControllerFunctions;
    }
    //$this->ControllerFunctions->checkAdminRoute()

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        if($this->ControllerFunctions->checkAdminRole()) {
            $fileName =    $this->ControllerFunctions->createImageFromBase64($user);
            return view('admin.home',compact('user'))->with('imagePath','images/'.$fileName);;
        } else {
            $usera = User::All();

            $cycle = Cycle::find($user->id);
    
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
            foreach ($cycles as $cycles) {
                foreach ($cycles as $users) {
                    if ($user->roles->first()->id == 2) {
                    $usersInRole3ByModule=$users;
                    }
                }
            }

           



            
    
            // Obtener los datos adicionales del usuario autenticado
            $user = User::with('roles', 'cycles.modules', 'modules')->where('id', $user->id)->first();
    
            return view('home',compact('user','usersInRole3ByModule','usera','cycle'));
        }
    }
}
