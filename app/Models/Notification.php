<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'message',
        'type',
        'recipient_type',
        'recipient_id',
        'recipient_email',
        'is_read',
        'read_at',
        'metadata'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'metadata' => 'array'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    public function scopeForRecipient($query, $type, $id = null)
    {
        return $query->where(function($q) use ($type, $id) {
            $q->where('recipient_type', $type);
            if ($id) {
                $q->where('recipient_id', $id);
            }
        })->orWhere('recipient_type', 'all');
    }

    // Methods
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now()
        ]);
    }

    public function markAsUnread()
    {
        $this->update([
            'is_read' => false,
            'read_at' => null
        ]);
    }

    // Static methods for creating notifications
    public static function createForUser($title, $message, $type, $recipientType, $recipientId = null, $recipientEmail = null, $metadata = [])
    {
        return self::create([
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'recipient_type' => $recipientType,
            'recipient_id' => $recipientId,
            'recipient_email' => $recipientEmail,
            'metadata' => $metadata
        ]);
    }

    public static function createForAll($title, $message, $type = 'info', $metadata = [])
    {
        return self::create([
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'recipient_type' => 'all',
            'metadata' => $metadata
        ]);
    }
}
