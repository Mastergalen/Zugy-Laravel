<?php

namespace App\Policies;

use App\Address;
use App\User;

class AddressPolicy
{
    public function update(User $user, Address $address)
    {
        return $user->id === $address->user_id;
    }
}