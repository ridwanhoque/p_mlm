<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Resources\OrderItemResource;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderListResource;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return OrderListResource::collection(
            Order::with('user')->latest()->paginate()
        );
    }

    public function updateStatus(Order $order, Request $request)
    {
        $order->updateStatus($request->status);

        return update_response([
            'message' => 'Status updated'
        ]);
    }

    public function show(Order $order)
    {
        $order->load('user', 'items.orderable');

        return (new OrderResource(
            $order
        ))->additional([
            'items' => OrderItemResource::collection($order->items)
        ]);
    }
}
