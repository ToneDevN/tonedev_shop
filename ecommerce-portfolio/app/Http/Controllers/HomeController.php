<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // ดึงสินค้าที่ Active ล่าสุด 12 ชิ้น
        // with('coverImage') คือการ Eager Loading เพื่อลด Query (สำคัญมากสำหรับ Portfolio)
        $products = Product::where('is_active', true)
                           ->with('coverImage', 'categories') 
                           ->latest()
                           ->paginate(12);

        return view('home', compact('products'));
    }
}