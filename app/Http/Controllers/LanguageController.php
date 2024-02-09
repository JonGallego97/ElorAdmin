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

    public function setLanguage($language)
    {
        if (array_key_exists($language, config('languages'))) {
            session(['language' => $language]);
            app()->setLocale($language);

            // Aquí puedes realizar cualquier otra acción relacionada con el cambio de idioma, si es necesario.

            return redirect()->back(); // O redirige a otra página después de cambiar el idioma.
        } else {
            // Manejar el caso en el que el idioma no está en la configuración.
            // Puedes redirigir a una página de error o tomar otra acción.
            abort(404, 'Idioma no válido');
        }
    }
}
