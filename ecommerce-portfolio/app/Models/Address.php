<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['user_id', 'customer_name', 'phone', 'address'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
