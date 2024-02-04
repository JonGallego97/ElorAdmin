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
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App;


class UserController extends Controller {

    private $ControllerFunctions;

    function __construct() {
        $this->ControllerFunctions = new ControllerFunctions;
    }
    //$this->ControllerFunctions->checkAdminRoute()

    /**
     * Display a listing of the resource.
     */
/*     public function indexStudent(Request $request)
    {

        if ($this->ControllerFunctions->checkAdminRoute()) {
            //si es admin
            $perPage = $request->input('per_page', App::make('paginationCount'));
            $users = User::whereHas('roles', function ($query) {
                $query->where('id', 3);
            })
            ->orderBy('name', 'asc')
            ->paginate($perPage, ['id', 'email', 'name', 'surname1', 'surname2', 'DNI', 'address', 'phone_number1', 'phone_number2', 'image', 'is_dual', 'first_login', 'year', 'created_at', 'updated_at']);

            $totalUsers = User::whereHas('roles', function ($query) {
                $query->where('id', 3);
            })->count();

            $users->totalUsers = $totalUsers;
            return view('admin.users.index',compact('users'));
        }else {
            return redirect()->back()->with('error', __('errorNoAdmin'));
        }

        
    }

    public function indexTeacher(Request $request)
    {
        if ($this->ControllerFunctions->checkAdminRoute()){
            dd(Route::getCurrentRoute());
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
            return view('admin.users.index',['users'=>$users]);
        }else {
            return redirect()->back()->with('error', __('errorNoAdmin'));
        }
        
    } */


    public function index(Request $request) {

        if ($this->ControllerFunctions->checkAdminRoute()) {
            $route = Route::getCurrentRoute()->uri;
            $isTeachers = Str::contains($route,'admin/teachers');
            $isStudents = Str::contains($route,'admin/students');
            $hasNoRole = str::contains($route,'admin/withoutRole');
            $personal = str::contains($route,'admin/personal');

            /*
            en config/pagination.php  
            <?php

            return [
                'per_page' => 15,
            ];

            $posts = Post::paginate(config('pagination.per_page'));

            */
            
            $perPage = $request->input('per_page', App::make('paginationCount'));

            switch(true) {

                case $isTeachers:
                    $users = User::whereHas('roles', function ($query) {
                        $query->where('id', $this->ControllerFunctions->getTeacherRoleId());
                    })
                    ->orderBy('name', 'asc')
                    ->paginate($perPage);
                    $totalUsers = User::whereHas('roles', function ($query) {
                        $query->where('id', $this->ControllerFunctions->getTeacherRoleId());
                    })->count();

                    $users->totalUsers = $totalUsers;
                    //return view('admin.users.index',['users'=>$users]);
                    break;

                case $isStudents:
                    $users = User::whereHas('roles', function ($query) {
                        $query->where('id', $this->ControllerFunctions->getStudentRoleId());
                    })
                    ->orderBy('name', 'asc')
                    ->paginate($perPage, ['id', 'email', 'name', 'surname1', 'surname2', 'DNI', 'address', 'phone_number1', 'phone_number2', 'image', 'first_login', 'created_at', 'updated_at']);

                    $totalUsers = User::whereHas('roles', function ($query) {
                        $query->where('id', $this->ControllerFunctions->getStudentRoleId());
                    })->count();

                    $users->totalUsers = $totalUsers;
                    //return view('admin.users.index',compact('users'));
                    break;

                case $hasNoRole:
                    $users = User::doesntHave('roles')
                        ->orderBy('name', 'asc')
                        ->paginate($perPage, ['id', 'email', 'name', 'surname1', 'surname2', 'DNI', 'address', 'phone_number1', 'phone_number2', 'image', 'first_login', 'created_at', 'updated_at']);

                    $totalUsers = User::doesntHave('roles')->count();

                    $users->totalUsers = $totalUsers;
                    break;

                case $personal:
                    $perPage = $request->input('per_page', App::make('paginationCount'));

                    $users = User::whereHas('roles', function ($query) {
                        $query->whereNotIn('name', ['alumno', 'profesor','administrador']);
                    })
                    ->orderBy('name', 'asc')
                    ->paginate($perPage, ['id', 'email', 'name', 'surname1', 'surname2', 'DNI', 'address', 'phone_number1', 'phone_number2', 'image', 'first_login', 'created_at', 'updated_at']);

                    $totalUsers = User::whereHas('roles', function ($query) {
                        $query->whereNotIn('name', ['alumno', 'profesor']);
                    })
                    ->count();

                    $users->totalUsers = $totalUsers;
                    break;

                default:
                    $users = User::orderBy('name', 'asc')
                    ->paginate($perPage, ['id', 'email', 'name', 'surname1', 'surname2', 'DNI', 'address', 'phone_number1', 'phone_number2', 'image', 'first_login', 'created_at', 'updated_at']);
                    
                    break;
                    //return view('admin.users.index',compact('users'));
            }
            return view('admin.users.index',compact('users'));

            //Si viene de admin
            

        }else{

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
            return view('users.index', ['users' => $users]);

            $roleStudent = Role::where('name','ALUMNO')->first();
            $roleTeacher = Role::where('name','PROFESOR')->first();
            $logedUserRoles = Auth::user()->roles->pluck('id')->toArray();

            switch(true) {
                case in_array($roleStudent->id,$logedUserRoles):
                    break;
                case in_array($roleTeacher->id,$logedUserRoles):
                    break;
                default:
                    break;
            }
        }
    }

