<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BrazilState extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'region',
    ];

    /**
     * Get the cities for the state.
     */
    public function cities(): HasMany
    {
        return $this->hasMany(BrazilCity::class, 'state_id');
    }

    /**
     * Scope a query to only include states from a specific region.
     */
    public function scopeByRegion($query, $region)
    {
        return $query->where('region', $region);
    }

    /**
     * Get all regions.
     */
    public static function getRegions()
    {
        return self::select('region')
            ->distinct()
            ->orderBy('region')
            ->pluck('region');
    }
}


