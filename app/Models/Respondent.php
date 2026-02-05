<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Respondent extends Model
{
    protected $fillable = [
        'organization_id',
        'email',
        'role',
        'company_name',
        'locale',
        'magic_link_token',
        'magic_link_expires_at',
        'consent_gdpr_at',
    ];

    protected $casts = [
        'magic_link_expires_at' => 'datetime',
        'consent_gdpr_at' => 'datetime',
    ];

    protected $hidden = [
        'magic_link_token',
    ];

    // Relationships
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class);
    }

    // Scopes
    public function scopeForOrganization($query, $organizationId)
    {
        return $query->where('organization_id', $organizationId);
    }

    // Helpers
    public function generateMagicLink(): string
    {
        $this->magic_link_token = bin2hex(random_bytes(32));
        $this->magic_link_expires_at = now()->addDays(7);
        $this->save();

        return route('assessment.resume', ['token' => $this->magic_link_token]);
    }

    public function isMagicLinkValid(): bool
    {
        return $this->magic_link_token && 
               $this->magic_link_expires_at && 
               $this->magic_link_expires_at->isFuture();
    }
}
