<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function ancestors()
    {
        return $this->belongsToMany(Category::class, 'category_links', 'descendant_id', 'ancestor_id')
                    ->withPivot('depth')
                    ->where('depth', '>', 0);
    }

    public function descendants()
    {
        return $this->belongsToMany(Category::class, 'category_links', 'ancestor_id', 'descendant_id')
                    ->withPivot('depth')
                    ->where('depth', '>', 0);
    }

    public function parent()
    {
        return $this->belongsToMany(Category::class, 'category_links', 'descendant_id', 'ancestor_id')
                    ->wherePivot('depth', 1);
    }

    public function children()
    {
        return $this->belongsToMany(Category::class, 'category_links', 'ancestor_id', 'descendant_id')
                    ->wherePivot('depth', 1);
    }
}
