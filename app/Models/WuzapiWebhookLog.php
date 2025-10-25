<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WuzapiWebhookLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'wuzapi_instance_id',
        'event_type',
        'payload',
        'response',
        'status_code',
        'processing_time',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'payload' => 'array',
        'response' => 'array',
        'processing_time' => 'float',
    ];

    /**
     * Get the instance that owns the log
     */
    public function instance()
    {
        return $this->belongsTo(WuzapiInstance::class, 'wuzapi_instance_id');
    }

    /**
     * Scope for successful webhooks
     */
    public function scopeSuccessful($query)
    {
        return $query->where('status_code', '>=', 200)
                    ->where('status_code', '<', 300);
    }

    /**
     * Scope for failed webhooks
     */
    public function scopeFailed($query)
    {
        return $query->where('status_code', '>=', 400);
    }

    /**
     * Scope for specific event type
     */
    public function scopeEventType($query, string $eventType)
    {
        return $query->where('event_type', $eventType);
    }

    /**
     * Get event type badge class
     */
    public function getEventTypeBadgeClass(): string
    {
        switch ($this->event_type) {
            case 'Message':
                return 'badge-primary';
            case 'ReadReceipt':
                return 'badge-info';
            case 'Presence':
                return 'badge-warning';
            case 'HistorySync':
                return 'badge-secondary';
            case 'ChatPresence':
                return 'badge-dark';
            default:
                return 'badge-light';
        }
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClass(): string
    {
        if ($this->status_code >= 200 && $this->status_code < 300) {
            return 'badge-success';
        } elseif ($this->status_code >= 400 && $this->status_code < 500) {
            return 'badge-warning';
        } else {
            return 'badge-danger';
        }
    }
}
