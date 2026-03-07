<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // 1. หน้าแสดงรายการในตะกร้า
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('cart.index', compact('cart', 'total'));
    }

    // 2. เพิ่มสินค้าลงตะกร้า
    public function add(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);

        // ถ้ามีสินค้าในตะกร้าอยู่แล้ว ให้บวกจำนวนเพิ่ม
        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->input('quantity', 1);
        } else {
            // ถ้ายังไม่มี ให้เพิ่มใหม่
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => $request->input('quantity', 1),
                "price" => $product->price,
                "image" => $product->coverImage->image_path ?? 'https://via.placeholder.com/150'
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'เพิ่มสินค้าลงตะกร้าเรียบร้อย!');
    }

    // 3. ลบสินค้า
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'ลบสินค้าเรียบร้อย');
    }
}