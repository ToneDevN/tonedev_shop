<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'categories' => 'required|array', // ต้องเลือกอย่างน้อย 1 หมวด
            'content_blocks' => 'nullable|array',
            'image' => 'required|image|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // 1. สร้าง Product
            $product = Product::create([
                'name' => $request->name,
                'slug' => \Str::slug($request->name . '-' . time()),
                'price' => $request->price,
                'description' => $request->description,
                'content_blocks' => $request->content_blocks, // บันทึกเป็น JSONB อัตโนมัติ (เพราะเราทำ Casts ไว้แล้ว)
                'stock_quantity' => $request->stock_quantity ?? 0,
                'is_active' => true,
            ]);

            // 2. ผูกหมวดหมู่ (Relationship)
            $product->categories()->attach($request->categories);

            // 3. บันทึกรูปภาพ
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('products', 'public');
                $product->product_images()->create([
                    'image_path' => '/storage/' . $path,
                    'is_primary' => true,
                ]);
            }

            DB::commit();
            return redirect()->route('home')->with('success', 'สร้างสินค้าพร้อมรายละเอียดครบถ้วน!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $categories = Category::all(); // ดึงหมวดหมู่ทั้งหมด
        return view('owner.products.create', compact('categories'));
    }
}
