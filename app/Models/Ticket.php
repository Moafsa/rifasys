<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'raffle_id',
        'participant_name',
        'participant_email',
        'participant_phone',
        'participant_document',
        'ticket_number',
        'price_paid',
        'payment_status',
        'payment_reference',
        'payment_method',
        'purchased_at',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'price_paid' => 'decimal:2',
        'purchased_at' => 'datetime',
    ];

    /**
     * Get the raffle that owns the ticket.
     */
    public function raffle(): BelongsTo
    {
        return $this->belongsTo(Raffle::class);
    }

    /**
     * Check if the ticket is paid.
     */
    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    /**
     * Check if the ticket is pending payment.
     */
    public function isPending(): bool
    {
        return $this->payment_status === 'pending';
    }

    /**
     * Check if the ticket is cancelled.
     */
    public function isCancelled(): bool
    {
        return $this->payment_status === 'cancelled';
    }

    /**
     * Scope a query to only include paid tickets.
     */
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    /**
     * Scope a query to only include pending tickets.
     */
    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    /**
     * Scope a query to only include tickets for a specific raffle.
     */
    public function scopeForRaffle($query, $raffleId)
    {
        return $query->where('raffle_id', $raffleId);
    }
}


