<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class ProductBid extends Model
{
    /** @use HasFactory<\Database\Factories\ProductBidFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'amount',
    ];

    /* ------------------------- Relationships ------------------------- */

    // Product
    public function product(): HasOneThrough
    {
        return $this->hasOneThrough(
            Product::class,
            ProductAuction::class,
            'id',
            'id',
            'auction_id',
            'product_id'
        );
    }

    // ProductAuction
    public function auction(): BelongsTo
    {
        return $this->belongsTo(ProductAuction::class, 'auction_id');
    }

    // User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /* ----------------------------------------------------------------- */
}
