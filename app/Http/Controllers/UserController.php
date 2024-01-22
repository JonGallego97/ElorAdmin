<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RoleUser;
use App\Models\Department;
use App\Models\Role;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cycle;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexStudent(Request $request)
    {

        if ($request->is('admin*')) {
            //si es admin
            $perPage = $request->input('per_page', 10);
            $users = User::whereHas('roles', function ($query) {
                $query->where('id', 3);
            })
            ->orderBy('name', 'asc')
            ->paginate($perPage, ['id', 'email', 'name', 'surname1', 'surname2', 'DNI', 'address', 'phone_number1', 'phone_number2', 'image', 'dual', 'first_login', 'year', 'created_at', 'updated_at']);

            $totalUsers = User::whereHas('roles', function ($query) {
                $query->where('id', 3);
            })->count();

            $users->totalUsers = $totalUsers;
        }else {
            //si no es admin

        }

        return view('admin.users.index',compact('users'));
    }


    public function index(Request $request)
    {


      /*$adminRole = Role::select('id','name')->where('name','ADMINISTRADOR')->first();
        //dd($adminRole);
        $rolesArray = Auth::user()->roles;
        //dd($rolesArray[0]->name);
        if($rolesArray[0]->id == $adminRole->id) {
            //dd($rolesArray);
        }
        */



        if ($request->is('admin*')) {
            //si es admin
            $perPage = $request->input('per_page', 10);
            $users = User::orderBy('name', 'asc')
            ->paginate($perPage, ['id', 'email', 'name', 'surname1', 'surname2', 'DNI', 'address', 'phone_number1', 'phone_number2', 'image', 'dual', 'first_login', 'year', 'created_at', 'updated_at']);
        }else if($request->role == 'PROFESOR'){
            //si no es admin

        }else{
            return view('person.index',compact('users'));

        }


        return view('admin.users.index',compact('users'));
    }

    public function indexTeacher(Request $request)
    {
        if ($request->is('admin*')){
            $perPage = $request->input('per_page', 10);
            $users = User::whereHas('roles', function ($query) {
                $query->where('id', 2);
            })
            ->orderBy('name', 'asc')
            ->paginate($perPage, ['id', 'email', 'name', 'surname1', 'surname2', 'DNI', 'address', 'phone_number1', 'phone_number2', 'image', 'dual', 'first_login', 'year', 'created_at', 'updated_at']);
            $totalUsers = User::whereHas('roles', function ($query) {
                $query->where('id', 2);
            })->count();

            $users->totalUsers = $totalUsers;
        }else {

        }
        return view('admin.users.index',['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->is('admin*')) {
            //si es admin
            $user = new User();
            $roles = Role::select('id','name')->orderBy("id")->get();
            $departments = Department::select('id','name')->orderBy("name")->get();
            $cycles = Cycle::select('id','name')->orderBy('name')->get();

            return view('admin.users.edit_create', ['user'=>$user,'roles'=>$roles,'departments' => $departments,'cycles' => $cycles]);
            // if(optional(User::find($user->id)->roles->first())->id == 2){
            //     //Si es profesor
            //     $user = new User();
            //     return view('admin.users.edit_create', ['user'=>$user]);
            // }else if($user->role->id == 3){

            // }


        }else {
            //si no es admin

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request);
        if($request->role != 'ALUMNO' && $request->department_id == null) {
            return('Debes seleccionar un departamento');
        }
        if($request->role == 'ALUMNO') {
            switch(true) {
                case $request->department_id != null:

                break;
                case $request->roles != null:

                break;

            }
                
            return ('Un alumno no puede tener un departamento');
        }


        $request->validate([
            'email' =>'required|string',
            'password' => '<PASSWORD>',
            'name' =>'required|string',
            'surname1' =>'required|string',
            'surname2' =>'required|string',
            'DNI' =>'required|string',
            'address' =>'required|string',
            'phoneNumber1' =>'required|integer',
            'phoneNumber2' =>'required|integer',
            'year' => 'integer|digits_between:1,2',
            'dual' => 'boolean'
        ]);

        // $request->firstLogin = true;

        $user = new User();
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->name = $request->name;
        $user->surname1 = $request->surname1;
        $user->surname2 = $request->surname2;
        $user->DNI = $request->DNI;
        $user->address = $request->address;
        $user->phoneNumber1 = $request->phoneNumber1;
        $user->phoneNumber2 = $request->phoneNumber2;
        $user->firstLogin = false;
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
    public function show(User $user, Request $request)
    {

        if ($request->is('admin*')) {
            //si es admin
            $user = User::with('roles','cycles.modules')->where('id', $user->id)->first();
                //$image = (new ControllerFunctions)->createImageFromBase64($user->image);
                $imageData = base64_decode($user->image);
                $fileName = $user->dni . '.png';
                $filePath = public_path('images/' . $fileName);
                if(!file_exists($filePath)) {
                    file_put_contents($filePath,$imageData);
                }
                return view('admin.users.show', ['user' => $user])->with('imagePath','images/'.$fileName);
            // if(optional(User::find($user->id)->roles->first())->id == 2){
            //     //Si es profesor
            //     $user = User::with('roles','cycles.modules')->where('id', $user->id)->first();
            //     //$image = (new ControllerFunctions)->createImageFromBase64($user->image);
            //     $imageData = base64_decode($user->image);
            //     $fileName = $user->dni . '.png';
            //     $filePath = public_path('images/' . $fileName);
            //     if(!file_exists($filePath)) {
            //         file_put_contents($filePath,$imageData);
            //     }
            //     return view('admin.users.teachers.show', ['user' => $user])->with('imagePath','images/'.$fileName);
            // }else if(optional(User::find($user->id)->roles->first())->id == 3){
            //     $user = User::with('roles', 'cycles.modules')->where('id', $user->id)->first();
            //     return view('admin.users.students.show', ['user' => $user]);

            //     // Puedes examinar o hacer algo con el usuario modificado

            //     return view('admin.users.students.show',['user'=>$user]);
            // }else{
            //     $user = User::with('roles', 'cycles.modules')->where('id', $user->id)->first();
            //     return view('admin.users.show', ['user' => $user]);
            // }


        }else {
            //si no es admin

        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user, Request $request)
    {
        if ($request->is('admin*')) {
            //si es admin
            $departments = Department::select('id','name')->orderBy("name")->get();
                $roles = Role::all();
                $cycles_modules = Cycle::with('modules')->get();
                return view('admin.users.edit_create', ['user'=>$user, 'roles'=> $roles, 'cycles_modules'=>$cycles_modules,'departments' => $departments]);
            // if(optional(User::find($user->id)->roles->first())->id == 2){
            //     //Si es profesor

            //     $departments = Department::select('id','name')->orderBy("name")->get();
            //     $roles = Role::all();
            //     $cycles_modules = Cycle::with('modules')->get();
            //     return view('admin.users.edit_create', ['user'=>$user, 'roles'=> $roles, 'cycles_modules'=>$cycles_modules,'departments' => $departments]);
            // }else if(optional(User::find($user->id)->roles->first())->id == 3){
            //     //Si es profesor

            //     $roles = Role::all();
            //     $cycles_modules = Cycle::with('modules')->get();
            //     return view('admin.users.teachers.edit_create', ['user'=>$user, 'roles'=> $roles, 'cycles_modules'=>$cycles_modules]);
            // }


        }else {
            //si no es admin

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $user->name = $request->name;
        $user->save();

        return view('cycles.show',['user'=>$user]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $userId)
    {
        if ($request->is('admin*')) {
            // //si es admin
            // if(optional(User::find($userId)->roles->first())->id == 2){
            //     //Si es profesor
            //     $redirectRoute = 'admin.teachers.index';
            // }else if(optional(User::find($userId)->roles->first())->id == 3){
            //     $redirectRoute = 'admin.students.index';
            // }
            $user = User::find($userId);
            if ($user && $user->id != 0) {
                $user->delete();
                return redirect()->back()->with('success', 'Usuario eliminado exitosamente.');
            } else {
                return redirect()->back()->with('error', 'Usuario no encontrado.');
            }
        }else {
        }
    }

    public function enrollStudentInCycle($userId, $cycleId)
    {
        $user = User::findOrFail($userId);
        $cycle = Cycle::findOrFail($cycleId);

        if ($user->hasRole('ALUMNO')) {
            // Asociar al estudiante con el ciclo
            $user->cycles()->attach($cycle->id);

            // Obtener los módulos asociados al ciclo
            $modules = $cycle->modules;

            // Enrollar al estudiante en cada módulo
            $user->modules()->attach($modules);

            return response()->json(['message' => 'Estudiante matriculado en el ciclo y sus módulos.']);
        } else {
            // Si el usuario no es un estudiante, retornar un mensaje de error o realizar otras acciones según sea necesario
            return response()->json(['error' => 'Solo los estudiantes pueden ser matriculados en ciclos.']);
        }
    }

    public function enrollTeacherInModule($userId, $moduleId)
    {
        $user = User::findOrFail($userId);
        $module = Module::findOrFail($moduleId);

        if ($user->hasRole('PROFESOR')) {
            // Validar que el profesor no esté ya asignado al módulo
            if (!$user->modules->contains($module->id)) {
                // Asociar al profesor con el módulo
                $user->modules()->attach($module->id);

                return response()->json(['message' => 'Profesor asignado al módulo.']);
            } else {
                return response()->json(['error' => 'El profesor ya está asignado a este módulo.']);
            }
        } else {
            // Si el usuario no es un profesor, retornar un mensaje de error que incluya los roles del usuario
            return response()->json(['error' => "Solo los profesores pueden ser asignados a módulos."]);
        }
    }

    public function editRoles(Request $request, User  $user) {
        $roleList = $request->input('selectedRoles');
        $rolesArray = explode(',', $roleList);

        // Busca los roles en la base de datos con los IDs proporcionados
        $roles = Role::whereIn('id', $rolesArray)->get();
        $user->roles = $roles;
        $roles = Role::all();
        $cycles_modules = Cycle::with('modules')->get();
        return view('admin.users.edit_create', ['user'=>$user, 'roles'=> $roles, 'cycles_modules'=>$cycles_modules]);
    }

    public function editCycles(Request $request, User $user) {

        $cycleList = $request->input('selectedCycles');
        $cyclesArray = explode(',', $cycleList);


        // $cycles = Cycle::whereIn('id', $cyclesArray)
        //     ->with(['modules' => function ($query) use ($user) {
        //         $query->whereHas('users', function ($query) use ($user) {
        //             $query->where('user_id', $user->id);
        //         });
        //     }])
        //     ->get();
        $cycles = Cycle::whereIn('id', $cyclesArray)
        ->with('modules')
        ->get();
        $user->cycles = $cycles;
        $roles = Role::all();
        $cycles_modules = Cycle::with('modules')->get();

        return view('admin.users.edit_create', ['user'=>$user, 'roles'=> $roles, 'cycles_modules'=>$cycles_modules]);
    }
}
