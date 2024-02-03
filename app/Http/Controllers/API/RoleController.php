<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class RoleController extends Controller
{
    /**
    * @OA\Get(
    *   path="/api/roles",
    *   tags={"Roles"},
    *   summary="Shows roles",
    *   @OA\Response(
    *       response=200,
    *       description="Shows all roles."
    * ),
    * @OA\Response(
    *   response="default",
    *   description="Error has ocurred."
    *   ),
    *   security={
    *       {"bearerAuth": {}}
    *   }
    *)
    */
    public function index()
    {
        $roles = Role::orderBy('id')->get();
        if(!is_null($roles)) {
            return response()->json(['roles'=>$roles])->setStatusCode(Response::HTTP_OK);
        } else {
            return response()->json(['roles'=>$roles])->setStatusCode(Response::HTTP_NO_CONTENT);
        }
    }

    /**
    * @OA\Post(
    *   path="/api/roles",
    *   summary="Create a role",
    *   tags={"Roles"},
    *   @OA\Parameter(
    *       name="name",
    *       in="query",
    *       description="Role Name",
    *       required=true,
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\Response(
    *       response=200,
    *       description="successful operation",
    *       @OA\JsonContent(
    *           type="string"
    *       ),
    *   ),
    *   @OA\Response(
    *       response=401,
    *       description="Unauthenticated"
    *   ),
    *   security={
    *       {"bearerAuth": {}}
    *   }
    * )
    */
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

    /**
    * @OA\Get(
    *   path="/api/roles/{id}",
    *   summary="Shows one role",
    *   tags={"Roles"},
    *   @OA\Parameter(
    *       name="id",
    *       description="Role ID",
    *       required=true,
    *       in="path",
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\Response(
    *       response=200,
    *       description="Shows a role."
    *   ),
    *   @OA\Response(
    *       response="default",
    *       description="Ha ocurrido un error."
    *   ),
    *   security={
    *       {"bearerAuth": {}}
    *   }
    * )
    */
    public function show(Role $role)
    {
        if (!empty($role)) {
            return response()->json(['role'=>$role])->setStatusCode(Response::HTTP_OK);
        } else {
            return response()->setStatusCode(Response::HTTP_NO_CONTENT);
        }
    }

    /**
    * @OA\Put(
    *   path="/api/roles/{id}",
    *   summary="Edit a role",
    *   tags={"Roles"},
    *   @OA\Parameter(
    *       name="id",
    *       description="Role ID",
    *       required=true,
    *       in="path",
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="name",
    *       in="query",
    *       description="Name of the Role",
    *       required=true,
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\Response(
    *       response=200,
    *       description="Role actualizado."
    *   ),
    *   @OA\Response(
    *       response="default",
    *       description="Ha ocurrido un error."
    *   ),
    *   security={
    *       {"bearerAuth": {}}
    *   }
    * )
    */
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

    /**
    * @OA\Delete(
    *   path="/api/roles/{id}",
    *   summary="Delete roles",
    *   tags={"Roles"},
    *   @OA\Parameter(
    *       name="id",
    *       description="Role ID",
    *       required=true,
    *       in="path",
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\Response(
    *       response=200,
    *       description="Role deleted."
    *   ),
    *   @OA\Response(
    *       response="default",
    *       description="Ha ocurrido un error."
    *   ),
    *   security={
    *       {"bearerAuth": {}}
    *   }
    * )
    */

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
