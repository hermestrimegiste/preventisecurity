<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Consultant extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'calendars',
        'skills',
        'is_active',
    ];

    protected $casts = [
        'calendars' => 'array',
        'skills' => 'array',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeWithSkill($query, string $skill)
    {
        return $query->whereJsonContains('skills', $skill);
    }

    // Helpers
    public function hasSkill(string $skill): bool
    {
        return in_array($skill, $this->skills ?? []);
    }

    public function getUpcomingBookingsCount(): int
    {
        return $this->bookings()
            ->where('slot_start', '>', now())
            ->where('status', 'scheduled')
            ->count();
    }
}
