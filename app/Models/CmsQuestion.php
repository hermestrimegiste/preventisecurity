<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CmsQuestion extends Model
{
    protected $fillable = [
        'section_id',
        'question_text',
        'help_text',
        'help_link',
        'assessment_level',
        'answer_type',
        'options',
        'dependencies',
        'weight',
        'order',
        'is_active',
    ];

    protected $casts = [
        'options' => 'array',
        'dependencies' => 'array',
        'weight' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function section(): BelongsTo
    {
        return $this->belongsTo(CmsSection::class, 'section_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class, 'question_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForLevel($query, string $level)
    {
        return $query->where('assessment_level', $level)
            ->orWhere('assessment_level', 'both');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    // Helpers
    public function shouldDisplay(array $previousAnswers): bool
    {
        if (empty($this->dependencies)) {
            return true;
        }

        // Evaluate dependencies logic
        // Format: ['question_id' => 'expected_value']
        foreach ($this->dependencies as $questionId => $expectedValue) {
            if (!isset($previousAnswers[$questionId]) || 
                $previousAnswers[$questionId] !== $expectedValue) {
                return false;
            }
        }

        return true;
    }
}
