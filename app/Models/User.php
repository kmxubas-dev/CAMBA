<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fname',
        'lname',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /* ------------------------- Relationships ------------------------- */

    // UserInfo
    public function info(): HasOne
    {
        return $this->hasOne(UserInfo::class, 'user_id');
    }

    // Product
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'user_id');
    }

    // ProductAuction
    public function auctions(): HasManyThrough
    {
        return $this->hasManyThrough(
            ProductAuction::class,
            Product::class,
            'user_id',
            'product_id',
            'id',
            'id'
        );
    }

    // ProductBid
    public function bids(): HasMany
    {
        return $this->hasMany(ProductBid::class, 'user_id');
    }

    // ProductPurchase - as a buyer
    public function purchases(): HasMany
    {
        return $this->hasMany(ProductPurchase::class, 'user_id');
    }

    // ProductPurchase - as a seller
    public function sales(): HasManyThrough
    {
        return $this->hasManyThrough(
            ProductPurchase::class,
            Product::class,
            'user_id',
            'product_id',
            'id',
            'id'
        );
    }

    /* ------------------------- Accessors/Mutators ------------------------- */

    // Full name
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->fname.' '.$this->lname,
        );
    }

    /* ---------------------------------------------------------------------- */
}
