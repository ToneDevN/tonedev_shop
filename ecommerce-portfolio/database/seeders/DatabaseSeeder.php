<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. สร้าง Admin / Owner / Member
        $this->call(PermissionSeeder::class); // ถ้ามี

        $admin = User::create([
            'username' => 'admin',
            'first_name' => 'Admin',
            'last_name' => 'System',
            'email' => 'admin@tonedev.shop',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // 3. สร้างหมวดหมู่และสินค้า
        $this->call(ProductCategorySeeder::class);
        
        // ฟอลแบคหากไม่มี ProductCategorySeeder
        if (Category::count() === 0) {
            $categories = ['Electronics', 'Clothing', 'Books', 'Home & Garden'];
            foreach ($categories as $cat) {
                Category::create(['name' => $cat, 'slug' => \Str::slug($cat)]);
            }
        }

        if (Product::count() === 0) {
            $cats = Category::all();
            Product::factory(10)->create()->each(function ($product) use ($cats) {
                $product->categories()->attach($cats->random(rand(1, 2))->pluck('id'));
                for ($i = 0; $i < 3; $i++) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => 'https://picsum.photos/400/300?random='.rand(1, 1000),
                        'is_primary' => $i === 0,
                        'sort_order' => $i,
                    ]);
                }
            });
        }
    }
}
