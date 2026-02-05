<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recommendation extends Model
{
    protected $fillable = [
        'assessment_id',
        'title',
        'description',
        'impact',
        'effort',
        'horizon',
        'cost_range',
        'order',
    ];

    // Relationships
    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    // Scopes
    public function scopeQuickWins($query)
    {
        return $query->where('horizon', '0-30j')
            ->where('effort', 'small')
            ->where('impact', 'high');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    //Helpers
    public function getPriorityScore(): int
    {
        $impactScore = match($this->impact) {
            'high' => 3,
            'medium' => 2,
            'low' => 1,
            default => 0,
        };

        $effortScore = match($this->effort) {
            'small' => 3,
            'medium' => 2,
            'large' => 1,
            default => 0,
        };

        return $impactScore * 2 + $effortScore;
    }
}
