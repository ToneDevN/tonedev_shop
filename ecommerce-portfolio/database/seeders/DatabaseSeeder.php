<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. สร้าง Admin User
        // User::factory()->create([
        //     'name' => 'Admin User',
        //     'email' => 'admin@example.com',
        //     'password' => bcrypt('password'), // รหัสผ่านคือ password
        //     'role' => 'admin', // อย่าลืมแก้ใน Migration users table ให้มี column role หรือใช้ field ที่คุณมี
        // ]);

        // // 2. สร้าง User ทั่วไป
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        //     'password' => bcrypt('password'),
        // ]);

        // 3. สร้างหมวดหมู่ (Categories)
        $categories = ['Electronics', 'Clothing', 'Books', 'Home & Garden'];
        foreach ($categories as $cat) {
            Category::create(['name' => $cat, 'slug' => \Str::slug($cat)]);
        }

        // 4. สร้างสินค้า (Products) และจับคู่หมวดหมู่
        $cats = Category::all();
        
        Product::factory(10)->create()->each(function ($product) use ($cats) {
            // สุ่มจับคู่หมวดหมู่
            $product->categories()->attach($cats->random(rand(1, 2))->pluck('id'));

            // สร้างรูปภาพจำลอง 3 รูป
            for ($i = 0; $i < 3; $i++) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'https://picsum.photos/400/300?random=' . rand(1, 1000), // รูปสุ่มจากเน็ต
                    'is_primary' => $i === 0, // รูปแรกเป็นรูปปก
                    'sort_order' => $i
                ]);
            }
        });
    }
}