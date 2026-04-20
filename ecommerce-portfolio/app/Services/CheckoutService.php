<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class CheckoutService
{
    public function __construct(private readonly CartService $cart) {}

    /**
     * Create an Order, its items, and the initial Payment record in a transaction.
     * Returns the created Order on success.
     *
     * @param  array{customer_name: string, phone: string, address: string}  $data
     */
    public function placeOrder(array $data): Order
    {
        $cartItems = $this->cart->get();

        if (empty($cartItems)) {
            throw new \RuntimeException(__('cart.empty'));
        }

        return DB::transaction(function () use ($data, $cartItems): Order {
            $order = Order::create([
                'user_id' => auth()->id(),
                'customer_name' => $data['customer_name'],
                'phone' => $data['phone'],
                'shipping_address' => $data['address'],
                'total_amount' => $this->cart->total(), // satang
                'status' => 'pending',
            ]);

            foreach ($cartItems as $productId => $details) {
                $order->items()->create([
                    'product_id' => $productId,
                    'quantity' => $details['quantity'],
                    'price' => $details['price'], // satang snapshot
                ]);
            }

            $order->payment()->create([
                'payment_method' => 'transfer',
                'amount' => $order->total_amount,
                'status' => 'pending',
            ]);

            $this->cart->clear();

            return $order;
        });
    }
}
