<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Auction extends Model
{
    use HasFactory, HasSlug, Auditable;

    protected static function getAuditModelName(): string
    {
        return 'Lelang';
    }

    protected $fillable = [
        // Informasi Dasar
        'title',
        'slug',
        'auction_number',
        'description',
        // Aset
        'asset_type',
        'asset_description',
        'building_condition',
        'certificate_type',
        'certificate_number',
        'land_area',
        'building_area',
        // Lokasi
        'address',
        'village',
        'district',
        'city',
        'province',
        'postal_code',
        // Debitur
        'debtor_name',
        // Lelang
        'auction_type',
        'auction_date',
        'auction_time',
        'auction_location',
        'auction_url',
        'organizer_name',
        // Harga
        'limit_price',
        'estimated_price',
        'deposit_amount',
        // Kontak
        'contact_name',
        'contact_phone',
        'contact_email',
        // SEO
        'meta_title',
        'meta_description',
        // Media
        'images',
        // Status
        'status',
        'is_featured',
        'view_count',
        'published_at',
    ];

    protected $casts = [
        'auction_date'       => 'date',
        'published_at'       => 'datetime',
        'images'             => 'array',
        'limit_price'        => 'decimal:2',
        'estimated_price'    => 'decimal:2',
        'deposit_amount'     => 'decimal:2',
        'land_area'          => 'decimal:2',
        'building_area'      => 'decimal:2',
        'is_featured'        => 'boolean',
        'view_count'         => 'integer',
    ];

    // ── Slug ──────────────────────────────────────────────────

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // ── Scopes ────────────────────────────────────────────────

    public function scopePublished(Builder $query): Builder
    {
        // published_at tidak diwajibkan: data lama bisa NULL.
        // Validasi publik cukup dari status.
        return $query->whereIn('status', ['published', 'registration_open', 'registration_closed', 'sold']);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereIn('status', ['published', 'registration_open', 'registration_closed']);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    // ── Accessors ─────────────────────────────────────────────

    public function getMainImageAttribute(): ?string
    {
        $images = $this->images;
        return !empty($images) ? $images[0] : null;
    }

    public function imageUrl(): ?string
    {
        $img = $this->main_image;
        return $img ? '/storage/' . $img : null;
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'draft'                => 'Draft',
            'published'            => 'Dipublikasi',
            'registration_open'    => 'Pendaftaran Dibuka',
            'registration_closed'  => 'Pendaftaran Ditutup',
            'sold'                 => 'Terjual',
            'cancelled'            => 'Dibatalkan',
            default                => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'draft'               => 'zinc',
            'published'           => 'blue',
            'registration_open'   => 'emerald',
            'registration_closed' => 'amber',
            'sold'                => 'purple',
            'cancelled'           => 'red',
            default               => 'zinc',
        };
    }

    public function getAssetTypeLabelAttribute(): string
    {
        return match ($this->asset_type) {
            'tanah'      => 'Tanah',
            'rumah'      => 'Rumah Tinggal',
            'ruko'       => 'Ruko/Rukan',
            'apartemen'  => 'Apartemen',
            'gedung'     => 'Gedung Komersial',
            'kendaraan'  => 'Kendaraan',
            'lainnya'    => 'Lainnya',
            default      => ucfirst($this->asset_type ?? ''),
        };
    }

    public function isRegistrationOpen(): bool
    {
        return $this->status === 'registration_open';
    }

    // ── Cache ─────────────────────────────────────────────────

    public static function getCachedStats(): array
    {
        return Cache::remember('auction_stats', 300, fn() => [
            // Total = jumlah yang benar-benar tampil di halaman lelang (publish, pendaftaran, selesai, terjual)
            'total'             => self::published()->count(),
            'registration_open' => self::where('status', 'registration_open')->count(),
            'sold'              => self::where('status', 'sold')->count(),
        ]);
    }

    public static function getCachedActiveCount(): int
    {
        return Cache::remember(
            'auction_active_count',
            300,
            fn() => self::where('status', 'registration_open')->count()
        );
    }

    protected static function booted(): void
    {
        $clearCache = function () {
            Cache::forget('auction_stats');
            Cache::forget('auction_active_count');
            Cache::forget('auctions_featured');
        };
        static::saved($clearCache);
        static::deleted($clearCache);
    }
}
