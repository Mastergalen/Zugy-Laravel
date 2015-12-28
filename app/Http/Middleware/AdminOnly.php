<?php

namespace App\Http\Middleware;

use Closure;

class AdminOnly
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
        //Allow Super Admins, Admins, Drivers
        if(!in_array(auth()->user()->group_id, [1,2,3])) {
            abort(403);
        }

        return $next($request);
    }
}
