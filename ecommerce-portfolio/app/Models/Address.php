<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
<<<<<<< Updated upstream
    protected $fillable = ['user_id', 'customer_name', 'phone', 'address'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
=======
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'label',
        'recipient_name',
        'phone',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Return a single-line address string for use in order snapshots.
     */
    public function toShippingString(): string
    {
        return implode(' ', array_filter([
            $this->address,
            $this->city,
            $this->state,
            $this->zip_code,
            $this->country,
        ]));
    }
>>>>>>> Stashed changes
}
