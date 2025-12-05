<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->get();
        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'total_amount' => 'required|numeric|min:0.01',
            'status' => 'in:pending,processing,shipped,completed,cancelled',
            'shipping_address' => 'required|string|max:255',
        ]);

        $order = Order::create($request->all());
        return response()->json($order->load('user'), 201);
    }

    public function show(Order $order)
    {
        return response()->json($order->load('user'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'total_amount' => 'numeric|min:0.01',
            'status' => 'in:pending,processing,shipped,completed,cancelled',
            'shipping_address' => 'string|max:255',
        ]);

        $order->update($request->except('user_id'));
        return response()->json($order->load('user'));
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(null, 204);
    }
}
