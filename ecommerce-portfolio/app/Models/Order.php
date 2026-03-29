<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'user_id', 'customer_name', 'phone', 'status', 'total_amount', 'tracking_number', 'shipping_address'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $date = now()->format('dmy'); // 080226
                $prefix = 'ORD-' . $date;
                
                // Get the last order to determine the next sequence number
                $lastOrder = static::where('id', 'like', $prefix . '%')
                                   ->orderBy('created_at', 'desc')
                                   ->orderBy('id', 'desc')
                                   ->first();

                if ($lastOrder) {
                    // Extract the sequence number (last 5 digits)
                    $lastSequence = intval(substr($lastOrder->id, -5)); 
                    $nextSequence = $lastSequence + 1;
                } else {
                    $nextSequence = 1;
                }

                $model->id = $prefix . str_pad($nextSequence, 5, '0', STR_PAD_LEFT);
            }
        });
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
