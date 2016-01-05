<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' =>
            'postPasswordChange'
        ]);
    }

    public function redirectPath()
    {
        return localize_url('routes.account.index');
    }

    public function getEmailSubject()
    {
        return trans('auth.reset.email.subject');
    }

    public function getReset(Request $request, $token = null)
    {
        return $this->showResetForm($request, $token);
    }

    public function postPasswordChange(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'password' => 'required|confirmed|min:6',
        ]);

        $validator->sometimes('current_password', 'required|correct_password', function($input) {
            return(auth()->user()->password !== null);
        });

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        auth()->user()->password = bcrypt($request->input('password'));
        auth()->user()->save();

        return redirect(localize_url('routes.account.settings'))->withSuccess(trans('auth.form.password.change.success'));
    }
}
