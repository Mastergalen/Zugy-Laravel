<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Set the locale based on the session variable, only for API routes
 * For the Laravel Localisation package by mcamara
 * Class SetLocaleFromSession
 * @package App\Http\Middleware
 */
class SetLocaleFromSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = session('locale');

        if(!is_null($locale)) {
            \Localization::setLocale($locale);
        }

        \Carbon::setLocale(\Localization::getCurrentLocale());

        return $next($request);
    }
}
