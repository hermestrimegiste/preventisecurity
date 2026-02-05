<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CmsSection extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'order',
        'assessment_level',
    ];

    // Relationships
    public function questions(): HasMany
    {
        return $this->hasMany(CmsQuestion::class, 'section_id');
    }

    // Scopes
    public function scopeForLevel($query, string $level)
    {
        return $query->where('assessment_level', $level)
            ->orWhere('assessment_level', 'both');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
