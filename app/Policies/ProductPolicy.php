<?php

namespace App\Policies;

use App\Product;
use App\User;

class ProductPolicy extends BasePolicy
{
    protected $writeAccessGroupIds = [1,2]; //Super Admins, Admins

    public function create(User $user, Product $product)
    {
        return $this->hasWriteAccess($user);
    }

    public function update(User $user, Product $product)
    {
        return $this->hasWriteAccess($user);
    }
}