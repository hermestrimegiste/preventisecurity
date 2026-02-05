<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CmsItem extends Model
{
    protected $fillable = [
        'type',
        'locale',
        'slug',
        'title',
        'content',
        'metadata',
        'is_published',
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_published' => 'boolean',
    ];

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeForLocale($query, string $locale)
    {
        return $query->where('locale', $locale);
    }

    public function scopeBySlug($query, string $slug)
    {
        return $query->where('slug', $slug);
    }

    // Static helpers
    public static function getPage(string $slug, string $locale = 'fr'): ?self
    {
        return self::published()
            ->ofType('page')
            ->forLocale($locale)
            ->bySlug($slug)
            ->first();
    }

    public static function getEmailTemplate(string $slug, string $locale = 'fr'): ?self
    {
        return self::published()
            ->ofType('email_template')
            ->forLocale($locale)
            ->bySlug($slug)
            ->first();
    }
}
