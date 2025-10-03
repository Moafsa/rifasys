<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RafflePrize extends Model
{
    use HasFactory;

    protected $fillable = [
        'raffle_id',
        'name',
        'image_url',
        'description',
        'position',
    ];

    /**
     * Get the raffle that owns the prize.
     */
    public function raffle(): BelongsTo
    {
        return $this->belongsTo(Raffle::class);
    }

    /**
     * Scope a query to order prizes by position.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('position')->orderBy('created_at');
    }

    /**
     * Get the image URL or a default placeholder.
     */
    public function getImageUrlAttribute($value)
    {
        if ($value) {
            return $value;
        }
        
        // Return a placeholder image URL
        return 'https://via.placeholder.com/300x200/667eea/ffffff?text=' . urlencode($this->name);
    }
}


