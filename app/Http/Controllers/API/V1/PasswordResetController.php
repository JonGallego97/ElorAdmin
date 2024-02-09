<?php
namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class PasswordResetController extends Controller
{
    /**
    * @OA\Post(
    *   path="/api/v1/password/reset",
    *   summary="Request reset password",
    *   tags={"Auth"},
    *   @OA\Parameter(
    *       name="email",
    *       in="query",
    *       description="Email",
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

    * )
    */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        if ($response === Password::RESET_LINK_SENT) {
            return response()->json(['status' => 'success', 'message' => trans($response)]);
        } else {
            return response()->json(['status' => 'error', 'message' => trans($response)], 422);
        } 
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        if ($request->wantsJson()) {
            throw ValidationException::withMessages([
                'email' => [trans($response)],
            ]);
        }

        return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => trans($response)]);
    }

    protected function credentials(Request $request)
    {
        return $request->only('email');
    }


    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    }
    public function broker()
    {
        return Password::broker();
    }

}



