<?php

declare(strict_types=1);

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\StoreProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\CurrencyFormatter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('owner.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $product = Product::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name.'-'.time()),
                'price' => CurrencyFormatter::toSatang($request->price),
                'description' => $request->description,
                'content_blocks' => $request->content_blocks,
                'stock_quantity' => $request->stock_quantity ?? 0,
                'is_active' => true,
            ]);

            $product->categories()->attach($request->categories);

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('products', 'public');
<<<<<<< Updated upstream
                $product->product_images()->create([
                    'image_path' => '/storage/' . $path,
=======
                $product->images()->create([
                    'image_path' => '/storage/'.$path,
>>>>>>> Stashed changes
                    'is_primary' => true,
                    'sort_order' => 0,
                ]);
            }

            DB::commit();

            return redirect()->route('owner.dashboard')->with('success', 'สร้างสินค้าเรียบร้อยแล้ว');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'เกิดข้อผิดพลาด: '.$e->getMessage());
        }
    }
}
