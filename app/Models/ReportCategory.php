<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ReportCategory extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'title',
        'subtitle',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('report_categories_all'));
        static::deleted(fn () => Cache::forget('report_categories_all'));
    }

    public static function getBySlug(string $slug): ?self
    {
        return self::where('slug', $slug)->where('is_active', true)->first();
    }

    public static function getAllActive(): \Illuminate\Database\Eloquent\Collection
    {
        return Cache::remember('report_categories_all', 3600, fn () =>
            self::where('is_active', true)->orderBy('sort_order')->get()
        );
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
