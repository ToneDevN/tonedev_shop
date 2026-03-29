<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)
            ->select(['id', 'slug', 'name', 'description', 'price', 'is_active', 'created_at', 'updated_at'])
            ->with([
                'coverImage:id,product_id,image_path,is_primary',
                'categories:id,name',
            ])
            ->latest()
            ->paginate(12);

        return view('home', compact('products'));
    }
}