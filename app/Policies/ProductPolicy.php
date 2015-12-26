<?php

namespace App\Policies;


use App\Product;
use App\User;

class ProductPolicy
{
    protected $writeAccessGroupIds = [1,2]; //Super Admins, Admins

    public function update(User $user, Product $product)
    {
        return in_array($user->group_id, $this->writeAccessGroupIds);
    }
}