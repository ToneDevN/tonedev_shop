<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('categories', 'coverImage')->latest()->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function show(Product $product)
    {
        $product->load('categories', 'product_images');
        return view('admin.products.show', compact('product'));
    }

    public function toggleActive(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);
        return back()->with('success', 'อัปเดตสถานะสินค้าเรียบร้อย');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'ลบสินค้าเรียบร้อย');
    }
}
