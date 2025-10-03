<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BrazilCity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'state_id',
        'ibge_code',
    ];

    /**
     * Get the state that owns the city.
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(BrazilState::class, 'state_id');
    }

    /**
     * Scope a query to only include cities from a specific state.
     */
    public function scopeByState($query, $stateId)
    {
        return $query->where('state_id', $stateId);
    }
}


