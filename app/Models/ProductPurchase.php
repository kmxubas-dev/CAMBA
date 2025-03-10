<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ProductPurchase extends Model
{
    /** @use HasFactory<\Database\Factories\ProductPurchaseFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'purchasable_type',
        'purchasable_id',
        'amount',
        'status',
        'purchase_info',
        'payment_info',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'purchase_info' => 'array',
            'payment_info'  => 'array',
        ];
    }

    /* ------------------------- Relationships ------------------------- */

    // User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Product
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    
    // Product || ProductAuction
    public function purchasable(): MorphTo
    {
        return $this->morphTo();
    }

    /* ----------------------------------------------------------------- */
}
