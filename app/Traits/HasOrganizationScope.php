<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait HasOrganizationScope
{
    /**
     * The "booted" method of the trait.
     */
    protected static function bootHasOrganizationScope(): void
    {
        static::addGlobalScope('organization', function (Builder $builder) {
            if (Auth::check() && Auth::user()->current_organization_id) {
                $builder->where('organization_id', Auth::user()->current_organization_id);
            }
        });

        static::creating(function (Model $model) {
            if (Auth::check() && Auth::user()->current_organization_id) {
                if (!$model->organization_id) {
                    $model->organization_id = Auth::user()->current_organization_id;
                }
            }
        });
    }

    public function organization()
    {
        return $this->belongsTo(\App\Models\Organization::class);
    }

    public function scopeForOrganization(Builder $query, int $organizationId): Builder
    {
        return $query->where('organization_id', $organizationId);
    }

    public function scopeWithoutOrganizationScope(Builder $query): Builder
    {
        return $query->withoutGlobalScope('organization');
    }
}
