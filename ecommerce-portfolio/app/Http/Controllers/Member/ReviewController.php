<?php

declare(strict_types=1);

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'max:2000'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        // Prevent duplicate review
        $exists = Review::where('user_id', auth()->id())
            ->where('product_id', $validated['product_id'])
            ->whereNull('parent_id')
            ->exists();

        if ($exists) {
            return back()->with('error', 'คุณเคยรีวิวสินค้านี้แล้ว');
        }

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = '/storage/'.$request->file('photo')->store('reviews', 'public');
        }

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $validated['product_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'photo_path' => $photoPath,
        ]);

        $product = Product::find($validated['product_id']);

        return redirect()->route('products.show', $product)
            ->with('success', 'รีวิวของคุณถูกบันทึกแล้ว');
    }
}
