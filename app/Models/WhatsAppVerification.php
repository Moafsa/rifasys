<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class WhatsAppVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'token',
        'expires_at',
        'verified_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    /**
     * Get the user that owns the WhatsApp verification.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the verification token is expired.
     */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Check if the verification token is valid.
     */
    public function isValid(): bool
    {
        return !$this->isExpired() && !$this->verified_at;
    }

    /**
     * Mark the WhatsApp verification as verified.
     */
    public function markAsVerified(): void
    {
        $this->update(['verified_at' => now()]);
    }

    /**
     * Generate a new verification token (4-digit code).
     */
    public static function generateToken(): string
    {
        return str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
    }

    /**
     * Create a new WhatsApp verification record.
     */
    public static function createForUser(User $user, string $phone): self
    {
        // Delete any existing verification for this user
        static::where('user_id', $user->id)->delete();

        return static::create([
            'user_id' => $user->id,
            'phone' => $phone,
            'token' => static::generateToken(),
            'expires_at' => now()->addMinutes(3), // Token expires in 3 minutes
        ]);
    }

    /**
     * Find a verification by token.
     */
    public static function findByToken(string $token): ?self
    {
        return static::where('token', $token)
            ->where('expires_at', '>', now())
            ->whereNull('verified_at')
            ->first();
    }

    /**
     * Find a verification by user ID and token.
     */
    public static function findByUserAndToken(int $userId, string $token): ?self
    {
        return static::where('user_id', $userId)
            ->where('token', $token)
            ->where('expires_at', '>', now())
            ->whereNull('verified_at')
            ->first();
    }
}


