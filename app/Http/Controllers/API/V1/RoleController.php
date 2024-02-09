<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use OpenApi\Attributes as OA;

class RoleController extends Controller
{
    /**
    * @OA\Get(
    *   path="/api/v1/roles",
    *   tags={"Roles"},
    *   summary="Shows roles",
    *   @OA\Response(
    *       response=200,
    *       description="Shows all roles."
    * ),
    *   @OA\Response(
    *       response=204,
    *       description="No roles found."
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
        /* $roles = Role::orderBy('id')->get();
        if(!is_null($roles)) {
            return response()->json(['roles'=>$roles])->setStatusCode(Response::HTTP_OK);
        } else {
            return response()->json(['roles'=>$roles])->setStatusCode(Response::HTTP_NO_CONTENT);
        } */
        $perPage = App::make('paginationCount');
        $roles = Role::orderBy('id')->paginate($perPage);

        // Comprueba si hay usuarios disponibles
        if ($roles->isNotEmpty()) {
            // Prepara los datos de paginación para la respuesta
            $paginationData = [
                'total' => $roles->total(), // Número total de datos
                'per_page' => $roles->perPage(), // Datos por página
                'current_page' => $roles->currentPage(), // Página actual
                'last_page' => $roles->lastPage(), // Última página
                'next_page_url' => $roles->nextPageUrl(), // URL de la próxima página
                'prev_page_url' => $roles->previousPageUrl(), // URL de la página anterior
                'from' => $roles->firstItem(), // Número del primer ítem en la página
                'to' => $roles->lastItem() // Número del último ítem en la página
            ];

            // Devuelve los usuarios junto con los datos de paginación
            return response()->json([
                'roles' => $roles->items(), // O usa simplemente $users para incluir los datos de paginación automáticamente
                'pagination' => $paginationData,
            ])->setStatusCode(Response::HTTP_OK);
        } else {
            // Devuelve respuesta para indicar que no hay contenido
            return response()->json(['message' => 'No users found'])->setStatusCode(Response::HTTP_NO_CONTENT);
        }
    }

    /**
    * @OA\Post(
    *   path="/api/v1/roles",
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
    *       response=201,
    *       description="Role created",
    *       @OA\JsonContent(
    *           type="string"
    *       ),
    *   ),
    *   @OA\Response(
    *       response=400,
    *       description="Bad Request",
    *       @OA\JsonContent(
    *           type="string"
    *       ),
    *   ),
    *   @OA\Response(
    *       response=401,
    *       description="Unauthenticated"
    *   ),
    *   @OA\Response(
    *       response="default",
    *       description="Error has ocurred."
    *   ),
    *   security={
    *       {"bearerAuth": {}}
    *   }
    * )
    */
    public function store(Request $request)
    {
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
    *   path="/api/v1/roles/{id}",
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
    *       description="Request accepted.",
    *       @OA\JsonContent(
    *           type="object",
    *           @OA\Property(
    *               property="role",
    *               type="object",
    *               @OA\Property(
    *                   property="id",
    *                   type="integer"
    *               ),
    *               @OA\Property(
    *                   property="name",
    *                   type="string"
    *               ),
    *           )
    *       ),
    *   ),
    *   @OA\Response(
    *       response=204,
    *       description="That Role doesn't exist."
    *   ),
    *   @OA\Response(
    *       response=401,
    *       description="Unauthenticated"
    *   ),
    *   @OA\Response(
    *       response="default",
    *       description="Error has ocurred."
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
    *   path="/api/v1/roles/{id}",
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
    *       response=201,
    *       description="Role updated."
    *   ),
    *   @OA\Response(
    *       response=400,
    *       description="Role doesnt exist."
    *   ),
    *   @OA\Response(
    *       response=401,
    *       description="Unauthenticated"
    *   ),
    *   @OA\Response(
    *       response="default",
    *       description="Error has ocurred."
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
    *   path="/api/v1/roles/{id}",
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
    *       response=204,
    *       description="Role deleted."
    *   ),
    *   @OA\Response(
    *       response=403,
    *       description="That role can't be deleted"
    *   ),
    *   @OA\Response(
    *       response=401,
    *       description="Unauthenticated"
    *   ),
    *   @OA\Response(
    *       response="default",
    *       description="Error has ocurred."
    *   ),
    *   security={
    *       {"bearerAuth": {}}
    *   }
    * )
    */

    public function destroy(Role $role)
    {
        if($this->checkIfDeleteForbiddenRole($role)){
            $deleted = $role->delete();
            if ($deleted) {
                return response()->json(['role'=>$role])->setStatusCode(Response::HTTP_NO_CONTENT);
            } else {
                return response()->json(['role'=>$role])->setStatusCode(Response::HTTP_BAD_REQUEST);
            }
        }else {
            return response()->json(['error' => 'El rol '. $role->name . ' no se puede eliminar'], Response::HTTP_FORBIDDEN);
        }
    }
}
