<?php

namespace App\Http\Middleware;

use Closure;

class ShopClosed
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
        /*
        if($request->session()->has('error')) {
            dd($request->session()->get('error'));
        }

        $request->session()->put('error', "Sorry, we are closed for a short summer break! We will be back open on the 29th July.");
        */

        return $next($request);
    }
}
