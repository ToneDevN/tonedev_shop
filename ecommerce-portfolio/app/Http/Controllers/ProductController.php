<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('search');

        $products = Product::where('is_active', true);

        if ($query) {
            $products->where(function($q) use ($query) {
                $q->where('name', 'ILIKE', "%{$query}%")
                  ->orWhere('description', 'ILIKE', "%{$query}%");
            });
        }

        $products = $products->with(['coverImage:id,product_id,image_path,is_primary', 'categories:id,name'])
                             ->latest()
                             ->paginate(12)
                             ->appends(['search' => $query]);

        return view('products.search', compact('products', 'query'));
    }

    public function autocomplete(Request $request)
    {
        $query = $request->input('search');

        if (!$query) {
            return response()->json([]);
        }

        $products = Product::where('is_active', true)
            ->where(function($q) use ($query) {
                $q->where('name', 'ILIKE', "%{$query}%");
            })
            ->with(['coverImage:id,product_id,image_path'])
            ->select('id', 'name', 'slug')
            ->take(20)
            ->get();

        return response()->json($products);
    }

    public function show(Product $product) // Route Model Binding
    {

        // dd($product->content_blocks);
        // โหลดข้อมูลที่เกี่ยวข้อง (รูปภาพทั้งหมด, หมวดหมู่, รีวิว+ผู้รีวิว)
        $product->load(['product_images', 'categories', 'reviews.user']);

        // ส่งข้อมูลไปยัง View
        return view('products.show', compact('product'));
    }
}  