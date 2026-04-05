<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryLink extends Model
{
    use SoftDeletes;
    
    protected $table = 'category_links';
    
    public $incrementing = false;

    protected $fillable = [
        'ancestor_id',
        'descendant_id',
        'depth'
    ];
}
