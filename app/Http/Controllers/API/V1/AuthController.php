<?php

namespace App\Http\Controllers\API\V1;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;

    


class AuthController extends Controller
{

    
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

    
    public function logout(Request $request){
        dd($request);
        $request->user()->currentAccessToken()->delete();
        return response()->json([
        'status' => 'success',
        'message' => 'User logged out successfully'
        ])->setStatusCode(Response::HTTP_OK);
    }
}
