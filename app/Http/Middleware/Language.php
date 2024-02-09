<?php

namespace App\Http\Middleware;
use App\Http\Controllers\LanguageController;
use Illuminate\Http\Request;
use Closure;

final class Language
{
    /* public function handle(Request $request, Closure $next)
    {
        setCurrentLanguage();
        return $next($request);
    } */
    public function handle(Request $request, Closure $next)
    {
        session(['language' => 'es']);
        $language = session('language');
        
        app()->setLocale($language);

        return $next($request);
    }
}
