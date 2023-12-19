<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
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
        $users = User::with('roles')->orderBy('id', 'desc')->get();

        if ($users->isNotEmpty()) {
            return response()->json(['users' => $users])->setStatusCode(Response::HTTP_OK);
        } else {
            return response()->json(['users' => $users])->setStatusCode(Response::HTTP_NO_CONTENT);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $user = new User();
        $user = User::with('roles')->where('id', $id)->first();
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
                'phoneNumber1' => 'required|integer',
                'phoneNumber2' =>'required|integer',
                'image' =>'required|string',
            ]);

            $user->name = $request->name;
            $user->surname1 = $request->surname1;
            $user->surname2 = $request->surname2;
            $user->address = $request->address;
            $user->phoneNumber1 = $request->phoneNumber1;
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
                if ($user->firstLogin) {
                    $userData['firstLogin'] = false;
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
}