    public function staff(Request $request)
    {
        //Ya esta pasado
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
        return view('staff.index', ['users' => $users]);
    }

    public function staffShow(Request $request, $user1, $user2)
    {
        // Lógica para obtener la información de los usuarios según sus identificadores ($user1 y $user2)
        $user1Data = User::findOrFail($user1);
        $user2Data = User::findOrFail($user2);

        $user1= Auth::user(); // Obtener el usuario autenticado
        // Lógica adicional...

        // Retornar la vista con los datos de los usuarios
    return view('staff.show', compact('user1Data', 'user2Data'), ['user1' => $user1]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($this->ControllerFunctions->checkAdminRoute() && $this->ControllerFunctions->checkAdminRole()) {
            //si es admin
            $user = new User();
            $roles = Role::select('id','name')->orderBy("id")->get();
            $departments = Department::select('id','name')->orderBy("name")->get();
            $cycles = Cycle::select('id','name')->orderBy('name')->get();

            return view('admin.users.edit_create', ['user'=>$user,'roles'=>$roles,'departments' => $departments,'cycles' => $cycles]);

        }else {
            //si no es admin
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }
    }

    public function extra_create(Request $request) {

        $studentRole = Role::select('id','name')->where('name','ALUMNO')->first();
        $teacherRole = Role::select('id','name')->where('name','PROFESOR')->first();

        $messages = [
            'name.required' => __('errorMessageNameEmpty'),
            'name.regex' => __('errorMessageNameLettersOnly'),
            'surname1.required' => __('errorMessageNameEmpty'),
            'surname1.regex' => __('errorMessageNameLettersOnly'),
            'surname2.required' => __('errorMessageNameEmpty'),
            'surname2.regex' => __('errorMessageNameLettersOnly'),
            'dni.required' => __('errorMessageNameEmpty'),
            'dni.regex' => __('errorDNILettersAndNumbersOnly'),
            'address.required' => __('errorMessageCodeEmpty'),
            'address.string' => __('errorMessageCodeInteger'),
            'code.unique' => __('errorModuleCodeExists'),
            'phone_number1.required' => __('errorTelephoneIsRequired'),
            'phone_number1.integer' => __('errorTelephoneMustBeInteger'),
            'phone_number2.required' => __('errorTelephoneIsRequired'),
            'phone_number2.integer' => __('errorTelephoneMustBeInteger'),
            'roles.required' => __('errorRoleRequired'),
            'roles.array' => __('errorRoleRequired'),
        ];

        $request->validate([
            'name' =>['required', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s]+$/u'],
            'surname1' =>['required', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s]+$/u'],
            'surname2' =>['required', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s]+$/u'],
            'dni' => ['required', 'regex:/^[a-zA-Z0-9]+$/', function ($attribute, $value, $fail) {
                if (!$this->ControllerFunctions->checkDni($value)) {
                    $fail(__('errorInvalidDNI'));
                }
            }],
            'address' =>['required','string'],
            'phone_number1' =>['required','integer'],
            'phone_number2' =>['required','integer'],
            'year' => ['nullable','integer'],
            'is_dual' => ['boolean'],
            'roles' => ['required','array',function ($attribute, $value, $fail) use ($request,$studentRole) {
                $userRoles = $request->input('roles', []);
                if (in_array($studentRole->id,$userRoles,false) && count($userRoles)!=1) {
                    $fail(__('errorStudentCantHaveMoreRoles'));
                }
            }],
        ],$messages);

        $userRoles = $request->input('roles', []);


        $userRolesNames = Array();
        foreach ($userRoles as $userRole) {
            $roleName = Role::select('name')->where('id',$userRole)->first();
            $userRolesNames[$userRole] = $roleName->name;
        }
       


        $user = new User();
        $user->name = ucfirst(strtolower($request->name));
        $user->surname1 = ucfirst(strtolower($request->surname1));
        $user->surname2 = ucfirst(strtolower($request->surname2));
        $user->dni = $request->dni;
        $user->address = ucwords(strtolower($request->address));
        $user->phone_number1 = $request->phone_number1;
        $user->phone_number2 = $request->phone_number2;
        $user->first_login = false;
        $user->image = "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";

        $userName =  $user->name . "." . $user->surname1 . substr($user->surname2,0,2);
        $userName = str_replace(" ","",$userName);
        $tilesList = array(
            'á' => 'a',
            'é' => 'e',
            'í' => 'i',
            'ó' => 'o',
            'ú' => 'u',
            'ñ' => 'n',
            'Á' => 'A',
            'É' => 'E',
            'Í' => 'I',
            'Ó' => 'O',
            'Ú' => 'U',
            'Ñ' => 'N'
        );
        
        $userName = strtr($userName, $tilesList);
        $domainName = "@elorrieta-errekamari.com";

        $user->email = strtolower($userName . $domainName);

        $user->password = bcrypt(str_replace(".","",$userName) . date("Y"));

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

        $languageModulesCodes = Module::whereIn('name', ['Inglés Técnico', 'Inglés', 'Segunda lengua extranjera'])->pluck('code')->toArray();
        $languageModules = Cycle::with(['modules' => function ($query) use ($languageModulesCodes) {
            $query->where('code', $languageModulesCodes);
        }])->get();
        if($user->hasRole("ADMINISTRADOR")){
            return redirect()->route('admin.users.show',['user'=>$user]);
        } else {
            return view('admin.users.extra_create', ['user_id'=>$user->id,'userRolesNames'=>$userRolesNames,'languageModules' => $languageModules, 'roles'=> $roles,'departments' => $departments,'cycles' => $cycles]);
        }
       
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($this->ControllerFunctions->checkAdminRoute() && $this->ControllerFunctions->checkAdminRole()) {

            $messages = [
                'cycles.required' => __('errorMessageCyclesEmpty'),
                'department.required' => __('errorMessageDepartmentEmpty'),
                'department.not_in' => __('errorMessageDepartmentEmpty'),
                'modules.required' => __('errorMessageModulesEmpty'),
                'cycle.required' => __('errorMessageCyclesEmpty'),
                'modules.required' => __('errorModulesEmpty'),
                'modules.array' => __('errorModulesEmpty'),
            ];

            $user = User::where('id',$request->user_id)->first();

            switch (true){
                case $user->hasRole("ALUMNO"):
                    $request->validate([
                        'cycle' => ['required'],
                    ],$messages);
                    break;
                case $user->hasRole("PROFESOR"):
                    $request->validate([
                        'department' =>['required','not_in:0'],
                        'modules' =>['required','array'],
                    ],$messages);
                    break;
                default:
                    $request->validate([
                        'department' =>['required','not_in:0'],
                    ],$messages);
                    break;
            }
            
            

            $user = User::with('roles')->where('id', $request->user_id)->first();

            $userRoles = $user->roles->pluck('id')->toArray();

            $studentRole = Role::select('id','name')->where('name','ALUMNO')->first();
            $isStudent = in_array($studentRole->id,$userRoles,false);
            $teacherRole = Role::select('id','name')->where('name','PROFESOR')->first();
            $isTeacher = in_array($teacherRole->id,$userRoles,false);
            $adminRole = Role::select('id','name')->where('name','ADMINISTRADOR')->first();
            $isAdmin = in_array($adminRole->id,$userRoles,false);
            

            
            //Datos Extra
            if(!$isAdmin && !$isStudent) {
                $user->department_id = $request->department;     
            }
            $user->save();

            // Ciclos
            
            if($isStudent){
                $result = $this->enrollStudentInCycle($user->id,$request->newCycle,$request->year,$request->is_dual);
            } elseif ($isTeacher) {
                $modules = $request->input('modules');
                foreach($modules as $module) {
                    $modulesArray = explode("/",$module);
                    $cycle_id = $modulesArray[0];
                    $module_id = $modulesArray[1];
                    $result =$this->enrollTeacherInModule($user->id, $module_id,$cycle_id);
                }
                /* if(is_array($request->input('modules'))) {
                    foreach($modules as $module) {
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
                } */
                
            } else {
                $result = true;
            }
            
            if($result) {
                return redirect()->route('admin.users.show',['user'=>$user]);
            } else {
                return redirect()->back()->withErrors('error', __('errorCreate'));
            }
        } else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }

        
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $userRoles = $user->roles->pluck('id')->toArray();

        $studentRole = Role::select('id','name')->where('name','ALUMNO')->first();
        $isStudent = in_array($studentRole->id,$userRoles,false);
        $teacherRole = Role::select('id','name')->where('name','PROFESOR')->first();
        $isTeacher = in_array($teacherRole->id,$userRoles,false);

        $user = User::with('roles','cycles.modules','department','modules','cycles')->where('id', $user->id)->first();
        $fileName =    $this->ControllerFunctions->createImageFromBase64($user);

        if ($this->ControllerFunctions->checkAdminRoute()) {
            //si es admin
            switch (true) {
                ////////////////////////////////// ALUMNO //////////////////////////////////////////////////////////
                case $isStudent:
                    $departmentsWithCycles = Department::whereHas('cycles', function ($query) use ($user) {
                        $query->whereNotExists(function ($subquery) use ($user) {
                            $subquery->select('cycle_users.id')
                                     ->from('cycle_users')
                                     ->whereRaw('cycle_users.cycle_id = cycles.id')
                                     ->where('cycle_users.user_id', $user->id);
                        });
                    })
                    ->with(['cycles' => function ($query) use ($user) {
                        $query->whereNotExists(function ($subquery) use ($user) {
                            $subquery->select('cycle_users.id')
                                     ->from('cycle_users')
                                     ->whereRaw('cycle_users.cycle_id = cycles.id')
                                     ->where('cycle_users.user_id', $user->id);
                        });
                    }])
                    ->get();

                    $userModulesData = DB::table('module_user_cycle')
                        ->where('user_id', $user->id)
                        ->get();

                    // Inicializar el array para almacenar la información
                    $userData = [];

                    // Obtener ciclos y módulos con la relación directa a partir de los datos de la tabla module_user_cycle
                    foreach ($userModulesData as $userModule) {
                        $cycle = Cycle::find($userModule->cycle_id);
                        if ($cycle) {
                            $cycleId = $cycle->id;
                            $cycleName = $cycle->name;
                            $pivotData = $user->cycles()->where('cycle_id', $userModule->cycle_id)->first()->pivot;
                            $registrationNumber = $pivotData->cycle_registration_number;
                            $year = $pivotData->year;
                            $enrollYear = $pivotData->created_at->format('Y');
                            $is_dual = $pivotData->is_dual;
                    

                            if (!isset($userData[$cycleId])) {
                                $userData[$cycleId] = [
                                    'id' => $cycleId,
                                    'name' => $cycleName,
                                    'registrationNumber' => $registrationNumber,
                                    'year' => $year,
                                    'is_dual' => $is_dual,
                                    'enrollYear' => $enrollYear,
                                    'modules' => []
                                ];
                            }
                    

                            $module = Module::find($userModule->module_id);
                    
                            if ($module) {
                                $moduleData = [
                                    'id' => $module->id,
                                    'code' => $module->code,
                                    'name' => $module->name,
                                    'hours' => $module->hours
                                ];
                    

                                $userData[$cycleId]['modules'][] = $moduleData;
                            }
                        }
                    }
                    return view('admin.users.show', ['user' => $user,'userData'=>$userData,'departmentsWithCycles'=>$departmentsWithCycles])->with('imagePath','images/'.$fileName);
                    break;
                case $isTeacher:
                    ////////////////////////////////// PROFESOR //////////////////////////////////////////////////////////
                    $userModules = $user->modules; 
                    $cyclesWithModules = [];

                    foreach ($userModules as $module) {
                        $moduleCycles = $module->cycles; 
                        foreach ($moduleCycles as $cycle) {
                            $cycleId = $cycle->id;
                            $cycleName = $cycle->name;


                            if (!array_key_exists($cycleId, $cyclesWithModules)) {
                                $cyclesWithModules[$cycleId] = [
                                    'id' => $cycleId,
                                    'name' => $cycleName,
                                    'modules' => [],
                                ];
                            }

                            $cyclesWithModules[$cycleId]['modules'][] = [
                                'id' => $module->id,
                                'name' => $module->name,
                                'code' => $module->code,
                                'hours' => $module->hours
                            ];
                        }
                    }

                    $departmentEIE = ['name'=>"Empresa e Iniciativa Emprendedora",'modules'=>"Empresa e Iniciativa Emprendedora"];
                    $departmentFOL = ['name'=>"FOL",'modules'=>"Formación y Orientación Laboral"];
                    $departmentLanguages = ['name'=>"Idiomas",'modules' =>["Inglés","Inglés técnico","Segunda lengua extranjera"]];
                    $department = Department::where('id',$user->department_id)->first();
                    switch($department->name) {
                        ////////////////////////////////// FOL //////////////////////////////////////////////////////////
                        case $departmentFOL['name']:
                            $modulesNames = $departmentFOL['modules'];
                            // Obtén los ciclos que coinciden con el departamento del usuario
                            $cycles = Cycle::with(['modules' => function ($query) use($modulesNames) {
                                $query->where('name', $modulesNames);
                            }])->orderBy('department_id')
                                ->get();

                            // Crea un array para almacenar los módulos ordenados por ciclo y módulo
                            $allCyclesWithModules = [];

                            foreach ($cycles as $cycle) {
                                $cycleData = [
                                    'id' => $cycle->id,
                                    'name' => $cycle->name,
                                    'department_id' => $cycle->department_id,
                                    'modules' => $cycle->modules,
                                ];
                                $allCyclesWithModules[] = $cycleData;
                            }
                            
                            $userModuleIds = $user->modules->pluck('id')->toArray();

                            // Filtra los módulos del array $allCyclesWithModules para quitar los módulos en los que está inscrito el usuario
                            foreach ($allCyclesWithModules as &$cycleData) {
                                $cycleData['modules'] = $cycleData['modules']->reject(function ($module) use ($userModuleIds) {
                                    return in_array($module->id, $userModuleIds);
                                });
                            }

                            break;
                        case $departmentEIE['name']:
                            ////////////////////////////////// EIE //////////////////////////////////////////////////////////
                            $modulesNames = $departmentEIE['modules'];
                            // Obtén los ciclos que coinciden con el departamento del usuario
                            $cycles = Cycle::with(['modules' => function ($query) use ($departmentEIE) {
                                $query->where('name', $departmentEIE);
                            }])->orderBy('department_id')
                                ->get();

                            // Crea un array para almacenar los módulos ordenados por ciclo y módulo
                            $allCyclesWithModules = [];

                            foreach ($cycles as $cycle) {
                                $cycleData = [
                                    'id' => $cycle->id,
                                    'name' => $cycle->name,
                                    'department_id' => $cycle->department_id,
                                    'modules' => $cycle->modules,
                                ];
                                $allCyclesWithModules[] = $cycleData;
                            }
                            
                            $userModuleIds = $user->modules->pluck('id')->toArray();

                            // Filtra los módulos del array $allCyclesWithModules para quitar los módulos en los que está inscrito el usuario
                            foreach ($allCyclesWithModules as &$cycleData) {
                                $cycleData['modules'] = $cycleData['modules']->reject(function ($module) use ($userModuleIds) {
                                    return in_array($module->id, $userModuleIds);
                                });
                            }
                            break;
                        case $departmentLanguages['name']:
                            ////////////////////////////////// IDIOMAS //////////////////////////////////////////////////////////
                            $moduleNames = $departmentLanguages['modules']; 

                            // Obtén los ciclos que coinciden con el departamento del usuario y los módulos con los nombres en el array
                            $cycles = Cycle::with(['modules' => function ($query) use ($moduleNames) {
                                $query->whereIn('name', $moduleNames);
                            }])->orderBy('department_id')
                                ->get();

                            $allCyclesWithModules = [];

                            foreach ($cycles as $cycle) {
                                $cycleData = [
                                    'id' => $cycle->id,
                                    'name' => $cycle->name,
                                    'department_id' => $cycle->department_id,
                                    'modules' => $cycle->modules,
                                ];
                                $allCyclesWithModules[] = $cycleData;
                            }
                            
                            $userModuleIds = $user->modules->pluck('id')->toArray();

                            // Filtra los módulos del array $allCyclesWithModules para quitar los módulos en los que está inscrito el usuario
                            foreach ($allCyclesWithModules as &$cycleData) {
                                $cycleData['modules'] = $cycleData['modules']->reject(function ($module) use ($userModuleIds) {
                                    return in_array($module->id, $userModuleIds);
                                });
                            }
                                break;
                        default:
                        ////////////////////////////////// DEFAULT //////////////////////////////////////////////////////////
                            // Obtén los IDs de los módulos del usuario
                            $userModuleIds = $user->modules->pluck('id')->toArray();

                            // Obtén todos los ciclos con sus módulos, restringiendo por departamento
                            $allCyclesWithModules = Cycle::with('modules')
                                ->whereHas('department', function ($query) use ($user) {
                                    $query->where('id', $user->department_id);
                                })
                                ->orderBy('department_id')
                                ->get();

                            // Filtra los módulos de cada ciclo para quitar los módulos del usuario
                            $allCyclesWithModules->each(function ($cycle) use ($userModuleIds) {
                                $cycle->modules = $cycle->modules->reject(function ($module) use ($userModuleIds) {
                                    return in_array($module->id, $userModuleIds);
                                });
                            });
                            break;
                    }

                    return view('admin.users.show', ['user' => $user,'cyclesWithModules' => $cyclesWithModules,'allCyclesWithModules'=>$allCyclesWithModules])->with('imagePath','images/'.$fileName);
                    break;
                default:
                    return view('admin.users.show', ['user' => $user])->with('imagePath','images/'.$fileName);
                    break;
            }
        } else {
            if(Auth::user()->id == $user->id) {
                return redirect()->route('home.index');
            } else {
                // Lógica para obtener la información de los usuarios según sus identificadores ($user1 y $user2)
                $user = User::where('id',$user->id)->first();
                // Retornar la vista con los datos de los usuarios
                return view('users.show', ['user' => $user]);
            }
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,User $user)
    {
        if ($this->ControllerFunctions->checkAdminRoute() && $this->ControllerFunctions->checkAdminRole()) {
            //si es admin
            $departments = Department::select('id','name')->orderBy("name")->get();
            $roles = Role::all();
            $cycles_modules = Cycle::with('modules')->get();
            return view('admin.users.edit_create', ['user'=>$user, 'roles'=> $roles, 'cycles_modules'=>$cycles_modules,'departments' => $departments]);
        }else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if ($this->ControllerFunctions->checkAdminRole() && $this->ControllerFunctions->checkAdminRoute()) {
            $user->name = $request->name;
            $user->save();

            $this->enrollStudentInCycle($user->id,$request->newCycle,$request->year,$request->is_dual);

            return redirect()->route('admin.users.show',['user'=>$user]);
            //return view('cycles.show',['user'=>$user]);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function addCycle(Request $request, User $user)
    {
        if ($this->ControllerFunctions->checkAdminRole() && $this->ControllerFunctions->checkAdminRoute()) {

            $messages = [
                'newCycle.regex' => __('errorMessageCyclesEmpty'),
                'year.in' => __('errorMessageYearEmpty'),
            ];

            $request->validate([
                'newCycle' => ['regex:/^\d+$/u'],
                'year' => ['in:1,2']
            ],$messages);

            if(!in_array($request->newCycle,$user->cycles->pluck('id')->toArray())){
                $this->enrollStudentInCycle($user->id,$request->newCycle,$request->year,$request->is_dual);
            } else {
                return redirect()->back()->withErrors('error','Already in that cycle');
            }
            return redirect()->route('admin.users.show',['user'=>$user]);
        }
        
    }

     /**
     * Update the specified resource in storage.
     */
    public function addModule(Request $request, User $user)
    {
        if ($this->ControllerFunctions->checkAdminRole() && $this->ControllerFunctions->checkAdminRoute()) {

            $modulesArray = explode("/",$request->newModule);
            $cycleId = $modulesArray[0];
            $moduleId = $modulesArray[1];
            $exists = DB::table('module_user_cycle')->where('user_id', $user->id)
            ->where('module_id',$moduleId)
            ->where('cycle_id',$cycleId)
            ->exists();

            if (!$exists) {
                $this->enrollTeacherInModule($user->id,$moduleId,$cycleId);

                return redirect()->route('admin.users.show',['user'=>$user]);
            } else {
                return redirect()->back()->withErrors('error',__('errorAlreadyInModule'));
            }
            
        } else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }
        
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,$userId)
    {
        
        if ($this->ControllerFunctions->checkAdminRoute() && $this->ControllerFunctions->checkAdminRole()) {
            $user = User::find($userId);
            if($user->id != 0){
                if ($user) {
                    $user->delete();
                    return redirect()->route('admin.users.index');
                } else {
                    return redirect()->back()->withErrors('error', __('errorDelete'));
                }
            } else {
                return redirect()->back()->withErrors('error', __('errorAdminCantBeDeleted'));
            }
            
        }else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }
    }

    public function enrollStudentInCycle($userId, $cycleId,$year,$dual)
    {
        if($this->ControllerFunctions->checkAdminRoute() && $this->ControllerFunctions->checkAdminRole()) {
            $user = User::findOrFail($userId);
            $cycle = Cycle::findOrFail($cycleId);
            if ($user->hasRole('ALUMNO')) {
                // Asociar al estudiante con el ciclo
                $lastRegistration = DB::table('cycle_users')->orderByDesc('cycle_registration_number')->first();
                $sync_data = array(['cycle_id'=>$cycle->id,'cycle_registration_number' => $lastRegistration->cycle_registration_number+1,'year'=>$year,'is_dual'=>$dual]);
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
        } else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }
        
    }

    public function enrollTeacherInModule($userId, $moduleId,$cycleId)
    {
        if($this->ControllerFunctions->checkAdminRoute() && $this->ControllerFunctions->checkAdminRole()) {
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
        } else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }
        
    }

