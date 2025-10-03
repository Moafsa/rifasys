<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class PasswordReset extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email',
        'token',
        'expires_at',
        'used_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    /**
     * Get the user that owns the password reset.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the reset token is expired.
     */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Check if the reset token is valid.
     */
    public function isValid(): bool
    {
        return !$this->isExpired() && !$this->used_at;
    }

    /**
     * Mark the reset token as used.
     */
    public function markAsUsed(): void
    {
        $this->update(['used_at' => now()]);
    }

    /**
     * Generate a new reset token (4-digit code).
     */
    public static function generateToken(): string
    {
        return str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
    }

    /**
     * Create a new password reset record.
     */
    public static function createForUser(User $user): self
    {
        // Delete any existing reset tokens for this user
        static::where('user_id', $user->id)->delete();

        return static::create([
            'user_id' => $user->id,
            'email' => $user->email,
            'token' => static::generateToken(),
            'expires_at' => now()->addMinutes(3), // Token expires in 3 minutes
        ]);
    }

    /**
     * Find a reset token by token string.
     */
    public static function findByToken(string $token): ?self
    {
        return static::where('token', $token)
            ->where('expires_at', '>', now())
            ->whereNull('used_at')
            ->first();
    }
}
