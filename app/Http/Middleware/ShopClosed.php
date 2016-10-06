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
        $reopeningTime = Carbon::create(2017, 9, 28, 4, 0, 0); //4 am Wednesday

        if(Carbon::now() < $reopeningTime) {
            $request->session()->put('error', "Sorry, we are closed for a short summer break! We will be back open soon!");
        }

        return $next($request);
    }
}
