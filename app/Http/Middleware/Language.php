<?php

namespace App\Http\Middleware;
use App\Http\Controllers\LanguageController;
use Closure;

final class Language
{
    public function handle($request, Closure $next)
    {
        setCurrentLanguage();
        return $next($request);
    }
}
