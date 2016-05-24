<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;

class AuthenticationPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Is user permitted to log into other users' accounts?
     * @param User $user
     * @param User $toBeSignedInAsUser
     * @return bool
     */
    public function signInAsUser(User $user, User $toBeSignedInAsUser) {
        return $this->isSuperAdmin($user);
    }
}
