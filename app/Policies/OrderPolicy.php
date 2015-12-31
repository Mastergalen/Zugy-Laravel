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
}