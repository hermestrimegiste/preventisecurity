<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    protected $fillable = [
        'assessment_id',
        'question_id',
        'value',
        'custom_value',
        'is_custom',
        'evidence_url',
    ];

    protected $casts = [
        'custom_value' => 'array',
        'is_custom' => 'boolean',
    ];

    // Relationships
    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(CmsQuestion::class, 'question_id');
    }

    // Helpers
    public function getAnswerContent()
    {
        return $this->is_custom ? $this->custom_value : $this->value;
    }
}
