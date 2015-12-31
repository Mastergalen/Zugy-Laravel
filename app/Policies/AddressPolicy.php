<?php

namespace App\Policies;

use App\Address;
use App\User;

class AddressPolicy extends BasePolicy
{
    public function update(User $user, Address $address)
    {
        return $user->id === $address->user_id || $this->isAdmin($user);
    }

    public function show(User $user, Address $address)
    {
        return $user->id === $address->user_id || $this->isAdmin($user);
    }
}