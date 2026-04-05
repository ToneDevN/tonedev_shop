<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Product::where('is_active', true)
            ->select(['id', 'slug', 'name', 'description', 'price', 'is_active', 'created_at', 'updated_at'])
            ->with([
                'coverImage:id,product_id,image_path,is_primary',
                'categories:id,name',
            ]);

        if ($search) {
            $query->where('name', 'ILIKE', "%{$search}%");
        }

        $products = $query->latest()
            ->paginate(12);

        $categories = \App\Models\Category::whereDoesntHave('ancestors')->take(16)->get();

        return view('home', compact('products', 'categories', 'search'));
    }
}