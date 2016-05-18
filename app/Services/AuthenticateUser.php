<?php

namespace App\Services;

use App\OAuthAuthorisations;
use App\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class AuthenticateUser
{
    public function __construct()
    {
        //
    }

    public function requestToken($oauth_provider) {
        return Socialite::with($oauth_provider)->redirect();
    }

    public function facebookLogin(Request $request) {
        if(!$request->has('code')) {
            return $this->requestToken('facebook');
        }

        return $this->loginOrCreateUser('facebook', Socialite::driver('facebook')->user());
    }

    public function googleLogin(Request $request) {
        if(!$request->has('code')) {
            return $this->requestToken('google');
        }

        return $this->loginOrCreateUser('google', Socialite::driver('google')->user());
    }

    public function loginOrCreateUser($oauth_provider, $oauth_user) {

        $oauth_authorisation = OAuthAuthorisations::where('network', '=', $oauth_provider)
                               ->where('network_user_id', '=', (int) $oauth_user->id)
                               ->first();

        if($oauth_authorisation === null) {
            $user = User::where('email', '=', $oauth_user->email)->first();

            if($user === null) {
                //Create user
                $user = $this->createUser($oauth_user->name, $oauth_user->email);
            }

            OAuthAuthorisations::create([
                'network' => $oauth_provider,
                'network_user_id' => $oauth_user->id,
                'user_id' => $user->id
            ]);

            auth()->loginUsingId($user->id, true);
        } else {
            auth()->loginUsingId($oauth_authorisation->user_id, true);
        }

        return redirect()->intended(localize_url('routes.shop.index'))->with('success', trans('auth.login.success'));
    }

    public function createUser($name, $email) {
        $user = User::create([
            'name' => $name,
            'email' => $email
        ]);

        return $user;
    }
}

