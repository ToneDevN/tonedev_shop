<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = []; // อนุญาตให้ใส่ข้อมูลได้ทุกช่อง (เพื่อความเร็วในการ Dev)

    protected $casts = [
        'content_blocks' => 'array', // แปลง JSON เป็น Array อัตโนมัติ
        'images' => 'array', // แปลง JSON Images ชุดใหม่เป็น Array
        'is_active' => 'boolean',
    ];

    // 1 สินค้า มีหลายหมวดหมู่ (Many-to-Many)
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    // 1 สินค้า มีหลายรูป (One-to-Many จากตาราง product_images)
    public function product_images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }
    
    // ดึงเฉพาะรูปปก
    public function coverImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    // 1 สินค้า มีหลายรีวิว
    public function reviews()
    {
        return $this->hasMany(Review::class)->whereNull('parent_id'); // ดึงเฉพาะรีวิวหลัก
    }
}