<?php

namespace App\Policies;

use App\Order;
use App\User;

class OrderPolicy extends BasePolicy
{
    public function show(User $user, Order $order)
    {
        return $user->id === $order->user_id || $this->isAdmin($user);
    }

    public function adminUpdate(User $user, Order $order) {
        return $this->isAdmin($user);
    }
}