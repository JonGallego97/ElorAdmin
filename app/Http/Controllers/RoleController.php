<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{

    private $ControllerFunctions;

    function __construct() {
        $this->ControllerFunctions = new ControllerFunctions;
    }
    //$this->ControllerFunctions->checkAdminRoute()
    //$this->ControllerFunctions->checkAdminRole()
    //$this->ControllerFunctions->checkAdminRole() && $this->ControllerFunctions->checkAdminRoute()

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($this->ControllerFunctions->checkAdminRoute()) {
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
    public function create(Request $request)
    {
        if($this->ControllerFunctions->checkAdminRole() && $this->ControllerFunctions->checkAdminRoute()){
            $role = new Role();
            return view('admin.roles.create', ['role' => $role]);
        } else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($this->ControllerFunctions->checkAdminRole() && $this->ControllerFunctions->checkAdminRoute()){
            
            $messages = [
                'name.required' => __('errorMessageNameEmpty'),
                'name.unique' => __('errorMessageCreateRole'),
                'name.regex' => __('errorMessageNameLettersOnly'),
                'id.not_in' => __('errorMessageRoleCanNotBeUpdated'),
            ];
            $request->validate([
                'name' => 'required|unique:roles|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s]+$/u',
            ], $messages);
    
            $role = new Role();
            $role->name = strtoupper($request->name);
            $result = $role->save();
            if($result) {
                /* $role->users = $this->getRoleUsers($request, $role);
                return view('admin.roles.show', ['role' => $role]); */
                return redirect()->route('admin.roles.show',['role'=>$role])->with('success',__('successCreate'));
            } else {
                return redirect()->back()->withErrors(['error' => __('errorCreate')]);
            }
            
        } else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }

        
    }


    private function getRoleUsers(Request $request, Role $role){
        $perPage = $request->input('per_page', 10);
        return $users = User::whereHas('roles', function ($query) use ($role) {
            $query->where('id', $role->id);
        })->paginate($perPage);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Role $role)
    {
        if ($this->ControllerFunctions->checkAdminRoute()){
            $role->users = $this->getRoleUsers($request, $role);
            return view('admin.roles.show',['role'=>$role]);
        } else {
            
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,Role $role)
    {
        if($this->ControllerFunctions->checkAdminRole() && $this->ControllerFunctions->checkAdminRoute()){
            return view('admin.roles.create', ['role' => $role]);
        } else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }
        
    }

    public function destroyRoleUser(Request $request, $roleId, $userId){
        if ($this->ControllerFunctions->checkAdminRole() && $this->ControllerFunctions->checkAdminRoute()) {
            $role = Role::find($roleId);
            if ($role) {
                $role->users()->detach($userId);
                /* $role->users = $this->getRoleUsers($request, $role);
                return view('admin.roles.show',['role'=>$role]); */
                return redirect()->route('admin.roles.show',['role'=>$role])->with('success',__('successUpdate'));
            } else {
                return redirect()->back()->withErrors('error', __('errorDelete'));
            }

        }else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        if($this->ControllerFunctions->checkAdminRole() && $this->ControllerFunctions->checkAdminRoute()){
            $messages = [
                'name.required' => __('errorMessageNameEmpty'),
                'name.unique' => __('errorMessageCreateRole'),
                'name.regex' => __('errorMessageNameLettersOnly'),
                'id.not_in' => __('errorMessageRoleCanNotBeUpdated'),
            ];
            $request->validate([
                'name' => 'required|unique:roles|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s]+$/u',
            ], $messages);

            if (in_array($role->id, [1, 2, 3])) {
                return redirect()->back()->withErrors(['id' => __('errorMessageRoleCanNotBeUpdated')]);
            }
            $role->name = strtoupper($request->name);
            $updated = $role->save();

            if($updated) {
                return redirect()->route('admin.roles.show',['role'=>$role])->with('success',__('successUpdate'));
            } else {
                return redirect()->back()->withErrors('error', __('errorUpdate'));
            }
            /* $role->users = $this->getRoleUsers($request, $role);
            return view('admin.roles.show',['role'=>$role]); */
        } else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $roleId)
    {
        if ($this->ControllerFunctions->checkAdminRole() && $this->ControllerFunctions->checkAdminRoute()) {
            $role = Role::find($roleId);
            if ($role) {
                if($role->name != 'ADMINISTRADOR' && $role->name!= 'ALUMNO' && $role->name!= 'PROFESOR'){
                    $role->delete();
                    return redirect()->route('admin.roles.index')->with('success', 'Rol eliminado exitosamente.');
                }else{
                    return redirect()->back()->withErrors('error', __('errorCantDeleteRole'));
                }
            } else {
                return redirect()->back()->withErrors('error',__('errorDelete'));
            }
        }else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }
    }
}
