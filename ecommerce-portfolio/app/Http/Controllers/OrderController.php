<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Services\CartService;
use App\Services\CheckoutService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(
        private readonly CartService $cart,
        private readonly CheckoutService $checkout,
    ) {}

    public function checkout(): View|RedirectResponse
    {
        if (! $this->cart->isNotEmpty()) {
            return redirect()->route('home')->with('error', 'ตะกร้าสินค้าว่างเปล่า');
        }

        return view('checkout.index', [
            'cart' => $this->cart->get(),
            'total' => $this->cart->total(),
        ]);
    }

    public function store(CheckoutRequest $request): View|RedirectResponse
    {
        if (! $this->cart->isNotEmpty()) {
            return redirect()->route('home')->with('error', 'ตะกร้าสินค้าว่างเปล่า');
        }

        try {
            $order = $this->checkout->placeOrder($request->validated());
        } catch (\Exception $e) {
            return back()->with('error', 'เกิดข้อผิดพลาดในการสั่งซื้อ กรุณาลองใหม่อีกครั้ง');
        }

        return view('checkout.success', compact('order'));
    }

    public function track(Request $request): View|RedirectResponse
    {
        $request->validate([
            'order_number' => ['required', 'string'],
            'phone' => ['required', 'string'],
        ]);

        $order = Order::with('items.product', 'payment')
            ->where('id', strtoupper($request->order_number))
            ->where('phone', $request->phone)
            ->first();

        if (! $order) {
            return back()->with('error', 'ขออภัย ไม่พบเลขที่สั่งซื้อนี้ หรือข้อมูลเบอร์โทรศัพท์ไม่ถูกต้อง');
        }

        return view('checkout.success', compact('order'));
    }
}
