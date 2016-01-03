<?php

namespace Zugy\Repos\Order;

use App\Order;
use Zugy\Repos\DbRepository;

class DbOrderRepository extends DbRepository implements OrderRepository
{
    /**
     * @var Order
     */
    protected $model;

    /**
     * DbOrderRepository constructor.
     */
    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function incomplete()
    {
        return $this->model->incomplete();
    }


}