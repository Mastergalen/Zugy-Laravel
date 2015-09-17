<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Zugy\Repos\Order\OrderRepository;

class OrderController extends Controller
{
    /**
     * @var OrderRepository
     */
    private $orderRepo;

    /**
     * OrderController constructor.
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepo = $orderRepository;
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $order = $this->orderRepo->find($id);

        $order->vat;

        return view('pages.order.show')->with(compact('order'));
    }

}
