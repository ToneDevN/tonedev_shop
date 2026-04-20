<?php

declare(strict_types=1);

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\UpdateOrderStatusRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::with('items.product')->latest()->paginate(15);

        return view('owner.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load('items.product', 'payment');

        return view('owner.orders.show', compact('order'));
    }

    public function updateStatus(UpdateOrderStatusRequest $request, Order $order): RedirectResponse
    {
        $order->update(['status' => $request->validated('status')]);

        return back()->with('success', 'อัปเดตสถานะเรียบร้อยแล้ว');
    }
}
