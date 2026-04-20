<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(private readonly CartService $cart) {}

    public function index(): View
    {
        return view('cart.index', [
            'cart' => $this->cart->get(),
            'total' => $this->cart->total(),
        ]);
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        $quantity = max(1, (int) $request->input('quantity', 1));
        $this->cart->add($product, $quantity);

        return redirect()->back()->with('success', 'เพิ่มสินค้าลงตะกร้าเรียบร้อย!');
    }

    public function remove(int|string $id): RedirectResponse
    {
        $this->cart->remove($id);

        return redirect()->back()->with('success', 'ลบสินค้าเรียบร้อย');
    }
}
