<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\CurrencyFormatter;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::where('is_active', true)
            ->with([
                'coverImage:id,product_id,image_path,is_primary',
                'categories:id,name',
            ]);

        if ($search = $request->input('search')) {
            $query->where('name', 'ILIKE', "%{$search}%");
        }

        if ($categoryId = $request->input('category')) {
            $query->whereHas('categories', function($q) use ($categoryId) {
                $q->where('categories.id', (int) $categoryId);
            });
        }

        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereBetween('price', [
                CurrencyFormatter::toSatang($request->min_price),
                CurrencyFormatter::toSatang($request->max_price)
            ]);
        }

        $products = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->take(16)->get();

        return view('home', compact('products', 'categories', 'search'));
    }
}
