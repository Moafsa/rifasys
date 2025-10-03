<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'raffle_id',
        'ticket_quantity',
        'total_price',
        'session_id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    /**
     * Get the user that owns the cart item.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the raffle that this cart item is for.
     */
    public function raffle(): BelongsTo
    {
        return $this->belongsTo(Raffle::class);
    }

    /**
     * Scope a query to only include items for a specific user.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to only include items for a specific session.
     */
    public function scopeForSession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }
}


