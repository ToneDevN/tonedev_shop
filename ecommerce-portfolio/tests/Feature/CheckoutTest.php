<?php

declare(strict_types=1);

use App\Models\Order;
use App\Models\Product;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('guest can checkout and creates order, items, and payment', function (): void {
    $product = Product::factory()->create(['price' => 50000, 'stock_quantity' => 5]);

    // Add to cart via session
    $this->post(route('cart.add', $product), ['quantity' => 2]);

    $response = $this->post(route('checkout.store'), [
        'customer_name' => 'ทดสอบ ระบบ',
        'phone' => '0812345678',
        'address' => '123 ถนนทดสอบ กรุงเทพฯ',
    ]);

    $response->assertOk();

    $order = Order::with('items', 'payment')->first();

    expect($order)->not->toBeNull()
        ->and($order->total_amount)->toBe(100000) // 50000 × 2
        ->and($order->items)->toHaveCount(1)
        ->and($order->payment->status)->toBe('pending')
        ->and($order->id)->toStartWith('ORD-');
});

it('redirects to home when cart is empty on checkout', function (): void {
    $this->get(route('checkout.index'))
        ->assertRedirect(route('home'));
});

it('validates required checkout fields', function (): void {
    $product = Product::factory()->create(['price' => 10000, 'stock_quantity' => 5]);
    $this->post(route('cart.add', $product));

    $this->post(route('checkout.store'), [])
        ->assertSessionHasErrors(['customer_name', 'phone', 'address']);
});
