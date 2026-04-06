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

        // 3. สร้างหมวดหมู่และสินค้าจริง (สินค้าผู้ชาย, สตรี, เด็ก, สัตว์เลี้ยง, คอมพิวเตอร์, โทรศัพท์, บ้าน, อิเล็กทรอนิกส์)
        $this->call(ProductCategorySeeder::class);
    }
}