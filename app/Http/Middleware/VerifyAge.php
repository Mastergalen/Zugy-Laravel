<?php

namespace App\Http\Middleware;

use Closure;

class VerifyAge
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
        if(env('APP_ENV') === "testing") {
            return $next($request);
        }

        //Allow search crawlers, AJAX requests and Google Page Speed Insights
        if(is_bot() || $request->ajax()) {
            return $next($request);
        }

        if(!isset($_COOKIE['isOver18']) || $_COOKIE['isOver18'] != "true") {
            return response()->view('pages.age-splash', [], 449);
        }

        return $next($request);
    }
}
