<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\CategoryLink;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        // Return root categories with their children
        $categories = Category::whereDoesntHave('ancestors')->with('children')->get();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            $slug = Str::slug($request->name);
            $count = Category::where('slug', 'like', $slug . '%')->count();
            if ($count > 0) {
                $slug = $slug . '-' . time();
            }

            $category = Category::create([
                'name' => $request->name,
                'slug' => $slug,
                'image' => $request->image
            ]);

            // Self link (depth 0)
            CategoryLink::create([
                'ancestor_id' => $category->id,
                'descendant_id' => $category->id,
                'depth' => 0
            ]);

            if ($request->parent_id) {
                // Insert paths from ancestors of parent to the new category
                $ancestors = CategoryLink::where('descendant_id', $request->parent_id)->get();
                foreach ($ancestors as $ancestor) {
                    CategoryLink::create([
                        'ancestor_id' => $ancestor->ancestor_id,
                        'descendant_id' => $category->id,
                        'depth' => $ancestor->depth + 1
                    ]);
                }
            }
            DB::commit();

            return response()->json($category->load('parent'), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(string $id)
    {
        $category = Category::with(['children', 'parent', 'ancestors', 'descendants'])->findOrFail($id);
        return response()->json($category);
    }

    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);
        
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'image' => 'nullable|string'
        ]);

        if ($request->has('name')) {
            $category->name = $request->name;
            $slug = Str::slug($request->name);
            $count = Category::where('slug', 'like', $slug . '%')->where('id', '!=', $id)->count();
            if ($count > 0) {
                $slug = $slug . '-' . time();
            }
            $category->slug = $slug;
        }
        
        if ($request->has('image')) {
            $category->image = $request->image;
        }

        if ($category->isDirty()) {
            $category->save();
        }

        return response()->json($category);
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        
        DB::beginTransaction();
        try {
            // Because of soft deletes, we can delete the category.
            // Depending on logic, soft deleting the category might be enough if category_links cascades on real delete, 
            // but for soft deletes we manually delete links or just let it be and use Eloquent.
            $category->delete();
            // Optional: delete links where this is descendant or ancestor
            CategoryLink::where('descendant_id', $id)->orWhere('ancestor_id', $id)->delete();
            
            DB::commit();
            return response()->json(['message' => 'Category deleted']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
