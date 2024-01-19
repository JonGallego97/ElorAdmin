<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cycle;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles','cycles.modules.users','chats')->orderBy('id', 'desc')->get();

        if ($users->isNotEmpty()) {
            return response()->json(['users' => $users, 'count' => $users->count()] )->setStatusCode(Response::HTTP_OK);
        } else {
            return response()->json(['users' => $users])->setStatusCode(Response::HTTP_NO_CONTENT);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $user = new User();
        $user = User::with('department','roles','cycles.modules.users', 'chats.messages','chats.users')->where('id', $id)->first();
        if (optional($user)->id!== null) {
            return response()->json(['user' => $user])
                ->setStatusCode(Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'User not found'])
                ->setStatusCode(Response::HTTP_NO_CONTENT);
        }
    }

    /**
     * Update the specified resource in storage.
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
     * Update password of the specified resource in storage.
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
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
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
