<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\CategoryLink;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Electronics' => [
                'Laptops' => [
                    'Gaming Laptops',
                    'Ultrabooks',
                ],
                'Smartphones' => [
                    'Android',
                    'iOS',
                ],
            ],
            'Clothing' => [
                'Men' => [
                    'Shirts',
                    'Pants',
                ],
                'Women' => [
                    'Dresses',
                    'Skirts',
                ],
            ],
            'Home & Garden' => []
        ];

        foreach ($categories as $key => $value) {
            if (is_array($value)) {
                $this->createCategoryNode($key, null, $value);
            } else {
                $this->createCategoryNode($value, null, []);
            }
        }
    }

    private function createCategoryNode($name, $parentId = null, $children = [])
    {
        $category = Category::create([
            'name' => $name,
            'slug' => Str::slug($name) . '-' . rand(1000, 9999)
        ]);

        // Self link
        CategoryLink::create([
            'ancestor_id' => $category->id,
            'descendant_id' => $category->id,
            'depth' => 0
        ]);

        if ($parentId) {
            $ancestors = CategoryLink::where('descendant_id', $parentId)->get();
            foreach ($ancestors as $ancestor) {
                CategoryLink::create([
                    'ancestor_id' => $ancestor->ancestor_id,
                    'descendant_id' => $category->id,
                    'depth' => $ancestor->depth + 1
                ]);
            }
        }

        foreach ($children as $key => $value) {
            if (is_array($value)) {
                $this->createCategoryNode($key, $category->id, $value);
            } else {
                $this->createCategoryNode($value, $category->id, []);
            }
        }
    }
}
