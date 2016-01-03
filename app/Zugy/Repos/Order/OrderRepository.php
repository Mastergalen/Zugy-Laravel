<?php

namespace Zugy\Repos\Order;

interface OrderRepository {
    /**
     * Fetch incomplete orders
     * @return mixed
     */
    public function incomplete();
}