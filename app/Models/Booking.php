<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'assessment_id',
        'consultant_id',
        'provider',
        'provider_booking_id',
        'slot_start',
        'slot_end',
        'timezone',
        'meeting_link',
        'status',
        'reminder_sent_at',
    ];

    protected $casts = [
        'slot_start' => 'datetime',
        'slot_end' => 'datetime',
        'reminder_sent_at' => 'datetime',
    ];

    // Relationships
    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    public function consultant(): BelongsTo
    {
        return $this->belongsTo(Consultant::class);
    }

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('slot_start', '>', now())
            ->where('status', 'scheduled');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('slot_start', today())
            ->where('status', 'scheduled');
    }

    // Helpers
    public function markAsCompleted(): void
    {
        $this->update(['status' => 'completed']);
    }

    public function markAsCancelled(): void
    {
        $this->update(['status' => 'cancelled']);
    }

    public function markAsNoShow(): void
    {
        $this->update(['status' => 'no_show']);
    }

    public function needsReminder(): bool
    {
        return !$this->reminder_sent_at && 
               $this->slot_start && 
               $this->slot_start->subHours(24)->isPast() &&
               $this->status === 'scheduled';
    }
}
