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
        //Allow search crawlers
        if($this->isBot()) {
            return $next($request);
        }

        if(!isset($_COOKIE['isOver18']) || $_COOKIE['isOver18'] != "true") {
            return response()->view('pages.age-splash', [], 449);
        }

        return $next($request);
    }

    private function isBot()
    {
        if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/bot|crawl|slurp|spider/i', $_SERVER['HTTP_USER_AGENT'])) {
            return true;
        }
        else {
            return false;
        }
    }
}
