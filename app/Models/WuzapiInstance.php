<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WuzapiInstance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'api_token',
        'instance_id',
        'webhook_url',
        'webhook_secret',
        'status',
        'qr_code',
        'phone_number',
        'user_id',
        'settings',
        'last_connected_at',
        'expires_at',
    ];

    protected $casts = [
        'settings' => 'array',
        'last_connected_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Get the user that owns the instance
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the raffles associated with this instance
     */
    public function raffles()
    {
        return $this->hasMany(Raffle::class, 'wuzapi_instance_id');
    }

    /**
     * Get the webhook logs for this instance
     */
    public function webhookLogs()
    {
        return $this->hasMany(WuzapiWebhookLog::class);
    }

    /**
     * Get the message logs for this instance
     */
    public function messageLogs()
    {
        return $this->hasMany(WuzapiMessageLog::class);
    }

    /**
     * Check if instance is active
     */
    public function isActive(): bool
    {
        return $this->status === 'connected' && $this->last_connected_at && $this->last_connected_at->isAfter(now()->subMinutes(5));
    }

    /**
     * Check if instance is expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Get connection status
     */
    public function getConnectionStatus(): string
    {
        if ($this->isExpired()) {
            return 'expired';
        }
        
        if ($this->isActive()) {
            return 'connected';
        }
        
        if ($this->status === 'connecting') {
            return 'connecting';
        }
        
        return 'disconnected';
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClass(): string
    {
        switch ($this->getConnectionStatus()) {
            case 'connected':
                return 'badge-success';
            case 'connecting':
                return 'badge-warning';
            case 'expired':
                return 'badge-danger';
            default:
                return 'badge-secondary';
        }
    }

    /**
     * Get settings with defaults
     */
    public function getSettings(): array
    {
        $defaults = [
            'timeout' => 30,
            'retry_attempts' => 3,
            'retry_delay' => 1,
            'max_retries' => 3,
            'rate_limit' => 100,
            'log_all' => true,
            'notifications' => [
                'purchase_confirmation' => true,
                'draw_notifications' => true,
                'winner_notifications' => true,
                'reminder_notifications' => true,
            ],
        ];

        return array_merge($defaults, $this->settings ?? []);
    }

    /**
     * Update settings
     */
    public function updateSettings(array $settings): void
    {
        $currentSettings = $this->getSettings();
        $newSettings = array_merge($currentSettings, $settings);
        $this->update(['settings' => $newSettings]);
    }

    /**
     * Get QR code for connection
     */
    public function getQRCode(): ?string
    {
        return $this->qr_code;
    }

    /**
     * Update QR code
     */
    public function updateQRCode(string $qrCode): void
    {
        $this->update(['qr_code' => $qrCode]);
    }

    /**
     * Update connection status
     */
    public function updateConnectionStatus(string $status, ?string $phoneNumber = null): void
    {
        $updateData = [
            'status' => $status,
            'last_connected_at' => now(),
        ];

        if ($phoneNumber) {
            $updateData['phone_number'] = $phoneNumber;
        }

        $this->update($updateData);
    }

    /**
     * Scope for active instances
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'connected')
                    ->where('last_connected_at', '>', now()->subMinutes(5));
    }

    /**
     * Scope for user instances
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
