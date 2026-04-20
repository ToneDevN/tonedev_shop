<?php

declare(strict_types=1);

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\Member\UploadSlipRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = auth()->user()
            ->orders()
            ->with('payment')
            ->latest()
            ->paginate(10);

        return view('member.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        // Only the order owner may view it
        abort_unless($order->user_id === auth()->id(), 403);

        $order->load('items.product', 'payment');

        return view('member.orders.show', compact('order'));
    }

    public function uploadSlip(UploadSlipRequest $request, Order $order): RedirectResponse
    {
        abort_unless($order->user_id === auth()->id(), 403);
        abort_unless($order->payment?->isPending(), 403);

        $path = $request->file('slip')->store('slips', 'public');

        $order->payment->update([
            'slip_path' => '/storage/'.$path,
        ]);

        return back()->with('success', 'อัปโหลดสลิปการชำระเงินเรียบร้อยแล้ว');
    }
}
