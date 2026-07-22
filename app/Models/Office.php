<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Spatie\ResponseCache\Facades\ResponseCache;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Office extends Model
{
    use HasFactory, HasSlug, Auditable;

    protected static function getAuditModelName(): string
    {
        return 'Kantor';
    }

    protected $fillable = [
        'name',
        'slug',
        'type',
        'address',
        'description',
        'phone',
        'email',
        'photo',
        'latitude',
        'longitude',
        'google_maps_url',
        'operational_hours',
        'is_active'
    ];

    protected $casts = [
        'operational_hours' => 'array',
        'is_active' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8'
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('name')->saveSlugsTo('slug');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'pusat' => 'Kantor Pusat',
            'cabang' => 'Kantor Cabang',
            'kas' => 'Kantor Kas',
            'kas_keliling' => 'Kas Keliling',
            default => ucfirst($this->type)
        };
    }

    public function getHasCoordinatesAttribute(): bool
    {
        return $this->latitude && $this->longitude;
    }

    public function getDirectionsUrlAttribute(): ?string
    {
        return $this->has_coordinates
            ? "https://www.google.com/maps/dir/?api=1&destination={$this->latitude},{$this->longitude}"
            : null;
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = \App\Helpers\HtmlSanitizer::clean($value);
    }

    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = \App\Helpers\HtmlSanitizer::clean($value);
    }

    protected static function booted(): void
    {
        $clearCache = function () {
            Cache::forget(Config::get('cache-keys.offices') . '_all');
            Cache::forget(Config::get('cache-keys.offices') . '_pusat');
            Cache::forget(Config::get('cache-keys.offices') . '_cabang');
            Cache::forget(Config::get('cache-keys.offices') . '_kas');
            Cache::forget(Config::get('cache-keys.offices') . '_kas_keliling');

            // Invalidate full-page response cache
            ResponseCache::clear();
        };

        static::saved($clearCache);
        static::deleted($clearCache);
    }
}
