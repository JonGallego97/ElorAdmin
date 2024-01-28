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
use App\Http\Controllers\ControllerFunctions;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;


class UserController extends Controller {

    private $ControllerFunctions;

    function __construct() {
        $this->ControllerFunctions = new ControllerFunctions;
    }

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
            return view('admin.index',compact('users'));

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
            return redirect()->back()->with('error', 'No eres ADMINISTRADOR');
        }
        return view('admin.users.index',['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->is('admin*') && $this->ControllerFunctions->checkAdminRole()) {
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

    public function extra_create(Request $request) {
        $userRoles = $request->roles;
        if($userRoles == 0) {
            return('Debes seleccionar un rol');
        }

        $userRolesNames = Array();
        foreach ($userRoles as $userRole) {
            $roleName = Role::select('name')->where('id',$userRole)->first();
            $userRolesNames[$userRole] = $roleName->name;
        }

        $studentRole = Role::select('id','name')->where('name','ALUMNO')->first();
        $teacherRole = Role::select('id','name')->where('name','PROFESOR')->first();
        $isStudent = in_array($studentRole->id,$userRoles,false);
        $isTeacher = in_array($teacherRole->id,$userRoles,false);
        
        //Es alumno
        if($isStudent) {
            switch(true) {
                case $request->department_id != null:
                    return ('Un alumno no puede tener un departamento');
                    break;
                case count($userRoles) > 1:
                    return ('Un alumno no puede tener mas de un rol');
                    break;
            }
        }
        // $request->validate([
        //     'name' =>'required|string',
        //     'surname1' =>'required|string',
        //     'surname2' =>'required|string',
        //     'DNI' =>'required|string',
        //     'address' =>'required|string',
        //     'phoneNumber1' =>'required|integer',
        //     'phoneNumber2' =>'required|integer',
        //     'year' => 'nullable|integer',
        //     'dual' => 'nullable|boolean'
        // ]);

        // $request->firstLogin = true;

        //Comprobamos si DNI es real
        if(!$this->ControllerFunctions->checkDni($request->dni)) {
            return ('El DNI no es correcto.');
        }


        $user = new User();
        // $user->password = bcrypt($request->password);
        $user->name = ucfirst(strtolower($request->name));
        $user->surname1 = ucfirst(strtolower($request->surname1));
        $user->surname2 = ucfirst(strtolower($request->surname2));
        $user->dni = $request->dni;
        $user->address = ucwords(strtolower($request->address));
        $user->phone_number1 = $request->phone_number1;
        $user->phone_number2 = $request->phone_number2;
        $user->first_login = false;
        $user->image = "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";

        $userName = $user->name . $user->surname1 . substr($user->surname2,0,2);
        $domainName = "@elorrieta-errekamari.com";

        $user->email = strtolower($userName . $domainName);

        $user->password = bcrypt($userName . date("Y"));

        $user->save();
        try {
            foreach ($userRoles as $role) {
                $role_user = new RoleUser();
                $role_user->role_id = $role;
                $role_user->user_id = $user->id;
                $role_user->save();
            }
        } catch (QueryException $ex){
            dd($ex->getMessage());
        }

        $roles = Role::select('id','name')->orderBy("id")->get();
        $departments = Department::select('id','name')->orderBy("name")->get();
        $cycles = Cycle::with('modules')->orderBy('department_id')->get();

        $englishModulesCodes = Module::where('name','Inglés Técnico')->pluck('code')->toArray();
        $englishModules = Cycle::with(['modules' => function ($query) use ($englishModulesCodes) {
            $query->where('code', $englishModulesCodes);
        }])->get();

        return view('admin.users.extra_create', ['user_id'=>$user->id,'userRolesNames'=>$userRolesNames,'englishModules' => $englishModules, 'roles'=> $roles,'departments' => $departments,'cycles' => $cycles]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $user = User::with('roles')->where('id', $request->user_id)->first();

        $userRoles = $user->roles->pluck('id')->toArray();

        $studentRole = Role::select('id','name')->where('name','ALUMNO')->first();
        $isStudent = in_array($studentRole->id,$userRoles,false);
        $teacherRole = Role::select('id','name')->where('name','PROFESOR')->first();
        $isTeacher = in_array($teacherRole->id,$userRoles,false);
        $adminRole = Role::select('id','name')->where('name','ADMINISTRADOR')->first();
        $isAdmin = in_array($adminRole->id,$userRoles,false);
        

        
        //Datos Extra
        if($isStudent){
            $user->year = $request->year;
            $user->dual = (int)$request->dual;
            
        } else if(!$isAdmin) {
            if($request->department != 0) {
                $user->department_id = $request->department;
            } else {
                return('Debes seleccionar un departamento');
            }           
        }
        $user->save();



        // Ciclos
        
        if($isStudent){
            $result = $this->enrollStudentInCycle($user->id,$request->cycle);
        } elseif ($isTeacher) {
            if(is_array($request->modules)) {
                foreach($request->modules as $module) {
                    $modulesArray = explode("/",$module);
                    $cycle_id = $modulesArray[0];
                    $module_id = $modulesArray[1];
                    $result =$this->enrollTeacherInModule($user->id, $module_id,$cycle_id);
                }
            } else {
                $modulesArray = explode("/",$request->modules);
                $cycle_id = $modulesArray[0];
                $module_id = $modulesArray[1];
                $result =$this->enrollTeacherInModule($user->id, $module_id,$cycle_id);
            }
            
        } else {
            $result = false;
        }
        
        if($result) {
            return redirect()->route('users.show',['user'=>$user]);
        } else {
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user, Request $request)
    {
        $userRoles = $user->roles->pluck('id')->toArray();

        $studentRole = Role::select('id','name')->where('name','ALUMNO')->first();
        $isStudent = in_array($studentRole->id,$userRoles,false);
        $teacherRole = Role::select('id','name')->where('name','PROFESOR')->first();
        $isTeacher = in_array($teacherRole->id,$userRoles,false);

        $user = User::with('roles','cycles.modules','department','modules')->where('id', $user->id)->first();
        $fileName =    $this->ControllerFunctions->createImageFromBase64($user);

        if ($request->is('admin*')) {
            //si es admin
            switch (true) {
                case $isStudent:
                    return view('admin.users.show', ['user' => $user])->with('imagePath','images/'.$fileName);
                    break;
                case $isTeacher:
                    $userModules = $user->modules; // Obtener los módulos del usuario
                    $cyclesWithModules = [];

                    foreach ($userModules as $module) {
                        $moduleCycles = $module->cycles; // Obtener los ciclos relacionados con el módulo
                        foreach ($moduleCycles as $cycle) {
                            $cycleId = $cycle->id;
                            $cycleName = $cycle->name;

                            // Verificar si el ciclo ya está en $cyclesWithModules por su 'id'
                            if (!array_key_exists($cycleId, $cyclesWithModules)) {
                                $cyclesWithModules[$cycleId] = [
                                    'id' => $cycleId,
                                    'name' => $cycleName,
                                    'modules' => [],
                                ];
                            }

                            // Agregar el módulo al ciclo correspondiente
                            $cyclesWithModules[$cycleId]['modules'][] = [
                                'id' => $module->id,
                                'name' => $module->name,
                                'code' => $module->code,
                                'hours' => $module->hours
                            ];
                        }
                    }
                    return view('admin.users.show', ['user' => $user,'cyclesWithModules' => $cyclesWithModules])->with('imagePath','images/'.$fileName);
                    break;
                default:
                    return view('admin.users.show', ['user' => $user])->with('imagePath','images/'.$fileName);
                    break;
            }

            
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
        if ($request->is('admin*') && $this->ControllerFunctions->checkAdminRole()) {
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
        if ($this->ControllerFunctions->checkAdminRole()) {
            dd($request);
            $user->name = $request->name;
            $user->save();

            return view('cycles.show',['user'=>$user]);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $userId)
    {
        
        if ($request->is('admin*') && $this->ControllerFunctions->checkAdminRole()) {
            $user = User::find($userId);
            if ($user && $user->id != 0) {
                $user->delete();
                return redirect()->back()->with('success', 'Usuario eliminado exitosamente.');
            } else {
                return redirect()->back()->with('error', 'No se puede eliminar el usuario ADMINISTRADOR');
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
            $lastRegistration = DB::table('cycle_users')->orderByDesc('cycle_registration_number')->first();
            $sync_data = array(['cycle_id'=>$cycle->id,'cycle_registration_number' => $lastRegistration->cycle_registration_number+1,'registration_date'=>date('Y-m-d')]);
            //dd($sync_data);
            $user->cycles()->attach($sync_data);

            // Obtener los módulos asociados al ciclo
            $modules = $cycle->modules;
            // Enrollar al estudiante en cada módulo
            $user->modules()->attach($modules,['cycle_id' => $cycle->id]);

            return true;
            // return response()->json(['message' => 'Estudiante matriculado en el ciclo y sus módulos.']);
        } else {
            // Si el usuario no es un estudiante, retornar un mensaje de error o realizar otras acciones según sea necesario
            // return response()->json(['error' => 'Solo los estudiantes pueden ser matriculados en ciclos.']);
            return false;
        }
    }

    public function enrollTeacherInModule($userId, $moduleId,$cycleId)
    {
        $user = User::findOrFail($userId);
        $module = Module::findOrFail($moduleId);

        if ($user->hasRole('PROFESOR')) {
            // Validar que el profesor no esté ya asignado al módulo
            if (!$user->modules->contains($module->id)) {
                // Asociar al profesor con el módulo
                $user->modules()->attach($module->id, ['cycle_id' => $cycleId]);

                return true;
                // return response()->json(['message' => 'Profesor asignado al módulo.']);
            } else {
                return false;
                // return response()->json(['error' => 'El profesor ya está asignado a este módulo.']);
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
