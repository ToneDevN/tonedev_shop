<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'customer_name',
        'phone',
        'status',
        'total_amount',
        'tracking_number',
        'shipping_address',
    ];

    protected $casts = [
        'total_amount' => 'integer',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Order $model): void {
            if (! empty($model->id)) {
                return;
            }

            $date = now()->format('dmy'); // e.g. 200426
            $prefix = 'ORD-'.$date;

            $lastOrder = static::where('id', 'like', $prefix.'%')
                ->orderByDesc('id')
                ->first();

            $next = $lastOrder
                ? (int) substr($lastOrder->id, -5) + 1
                : 1;

            $model->id = $prefix.str_pad((string) $next, 5, '0', STR_PAD_LEFT);
        });
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}
