<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // 1. หน้ากรอกข้อมูลที่อยู่
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'ตะกร้าสินค้าว่างเปล่า');
        }

        $total = array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        return view('checkout.index', compact('cart', 'total'));
    }

    // 2. บันทึกคำสั่งซื้อลง Database
    public function store(Request $request)
    {

        // dd('เข้าฟังก์ชัน store แล้ว!', $request->all());

        // 1. ตรวจสอบข้อมูลที่ส่งมาจากฟอร์ม Checkout
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        // 2. ดึงข้อมูลจากตะกร้าใน Session
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'ตะกร้าสินค้าว่างเปล่า');
        }

        // 3. คำนวณราคาทั้งหมด
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // ใช้ Database Transaction เพื่อความปลอดภัย (ถ้าบันทึกอย่างใดอย่างหนึ่งพลาด จะไม่บันทึกเลย)
        \DB::beginTransaction();

        try {
        // 1. สร้าง Order
            $order = Order::create([
                'customer_name' => $request->customer_name,
                'phone' => $request->phone,
                'shipping_address' => $request->address,
                'total_amount' => $total,
                'status' => 'pending',
                'user_id' => auth()->id(), // Add user_id if logged in, otherwise null (needs nullable in DB)
            ]);

            // 2. บันทึกรายการสินค้า (Order Items)
            foreach (session('cart') as $id => $details) {
                $order->items()->create([
                    'product_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                ]);
            }

            // 3. สร้างข้อมูลการชำระเงินเบื้องต้น (Payment Record)
            $order->payment()->create([
                'payment_method' => 'transfer',
                'amount' => $total,
                'status' => 'pending',
            ]);

            \DB::commit();
            session()->forget('cart');

            return view('checkout.success', compact('order'));

        } catch (\Exception $e) {
            \DB::rollBack();
            dd($e->getMessage()); // Debug ดูว่าติดตรงไหน
        }
    }

    public function track(Request $request)
    {
        // ตรวจสอบข้อมูลเบื้องต้น
        $request->validate([
            'order_number' => 'required|string',
            'phone' => 'required|string',
        ]);

        // ค้นหา Order
        $order = Order::where('id', strtoupper($request->order_number))
                    ->where('phone', $request->phone)
                    ->first();

        if (!$order) {
            return back()->with('error', 'ขออภัย ไม่พบเลขที่สั่งซื้อนี้ หรือข้อมูลเบอร์โทรศัพท์ไม่ถูกต้อง');
        }

        // ถ้าเจอ ให้ไปที่หน้าแสดงรายละเอียด (เราใช้หน้า success มา reuse ได้ หรือทำหน้าใหม่)
        return view('checkout.success', compact('order'));
    }
}