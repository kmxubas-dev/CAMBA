<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserInfo extends Model
{
    /** @use HasFactory<\Database\Factories\UserInfoFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'birthdate',
        'address',
        'contact',
        'others',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'birthdate' => 'date',
            'others' => 'array',
        ];
    }

    /* ------------------------- Relationships ------------------------- */

    // User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /* ----------------------------------------------------------------- */
}
