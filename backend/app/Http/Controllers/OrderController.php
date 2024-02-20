<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OrderService;


class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function getOrder($orderId)
    {
        return $this->orderService->getOrder($orderId);
    }

    public function generateOrder($cartId)
    {
        return $this->orderService->generateOrder($cartId);
    }


    public function completeOrder($orderId)
    {
        return $this->orderService->completeOrder($orderId);
    }
}
