<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;

class CartService
{
    /**
     * Return the current cart from session (prices stored in satang).
     *
     * @return array<int|string, array{name: string, quantity: int, price: int, image: string}>
     */
    public function get(): array
    {
        return session()->get('cart', []);
    }

    /**
     * Total in satang.
     */
    public function total(): int
    {
        return (int) array_sum(array_map(
            fn (array $item): int => $item['price'] * $item['quantity'],
            $this->get()
        ));
    }

    /**
     * Add or increment a product in the cart.
     * Quantity input comes from the form (default 1).
     */
    public function add(Product $product, int $quantity = 1): void
    {
        $cart = $this->get();
        $id = $product->id;

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'quantity' => $quantity,
                'price' => $product->price, // satang
                'image' => $product->coverImage?->image_path ?? '',
            ];
        }

        session()->put('cart', $cart);
    }

    /**
     * Remove a product from the cart by its ID.
     */
    public function remove(int|string $productId): void
    {
        $cart = $this->get();
        unset($cart[$productId]);
        session()->put('cart', $cart);
    }

    /**
     * Destroy the entire cart (called after successful checkout).
     */
    public function clear(): void
    {
        session()->forget('cart');
    }

    /**
     * Return true when the cart has at least one item.
     */
    public function isNotEmpty(): bool
    {
        return ! empty($this->get());
    }
}
