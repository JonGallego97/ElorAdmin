<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;

use App\Models\Department;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

class DepartmentController extends Controller
{
    /**
    * @OA\Get(
    *   path="/api/v1/departments",
    *   tags={"Departments"},
    *   summary="Shows departments",
    *   @OA\Response(
    *       response=200,
    *       description="Shows all departments."
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
        /* $departments = Department::orderBy('name')->get();
        return response()->json(['departments' => $departments])
        ->setStatusCode(Response::HTTP_OK); */
        $perPage = App::make('paginationCount');
        $departments = Department::orderBy('name')->paginate($perPage);

        // Comprueba si hay usuarios disponibles
        if ($departments->isNotEmpty()) {
            // Prepara los datos de paginación para la respuesta
            $paginationData = [
                'total' => $departments->total(), // Número total de datos
                'per_page' => $departments->perPage(), // Datos por página
                'current_page' => $departments->currentPage(), // Página actual
                'last_page' => $departments->lastPage(), // Última página
                'next_page_url' => $departments->nextPageUrl(), // URL de la próxima página
                'prev_page_url' => $departments->previousPageUrl(), // URL de la página anterior
                'from' => $departments->firstItem(), // Número del primer ítem en la página
                'to' => $departments->lastItem() // Número del último ítem en la página
            ];

            // Devuelve los usuarios junto con los datos de paginación
            return response()->json([
                'departments' => $departments->items(), // O usa simplemente $users para incluir los datos de paginación automáticamente
                'pagination' => $paginationData,
            ])->setStatusCode(Response::HTTP_OK);
        } else {
            // Devuelve respuesta para indicar que no hay contenido
            return response()->json(['message' => 'No users found'])->setStatusCode(Response::HTTP_NO_CONTENT);
        }
    }

   
    /**
    * @OA\Post(
    *   path="/api/v1/departments",
    *   summary="Create a department",
    *   tags={"Departments"},
    *   @OA\Parameter(
    *       name="name",
    *       in="query",
    *       description="Department Name",
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
        $deparment = new Department();
        $deparment->name = $request->name;
        $created = $deparment->save();
        if ($created) {
            return response()->json(['message' => 'Departamento creado correctamente'])
            ->setStatusCode(Response::HTTP_CREATED);
        } else {
            return response()->json(['message' => 'Error al crear el departamento'])
            ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
    }

    /**
    * @OA\Get(
    *   path="/api/v1/departments/{id}",
    *   summary="Shows one department",
    *   tags={"Departments"},
    *   @OA\Parameter(
    *       name="id",
    *       description="Department ID",
    *       required=true,
    *       in="path",
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\Response(
    *       response=200,
    *       description="Shows department."
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
    public function show(Department $department)
    {
        if ($department) {
            return response()->json(['department' => $department])
            ->setStatusCode(Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'Departamento no encontrado'])
            ->setStatusCode(Response::HTTP_NOT_FOUND);
        }
    }


    /**
    * @OA\Put(
    *   path="/api/v1/departments/{id}",
    *   summary="Edit a department",
    *   tags={"Departments"},
    *   @OA\Parameter(
    *       name="id",
    *       description="Department ID",
    *       required=true,
    *       in="path",
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="name",
    *       in="query",
    *       description="Name of the Department",
    *       required=true,
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\Response(
    *       response=200,
    *       description="Mostrar el post especificado."
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
    public function update(Request $request, Department $department)
    {
        $department->name = $request->name;
        $updated = $department->save();
        if ($updated) {
            return response()->json(['message' => 'Departamento actualizado correctamente'])
            ->setStatusCode(Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'Error al actualizar el departamento'])
            ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
    }

    /**
    * @OA\Delete(
    *   path="/api/v1/departments/{id}",
    *   summary="Delete department",
    *   tags={"Departments"},
    *   @OA\Parameter(
    *       name="id",
    *       description="Department ID",
    *       required=true,
    *       in="path",
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\Response(
    *       response=200,
    *       description="Shows Incident."
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
    public function destroy(Department $department)
    {
        $deleted = $department->delete();
        if ($deleted) {
            return response()->json(['message' => 'Departamento eliminado correctamente'])
            ->setStatusCode(Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'Error al eliminar el departamento'])
            ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
    }
}
