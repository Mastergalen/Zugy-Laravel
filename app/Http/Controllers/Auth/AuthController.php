<?php

namespace App\Http\Controllers\Auth;

use App\Services\AuthenticateUser;
use App\User;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    public function redirectPath()
    {
        return localize_url('routes.shop.index');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function getLogin(Request $request) {
        if($request->has('intended')) {
            session()->put('url.intended', $request->input('intended'));
        }

        return view('auth.login');
    }

    /**
     * POST auth/register
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        Auth::guard($this->getGuard())->login($this->create($request->all()));

        return redirect($this->redirectPath())->withSuccess(trans('auth.register.success'));
    }

    public function facebookLogin(AuthenticateUser $authenticateUser, Request $request) {
        return $authenticateUser->facebookLogin($request);
    }

    public function googleLogin(AuthenticateUser $authenticateUser, Request $request) {
        return $authenticateUser->googleLogin($request);
    }

    public function getLogout() {
        auth()->logout();
        return redirect('/');
    }

    /**
     * Called after user has logged in successfully
     */
    public function authenticated()
    {
        return redirect()->intended($this->redirectPath())->with(['success' => trans('auth.login.success')]);
    }
}
