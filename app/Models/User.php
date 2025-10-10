<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'document',
        'password',
        'verification_method',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the raffles organized by this user.
     */
    public function raffles(): HasMany
    {
        return $this->hasMany(Raffle::class, 'organizer_id');
    }

    /**
     * Get the tickets purchased by this user.
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'participant_email', 'email');
    }

    /**
     * Get the email verification records for this user.
     */
    public function emailVerifications(): HasMany
    {
        return $this->hasMany(EmailVerification::class);
    }

    /**
     * Get the password reset records for this user.
     */
    public function passwordResets(): HasMany
    {
        return $this->hasMany(PasswordReset::class);
    }

    /**
     * Get the WhatsApp verifications for the user.
     */
    public function whatsappVerifications(): HasMany
    {
        return $this->hasMany(WhatsAppVerification::class);
    }

    /**
     * Check if the user's email is verified.
     */
    public function hasVerifiedEmail(): bool
    {
        return !is_null($this->email_verified_at);
    }

    /**
     * Mark the user's email as verified.
     */
    public function markEmailAsVerified(): bool
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Check if user has phone number configured.
     */
    public function hasPhone(): bool
    {
        return !is_null($this->phone) && !empty($this->phone);
    }

    /**
     * Get user's preferred verification method.
     */
    public function getVerificationMethod(): string
    {
        return $this->verification_method ?? 'email';
    }

    /**
     * Check if user prefers WhatsApp verification.
     */
    public function prefersWhatsAppVerification(): bool
    {
        return $this->getVerificationMethod() === 'whatsapp' && $this->hasPhone();
    }
}