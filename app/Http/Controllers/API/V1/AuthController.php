<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;

    


class AuthController extends Controller
{

    /**
    * @OA\Post(
    *   path="/api/v1/auth/login",
    *   tags={"Auth"},
    *   summary="Login",
    *   @OA\Parameter(
    *       name="email",
    *       description="email",
    *       required=true,
    *       in="query",
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="password",
    *       description="password",
    *       required=true,
    *       in="query",
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="device_name",
    *       description="device name",
    *       required=true,
    *       in="query",
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\Response(
    *       response=200,
    *       description="Shows Incident."
    *   ),
    *   @OA\Response(
    *       response="default",
    *       description="Ha ocurrido un error."
    *   )
    * )
    */
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
            ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)){
            return response()->json([
            'message' => ['Username or password incorrect'],
            ])->setStatusCode(Response::HTTP_UNAUTHORIZED);
        }

        // FIXME: queremos dejar más dispositivos?
        // $user->tokens()->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'User logged in successfully',
            'name' => $user->name,
            'token' => $user->createToken($request->device_name)
            ->plainTextToken,
            ]);
        }

   /**
    * @OA\Post(
    *   path="/api/v1/auth/logout",
    *   summary="logout",
    *   tags={"Auth"},
    *   @OA\Response(
    *       response=200,
    *       description="Deslogeado."
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
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
        'status' => 'success',
        'message' => 'User logged out successfully'
        ])->setStatusCode(Response::HTTP_OK);
    }
}
