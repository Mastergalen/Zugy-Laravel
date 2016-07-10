<?php

namespace App\Listeners;

use Carbon\Carbon;
use Illuminate\Auth\Events\Login;

class LogSuccessfulLogin
{
    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        \Log::info('User logged in', [
            'id' => auth()->user()->id,
            'ip' => $_SERVER['REMOTE_ADDR']
        ]);

        auth()->user()->last_login = Carbon::now();
        auth()->user()->last_login_ip = $_SERVER['REMOTE_ADDR'];
        auth()->user()->save();
    }
}
