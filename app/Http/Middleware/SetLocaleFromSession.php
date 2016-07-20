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
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        $locale = session('locale');

        if(!is_null($locale)) {
            \Localization::setLocale($locale);
        }

        \Carbon::setLocale(\Localization::getCurrentLocale());

        switch (\Localization::getCurrentLocale()) {
            case 'it':
                $success = setlocale(LC_TIME, 'it_IT.utf8');
                break;
            case 'en':
                $success = setlocale(LC_TIME, 'en_GB.utf8');
                break;
            default:
                throw new \Exception("Locale not found");
        }

        if(!$success) throw new \Exception("Failed setting locale: " . \Localization::getCurrentLocale() . " | Current Locale: " . setlocale(LC_ALL, 0));

        return $next($request);
    }
}
