<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ProductAuction extends Model
{
    /** @use HasFactory<\Database\Factories\ProductAuctionFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'status',
        'price',
        'start',
        'end',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start' => 'datetime',
            'end' => 'datetime',
        ];
    }

    /* ------------------------- Relationships ------------------------- */

    // User
    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(
            User::class,
            Product::class,
            'id',
            'id',
            'product_id',
            'user_id'
        );
    }

    // Product
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // ProductBid
    public function bids(): HasMany
    {
        return $this->hasMany(ProductBid::class, 'auction_id');
    }
    
    // ProductBid
    public function purchases(): MorphMany
    {
        return $this->morphMany(ProductPurchase::class, 'purchasable');
    }

    /* ----------------------------------------------------------------- */
}
