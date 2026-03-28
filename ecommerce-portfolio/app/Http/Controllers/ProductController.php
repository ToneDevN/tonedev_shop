<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product) // Route Model Binding
    {

        // dd($product->content_blocks);
        // โหลดข้อมูลที่เกี่ยวข้อง (รูปภาพทั้งหมด, หมวดหมู่, รีวิว+ผู้รีวิว)
        $product->load(['images', 'categories', 'reviews.user']);

        // ส่งข้อมูลไปยัง View
        return view('products.show', compact('product'));
    }
}  