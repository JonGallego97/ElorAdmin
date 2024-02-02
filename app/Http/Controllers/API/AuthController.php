<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/*
* @OA\Info(title="API", version="1.0")
* ),
*/


class AuthController extends Controller
{
    /*
    * @OA\Get(
    *   path="/api/forgotPassword/{email}",
    *   summary="Reset Password",
    *   @OA\Parameter(
    *       name="email",
    *       description="Email",
    *       required=true,
    *       in="path",
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\Response(
    *       response=200,
    *       description="Shows role."
    *   ),
    *   @OA\Response(
    *       response="default",
    *       description="Ha ocurrido un error."
    *   )
    * )
    */
    public function resetPassword(String $email)
    {
        dd($request);
        $messages = [
            'name.required' => __('errorMessageNameEmpty'),
            'name.email' => __('errorMessageNameLettersOnly'),
        ];

        $request->validate([
            'name' =>['required','email']
        ],$messages);
        return redirect()->route('password.email',['$request'=>$request]);
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
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
