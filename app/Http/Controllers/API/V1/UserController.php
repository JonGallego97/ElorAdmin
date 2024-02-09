<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cycle;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    

    /**
    * @OA\Get(
    *   path="/api/v1/users",
    *   tags={"Users"},
    *   summary="Shows all users",
    *   @OA\Response(
    *       response=200,
    *       description="Shows all users."
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
        /* $users = User::with('roles','cycles.modules.users','chats')->orderBy('id', 'desc')->get();

        if ($users->isNotEmpty()) {
            return response()->json(['users' => $users, 'count' => $users->count()] )->setStatusCode(Response::HTTP_OK);
        } else {
            return response()->json(['users' => $users])->setStatusCode(Response::HTTP_NO_CONTENT);
        } */
        //$perPage = $request->input('per_page', App::make('paginationCount'));
        $perPage = App::make('paginationCount');
        $users = User::with('roles')
                 ->orderBy('id', 'desc')
                 ->paginate($perPage);

        // Comprueba si hay usuarios disponibles
        if ($users->isNotEmpty()) {
            // Prepara los datos de paginación para la respuesta
            $paginationData = [
                'total' => $users->total(), // Número total de datos
                'per_page' => $users->perPage(), // Datos por página
                'current_page' => $users->currentPage(), // Página actual
                'last_page' => $users->lastPage(), // Última página
                'next_page_url' => $users->nextPageUrl(), // URL de la próxima página
                'prev_page_url' => $users->previousPageUrl(), // URL de la página anterior
                'from' => $users->firstItem(), // Número del primer ítem en la página
                'to' => $users->lastItem() // Número del último ítem en la página
            ];

            // Devuelve los usuarios junto con los datos de paginación
            return response()->json([
                'users' => $users->items(), // O usa simplemente $users para incluir los datos de paginación automáticamente
                'pagination' => $paginationData,
            ])->setStatusCode(Response::HTTP_OK);
        } else {
            // Devuelve respuesta para indicar que no hay contenido
            return response()->json(['message' => 'No users found'])->setStatusCode(Response::HTTP_NO_CONTENT);
        }
    }

    /**
    * @OA\Post(
    *   path="/api/v1/users",
    *   summary="Create a user",
    *   tags={"Users"},
    *   @OA\Parameter(
    *       name="name",
    *       in="query",
    *       description="Name",
    *       required=true,
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="surname1",
    *       in="query",
    *       description="First Surname",
    *       required=true,
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="surname2",
    *       in="query",
    *       description="Second Surname",
    *       required=true,
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="address",
    *       in="query",
    *       description="Address",
    *       required=true,
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="dni",
    *       in="query",
    *       description="Documentation Number",
    *       required=true,
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="phone_number1",
    *       in="query",
    *       description="Telephone Number 1",
    *       required=true,
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="phone_number2",
    *       in="query",
    *       description="Telephone Number 2",
    *       required=true,
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="roles[]",
    *       in="query",
    *       description="Roles",
    *       required=true,
    *       @OA\Schema(
    *           type="array",
    *           @OA\Items(
    *               type="integer"
    *           )
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="department_id",
    *       in="query",
    *       description="Department ID",
    *       required=false,
    *       @OA\Schema(
    *           type="integer"
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

    }

    /**
    * @OA\Get(
    *   path="/api/v1/users/{id}",
    *   tags={"Users"},
    *   summary="Show one user",
    *   @OA\Parameter(
    *       name="id",
    *       description="Incident id",
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
    public function show(int $id)
    {
        $user = new User();
        $user = User::with('cycles')->where('id', $id)->first();
        if (optional($user)->id!== null) {
            return response()->json(['user' => $user])
                ->setStatusCode(Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'User not found'])
                ->setStatusCode(Response::HTTP_NO_CONTENT);
        }
    }

    /**
    * @OA\Put(
    *   path="/api/v1/users/{id}",
    *   tags={"Users"},
    *   summary="Edit an user",
    *   @OA\Parameter(
    *       name="id",
    *       description="User id",
    *       required=true,
    *       in="path",
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="name",
    *       in="query",
    *       description="Name",
    *       required=true,
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="surname1",
    *       in="query",
    *       description="First Surname",
    *       required=true,
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="surname2",
    *       in="query",
    *       description="Second Surname",
    *       required=true,
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="address",
    *       in="query",
    *       description="Address",
    *       required=true,
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="dni",
    *       in="query",
    *       description="Documentation Number",
    *       required=true,
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="phone_number1",
    *       in="query",
    *       description="Telephone Number 1",
    *       required=true,
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="phone_number2",
    *       in="query",
    *       description="Telephone Number 2",
    *       required=true,
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="roles[]",
    *       in="query",
    *       description="Roles",
    *       required=true,
    *       @OA\Schema(
    *           type="array",
    *           @OA\Items(
    *               type="integer"
    *           )
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="department_id",
    *       in="query",
    *       description="Department ID",
    *       required=false,
    *       @OA\Schema(
    *           type="integer"
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
    public function update(Request $request, User $user)
    {
        try {
            // Validación de datos
            $request->validate([
                'name' => 'required|string',
                'surname1' => 'required|string',
                'surname2' => 'required|string',
                'address' => 'required|string',
                'phone_number1' => 'required|integer',
                'phone_number2' =>'required|integer',
                'image' =>'required|string',
            ]);

            $user->name = $request->name;
            $user->surname1 = $request->surname1;
            $user->surname2 = $request->surname2;
            $user->address = $request->address;
            $user->phone_number2 = $request->phone_number2;
            $user->phoneNumber2 = $request->phoneNumber2;
            $user->image = $request->image;
            $user->save();

            return response()->json(['user' => $user])->setStatusCode(Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()], Response::HTTP_BAD_REQUEST);
        }
    }


    /**
    * @OA\Put(
    *   path="/api/v1/users/{user}/update-password",
    *   tags={"Users"},
    *   summary="Cambiar contraseña",
    *   @OA\Parameter(
    *       name="id",
    *       description="User id",
    *       required=true,
    *       in="path",
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="password",
    *       in="query",
    *       description="Password",
    *       required=true,
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\Response(
    *       response=201,
    *       description="Contraseña cambiada correctamente."
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
    
    public function updatePassword(Request $request, $id)
    {
        try {
            $request->validate([
                'password' => 'required|string|min:6',
            ]);

            $user = User::find($id);

            if (!$user) {
                return response()->json(['error' => 'Usuario no encontrado'], Response::HTTP_NOT_FOUND);
            }

            $userData = [];

            $newPassword = $request->input('password');

            if (!Hash::check($newPassword, $user->password)) {
                $userData['password'] = bcrypt($newPassword);
                if ($user->first_login) {
                    $userData['first_login'] = false;
                }
            } else {
                return response()->json(['error' => 'La contraseña no puede ser igual a la anterior'], Response::HTTP_BAD_REQUEST);
            }

            $user->update($userData);

            return response()->json(['user' => $user])->setStatusCode(Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
    * @OA\Delete(
    *   path="/api/v1/users/{id}",
    *   summary="Delete user",
    *   tags={"Users"},
    *   @OA\Parameter(
    *       name="id",
    *       description="User ID",
    *       required=true,
    *       in="path",
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\Response(
    *       response=200,
    *       description="User deleted."
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
    public function destroy(User $user)
    {
        if($this->checkAdminRole() && !$this->checkIfDeleteForbiddenUser($user)){
            $deleted = $user->delete();
            if ($deleted) {
                return response()->json(['user'=>$user])->setStatusCode(Response::HTTP_NO_CONTENT);
            } else {
                return response()->json(['user'=>$user])->setStatusCode(Response::HTTP_BAD_REQUEST);
            }
        }else {
            return response()->json(['error' => 'El usuario '. $user->name . ' no se puede eliminar'], Response::HTTP_BAD_REQUEST);
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




}
