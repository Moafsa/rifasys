<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Raffle extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'organizer_description',
        'prize_description',
        'prize_image',
        'price_per_ticket',
        'total_tickets',
        'sold_tickets',
        'progress_percentage',
        'draw_date',
        'status',
        'category',
        'state',
        'city',
        'neighborhood',
        'address',
        'zip_code',
        'organizer_id',
        'featured',
        'min_tickets_to_draw',
        'terms_conditions',
        'contact_info',
        'goal_amount',
        'current_amount',
        'payment_methods',
        'social_media_links',
        'is_public',
        'auto_draw',
        'notify_winners',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'draw_date' => 'datetime',
        'featured' => 'boolean',
        'is_public' => 'boolean',
        'auto_draw' => 'boolean',
        'notify_winners' => 'boolean',
        'payment_methods' => 'array',
        'social_media_links' => 'array',
        'price_per_ticket' => 'decimal:2',
        'progress_percentage' => 'decimal:2',
        'goal_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
    ];

    /**
     * Get the organizer that owns the raffle.
     */
    public function organizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    /**
     * Get the tickets for the raffle.
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Get the prizes for the raffle.
     */
    public function prizes(): HasMany
    {
        return $this->hasMany(RafflePrize::class)->ordered();
    }

    /**
     * Get the sold tickets count.
     */
    public function getSoldTicketsCountAttribute(): int
    {
        return $this->tickets()->count();
    }

    /**
     * Get the progress percentage.
     */
    public function getProgressPercentageAttribute(): float
    {
        if ($this->total_tickets <= 0) {
            return 0;
        }
        
        return ($this->sold_tickets / $this->total_tickets) * 100;
    }

    /**
     * Get the remaining tickets count.
     */
    public function getRemainingTicketsAttribute(): int
    {
        return $this->total_tickets - $this->sold_tickets;
    }

    /**
     * Get the total amount raised.
     */
    public function getTotalAmountRaisedAttribute(): float
    {
        return $this->sold_tickets * $this->price_per_ticket;
    }

    /**
     * Check if the raffle is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active' && 
               $this->draw_date > now() && 
               $this->sold_tickets < $this->total_tickets;
    }

    /**
     * Check if the raffle is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if the raffle is cancelled.
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    /**
     * Check if the raffle is featured.
     */
    public function isFeatured(): bool
    {
        return $this->featured === true;
    }

    /**
     * Scope a query to only include active raffles.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                    ->where('draw_date', '>', now())
                    ->whereColumn('sold_tickets', '<', 'total_tickets')
                    ->where('is_public', true);
    }

    /**
     * Scope a query to only include featured raffles.
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope a query to only include public raffles.
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope a query to only include raffles by category.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope a query to only include raffles by state.
     */
    public function scopeByState($query, $state)
    {
        return $query->where('state', $state);
    }

    /**
     * Scope a query to only include raffles by city.
     */
    public function scopeByCity($query, $city)
    {
        return $query->where('city', $city);
    }

    /**
     * Scope a query to only include raffles by location (state and city).
     */
    public function scopeByLocation($query, $state, $city = null)
    {
        $query->where('state', $state);
        if ($city) {
            $query->where('city', $city);
        }
        return $query;
    }

    /**
     * Scope a query to only include raffles by price range.
     */
    public function scopeByPriceRange($query, $minPrice, $maxPrice)
    {
        return $query->whereBetween('price_per_ticket', [$minPrice, $maxPrice]);
    }

    /**
     * Scope a query to only include raffles by ID.
     */
    public function scopeById($query, $id)
    {
        return $query->where('id', $id);
    }
}
