<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        setLanguageSession($request->route('language'));

        return back();
    }
}
