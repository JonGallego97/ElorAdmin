<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class DepartmentController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($this->checkAdminRoute()) {
            $perPage = $request->input('per_page', App::make('paginationCount'));
            $departments = Department::orderBy('name', 'asc')->paginate($perPage);
            foreach ($departments as $department) {
                $department->count_people = DB::table('users')->where('department_id', $department->id)->count();
            }
            $departments->totalDepartments = Department::count();
            return view('admin.departments.index', compact('departments'));
        }else {
            $departments = Department::orderBy('name', 'asc')->get();
            return view('departments.index', ['departments' => $departments]);
        }
        
    }

    public function create(Request $request)
    {
        if($this->checkAdminRole() && $this->checkAdminRoute()){
            return view('admin.departments.edit_create');
        }else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }
        
    }

    public function indexPerson()
    {
        $departments = Department::withCount('users')->orderBy('users_count')->get();

        return view('departments.index', ['departments' => $departments]) ;

    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($this->checkAdminRole() && $this->checkAdminRoute()){
            $messages = [
                'name.required' => __('errorMessageNameEmpty'),
                'name.regex' => __('errorMessageNameLettersOnly'),
                'name.unique' => __('errorNameUnique')
            ];
    
            $request->validate([
                'name' => ['required','unique:departments', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s]+$/u'],
            ], $messages);

            $department = new Department();
            $department->name = ucwords(strtolower($request->name));
            $created = $department->save();

            if ($created) {
                return redirect()->route('admin.departments.show',['department'=>$department])->with('success',__('successCreate'));
            } else {
                return redirect()->back()->withErrors('error',__('errorCreate'));
            }
        }else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Department $department)
    {
        if($this->checkAdminRoute()){
            $perPage = $request->input('per_page', App::make('paginationCount'));
            $department->users = User::where('department_id', $department->id)->paginate($perPage);

            return view('admin.departments.show', ['department' => $department]);
        } else {

        }
        
    }

    public function edit(Request $request,Department $department)
    {
        if($this->checkAdminRole() && $this->checkAdminRoute()){
            return view('admin.departments.edit_create',['department' => $department]);
        } else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }
        
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        if($this->checkAdminRole() && $this->checkAdminRoute()){
            
            $messages = [
                'name.required' => __('errorMessageNameEmpty'),
                'name.regex' => __('errorMessageNameLettersOnly'),
                'name.unique' => __('errorNameUnique')
            ];
    
            $request->validate([
                'name' => ['required','unique:departments', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s]+$/u'],
            ], $messages);
    
            $department->name = ucwords(strtolower($request->name));
            $result = $department->save();
            if($result) {
                return redirect()->route('admin.departments.show',['department'=>$department])->with('success',__('successUpdate'));
            } else {
                return redirect()->back()->withErrors('error', __('errorUpdate'));
            }
        } else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($departmentId)
    {

        if ($this->checkAdminRole() && $this->checkAdminRoute()) {
            //si es admin
            $department = Department::with('users')->find($departmentId);
            $departmentCount = $department->users()->count();
            if ($department) {
                if($departmentCount == 0) {
                    $department->delete();
                    return redirect()->route('admin.departments.index')->with('success',__('successDelete'));
                } else {
                    return redirect()->back()->withErrors('error', __('errorDepartmentIsNotEmpty'));
                }
                
            } else {
                return redirect()->back()->withErrors('error', __('errorDelete'));
            }
        }else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }
    }

    public function destroyDepartmentUser(Request $request, $departmentId, $userId){
        if ($this->checkAdminRole() && $this->checkAdminRoute()) {
            $user = User::find($userId);
            if ($user) {
                $user->department_id = null;
                $user->save();
                $department = Department::find($departmentId);
                $perPage = $request->input('per_page', App::make('paginationCount'));
                $department->users = User::where('department_id', $department->id)->paginate($perPage);
                return view('admin.departments.show',['department'=>$department])->with('success',__('successDelete'));
            } else {
                return redirect()->back()->withErrors('error', __('errorDelete'));
            }
        }else {
            return redirect()->back()->withErrors('error', __('errorNoAdmin'));
        }
    }
}
