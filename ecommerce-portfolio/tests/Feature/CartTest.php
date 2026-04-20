<?php

declare(strict_types=1);

use App\Models\Product;
use App\Services\CartService;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function (): void {
    $this->cart = app(CartService::class);
});

it('can add a product to the cart', function (): void {
    $product = Product::factory()->create(['price' => 50000, 'stock_quantity' => 10]);

    $this->cart->add($product, 2);
    $cart = $this->cart->get();

    expect($cart)->toHaveKey($product->id)
        ->and($cart[$product->id]['quantity'])->toBe(2)
        ->and($cart[$product->id]['price'])->toBe(50000);
});

it('increments quantity when adding an existing product', function (): void {
    $product = Product::factory()->create(['price' => 50000, 'stock_quantity' => 10]);

    $this->cart->add($product, 1);
    $this->cart->add($product, 2);

    expect($this->cart->get()[$product->id]['quantity'])->toBe(3);
});

it('calculates total in satang correctly', function (): void {
    $p1 = Product::factory()->create(['price' => 50000, 'stock_quantity' => 5]);
    $p2 = Product::factory()->create(['price' => 20000, 'stock_quantity' => 5]);

    $this->cart->add($p1, 2); // 100000
    $this->cart->add($p2, 1); // 20000

    expect($this->cart->total())->toBe(120000);
});

it('removes a product from the cart', function (): void {
    $product = Product::factory()->create(['price' => 30000, 'stock_quantity' => 5]);

    $this->cart->add($product, 1);
    $this->cart->remove($product->id);

    expect($this->cart->get())->not->toHaveKey($product->id);
});

it('clears the cart', function (): void {
    $product = Product::factory()->create(['price' => 30000, 'stock_quantity' => 5]);
    $this->cart->add($product, 1);
    $this->cart->clear();

    expect($this->cart->get())->toBeEmpty();
});
