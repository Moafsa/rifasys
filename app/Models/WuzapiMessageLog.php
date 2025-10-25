<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WuzapiMessageLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'wuzapi_instance_id',
        'message_id',
        'phone_number',
        'message_type',
        'content',
        'status',
        'response',
        'sent_at',
        'delivered_at',
        'read_at',
        'error_message',
    ];

    protected $casts = [
        'content' => 'array',
        'response' => 'array',
        'sent_at' => 'datetime',
        'delivered_at' => 'datetime',
        'read_at' => 'datetime',
    ];

    /**
     * Get the instance that owns the log
     */
    public function instance()
    {
        return $this->belongsTo(WuzapiInstance::class, 'wuzapi_instance_id');
    }

    /**
     * Scope for successful messages
     */
    public function scopeSuccessful($query)
    {
        return $query->where('status', 'sent');
    }

    /**
     * Scope for failed messages
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Scope for pending messages
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for specific message type
     */
    public function scopeMessageType($query, string $messageType)
    {
        return $query->where('message_type', $messageType);
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClass(): string
    {
        switch ($this->status) {
            case 'sent':
                return 'badge-success';
            case 'delivered':
                return 'badge-info';
            case 'read':
                return 'badge-primary';
            case 'failed':
                return 'badge-danger';
            case 'pending':
                return 'badge-warning';
            default:
                return 'badge-secondary';
        }
    }

    /**
     * Get message type badge class
     */
    public function getMessageTypeBadgeClass(): string
    {
        switch ($this->message_type) {
            case 'text':
                return 'badge-primary';
            case 'image':
                return 'badge-success';
            case 'document':
                return 'badge-info';
            case 'location':
                return 'badge-warning';
            case 'button':
                return 'badge-dark';
            case 'list':
                return 'badge-secondary';
            default:
                return 'badge-light';
        }
    }

    /**
     * Update message status
     */
    public function updateStatus(string $status, ?string $errorMessage = null): void
    {
        $updateData = ['status' => $status];
        
        if ($errorMessage) {
            $updateData['error_message'] = $errorMessage;
        }
        
        if ($status === 'delivered') {
            $updateData['delivered_at'] = now();
        } elseif ($status === 'read') {
            $updateData['read_at'] = now();
        }
        
        $this->update($updateData);
    }
}
