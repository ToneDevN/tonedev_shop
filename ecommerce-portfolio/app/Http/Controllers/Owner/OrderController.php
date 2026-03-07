<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // ดึงรายการสั่งซื้อล่าสุด พร้อมโหลดรายการสินค้าใน Order นั้นๆ (Eager Loading)
        $orders = Order::with('items.product')->latest()->paginate(10);
        
        return view('owner.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product');
        return view('owner.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $order->update(['status' => $request->status]);
        return back()->with('success', 'อัปเดตสถานะเรียบร้อยแล้ว');
    }
}