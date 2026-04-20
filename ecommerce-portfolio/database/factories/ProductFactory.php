<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'slug' => \Str::slug($this->faker->sentence(3).'-'.rand(1, 1000)),
            'description' => $this->faker->paragraph(),
            // ส่งเป็น Array ธรรมดาไปเลย ไม่ต้องมี json_encode ครอบ
            'content_blocks' => [
                ['type' => 'text', 'data' => 'This is a generated content block.'],
                ['type' => 'heading', 'data' => 'Product Feature'],
                ['type' => 'paragraph', 'data' => $this->faker->paragraph()],
            ],
            'price' => $this->faker->numberBetween(10000, 500000), // satang: 100–5000 THB
            'stock_quantity' => $this->faker->numberBetween(0, 100),
            'is_active' => true,
        ];
    }
}
