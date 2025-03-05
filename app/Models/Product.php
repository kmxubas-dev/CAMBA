<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'status',
        'name',
        'qty',
        'price',
        'images',
        'description',
        'attributes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'attributes' => 'array',
        ];
    }

    /* ------------------------- Relationships ------------------------- */

    // User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ProductAuction
    public function auction(): HasOne
    {
        return $this->hasOne(ProductAuction::class, 'product_id');
    }

    // ProductBid
    public function bids(): HasManyThrough
    {
        return $this->hasManyThrough(
            ProductBid::class,
            ProductAuction::class,
            'product_id',
            'auction_id'
        );
    }

    /* ----------------------------------------------------------------- */
}
