<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Assessment extends Model
{
    protected $fillable = [
        'organization_id',
        'respondent_id',
        'assessment_level',
        'parent_assessment_id',
        'status',
        'started_at',
        'submitted_at',
        'completed_at',
        'version',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'submitted_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function respondent(): BelongsTo
    {
        return $this->belongsTo(Respondent::class);
    }

    public function parentAssessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class, 'parent_assessment_id');
    }

    public function childAssessments(): HasMany
    {
        return $this->hasMany(Assessment::class, 'parent_assessment_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function scores(): HasMany
    {
        return $this->hasMany(Score::class);
    }

    public function recommendations(): HasMany
    {
        return $this->hasMany(Recommendation::class);
    }

    public function report(): HasOne
    {
        return $this->hasOne(Report::class);
    }

    public function booking(): HasOne
    {
        return $this->hasOne(Booking::class);
    }

    // Scopes
    public function scopeExpress($query)
    {
        return $query->where('assessment_level', 'express');
    }

    public function scopeDetailed($query)
    {
        return $query->where('assessment_level', 'detailed');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Helpers
    public function markAsStarted(): void
    {
        if (!$this->started_at) {
            $this->update([
                'started_at' => now(),
                'status' => 'in_progress',
            ]);
        }
    }

    public function markAsSubmitted(): void
    {
        $this->update([
            'submitted_at' => now(),
            'status' => 'submitted',
        ]);
    }

    public function markAsCompleted(): void
    {
        $this->update([
            'completed_at' => now(),
            'status' => 'completed',
        ]);
    }

    public function isExpress(): bool
    {
        return $this->assessment_level === 'express';
    }

    public function isDetailed(): bool
    {
        return $this->assessment_level === 'detailed';
    }

    public function completionPercentage(): int
    {
        $totalQuestions = CmsQuestion::where('assessment_level', $this->assessment_level)
            ->orWhere('assessment_level', 'both')
            ->count();

        if ($totalQuestions === 0) {
            return 0;
        }

        $answeredQuestions = $this->answers()->count();

        return min(100, (int) (($answeredQuestions / $totalQuestions) * 100));
    }
}
