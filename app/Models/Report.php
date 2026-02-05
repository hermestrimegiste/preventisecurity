<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Report extends Model
{
    protected $fillable = [
        'assessment_id',
        'json_blob',
        'pdf_url',
        'web_url',
        'share_token',
        'expires_at',
        'generated_at',
        'ai_prompt_version',
    ];

    protected $casts = [
        'json_blob' => 'array',
        'expires_at' => 'datetime',
        'generated_at' => 'datetime',
    ];

    // Relationships
    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    // Helpers
    public function generateShareToken(): string
    {
        $this->share_token = Str::random(64);
        $this->expires_at = now()->addDays(30);
        $this->save();

        return route('report.shared', ['token' => $this->share_token]);
    }

    public function isShareTokenValid(): bool
    {
        return $this->share_token && 
               $this->expires_at && 
               $this->expires_at->isFuture();
    }

    public function markAsGenerated(): void
    {
        $this->update(['generated_at' => now()]);
    }
}
