<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class PasswordResetController extends Controller
{
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



