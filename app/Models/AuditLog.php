<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    public $timestamps = false; // Uses 'timestamp' field instead

    protected $fillable = [
        'actor_id',
        'action',
        'entity',
        'entity_id',
        'changes',
        'ip_address',
        'user_agent',
        'timestamp',
    ];

    protected $casts = [
        'changes' => 'array',
        'timestamp' => 'datetime',
    ];

    // Relationships
    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    // Scopes
    public function scopeForEntity($query, string $entity, ?int $entityId = null)
    {
        $query->where('entity', $entity);

        if ($entityId) {
            $query->where('entity_id', $entityId);
        }

        return $query;
    }

    public function scopeByActor($query, int $actorId)
    {
        return $query->where('actor_id', $actorId);
    }

    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('timestamp', '>=', now()->subDays($days));
    }

    // Static helper
    public static function log(string $action, string $entity, ?int $entityId = null, ?array $changes = null): void
    {
        self::create([
            'actor_id' => auth()->id(),
            'action' => $action,
            'entity' => $entity,
            'entity_id' => $entityId,
            'changes' => $changes,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now(),
        ]);
    }
}
