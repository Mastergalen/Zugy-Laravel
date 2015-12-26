<?php

namespace App\Policies;

use App\Order;
use App\User;

class OrderPolicy
{
    public function show(User $user, Order $order)
    {
        return $user->id === $order->user_id;
    }
}