    public function editRoles(Request $request, User  $user) {

        if($this->ControllerFunctions->checkAdminRoute() && $this->ControllerFunctions->checkAdminRole()) {
            $roleList = $request->input('selectedRoles');
            $rolesArray = explode(',', $roleList);

            // Busca los roles en la base de datos con los IDs proporcionados
            $roles = Role::whereIn('id', $rolesArray)->get();
            $user->roles = $roles;
            $roles = Role::all();
            $cycles_modules = Cycle::with('modules')->get();
            return view('admin.users.edit_create', ['user'=>$user, 'roles'=> $roles, 'cycles_modules'=>$cycles_modules]);
        } else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }
        
    }

    public function editCycles(Request $request, User $user) {

        if($this->ControllerFunctions->checkAdminRoute() && $this->ControllerFunctions->checkAdminRole()) {
            $cycleList = $request->input('selectedCycles');
            $cyclesArray = explode(',', $cycleList);
            
            $cycles = Cycle::whereIn('id', $cyclesArray)
            ->with('modules')
            ->get();
            $user->cycles = $cycles;
            $roles = Role::all();
            $cycles_modules = Cycle::with('modules')->get();

            return view('admin.users.edit_create', ['user'=>$user, 'roles'=> $roles, 'cycles_modules'=>$cycles_modules]);
        } else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }
        
    }

    public function destroyUserCycle(Request $request, $cycleId, $userId){
        if ($this->ControllerFunctions->checkAdminRoute() && $this->ControllerFunctions->checkAdminRole()) {
            $user = User::find($userId);
            if ($user) {
                
                $modules = DB::table('module_user_cycle')->where('user_id', $user->id)
                ->where('cycle_id',$cycleId)->get();

                foreach($modules as $module) {
                    $user->modules()->detach($module->module_id);
                }

                $user->cycles()->detach($cycleId);

                return redirect()->route('admin.users.show',['user'=>$user]);
            } else {
                return redirect()->back()->withErrors('error',__('errorDelete'));
            }

        }else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }
    }

    public function destroyUserModule(Request $request, $moduleId, $userId){
        if ($this->ControllerFunctions->checkAdminRoute() && $this->ControllerFunctions->checkAdminRole()) {
            $user = User::find($userId);
            if ($user) {
                $user->modules()->detach($moduleId);
                
                return redirect()->route('admin.users.show',['user'=>$user])->with('success',__('successDelete'));
            } else {
                return redirect()->back()->withErrors('error',__('errorDelete'));
            }

        }else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }
    }
}
