<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('id')->get();
        if(!is_null($roles)) {
            return response()->json(['roles'=>$roles])->setStatusCode(Response::HTTP_OK);
        } else {
            return response()->json(['roles'=>$roles])->setStatusCode(Response::HTTP_NO_CONTENT);
        }
    }

    public function store(Request $request)
    {
        $role = new Role();
        $role->name = $request['name'];

        $created = $role->save();
        if($created) {
            return response()->json(['role'=>$role])->setStatusCode(Response::HTTP_CREATED);
        } else {
            return response()->json(['role'=>$role])->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
    }

   
    public function show(Role $role)
    {
        if (!empty($role)) {
            return response()->json(['role'=>$role])->setStatusCode(Response::HTTP_OK);
        } else {
            return response()->setStatusCode(Response::HTTP_NO_CONTENT);
        }
    }

 
    public function update(Request $request, Role $role)
    {
        $role->name = $request['name'];

            $updated = $role->save();
            if($updated) {
                return response()->json(['role'=>$role])->setStatusCode(Response::HTTP_CREATED);
            } else {
                return response()->json(['role'=>$role])->setStatusCode(Response::HTTP_BAD_REQUEST);
            }
    }


    public function destroy(Role $role)
    {
        if($role->name != 'ADMINISTRADOR' && $role->name!= 'ALUMNO' && $role->name!= 'PROFESOR'){
            $deleted = $role->delete();
            if ($deleted) {
                return response()->json(['role'=>$role])->setStatusCode(Response::HTTP_NO_CONTENT);
            } else {
                return response()->json(['role'=>$role])->setStatusCode(Response::HTTP_BAD_REQUEST);
            }
        }else {
            return response()->json(['error' => 'El rol '. $role->name . ' no se puede eliminar'], Response::HTTP_BAD_REQUEST);
        }
    }
}
