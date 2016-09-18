<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
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
        $reopeningTime = Carbon::create(2016, 9, 20, 4, 0, 0); //4 am Tuesday

        if(Carbon::now() < $reopeningTime) {
            $request->session()->put('error', "Sorry, we are closed for a short summer break! We will be back open on the 8th August.");
        }

        return $next($request);
    }
}
