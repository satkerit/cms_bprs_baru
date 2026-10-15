<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Spatie\ResponseCache\Facades\ResponseCache;

class CompanyInfo extends Model
{
    use Auditable;

    protected static function getAuditModelName(): string
    {
        return 'Info Perusahaan';
    }

    protected static function getAuditIdentifier(\Illuminate\Database\Eloquent\Model $model): string
    {
        return $model->name ?? 'Company Info';
    }

    protected $fillable = [
        // Basic Information
        'name',
        'tagline',
        'description',
        'established_year',

        // Contact Information
        'address',
        'phone',
        'fax',
        'whatsapp',
        'email',
        'email_contact',
        'email_complaint',
        'email_whistleblowing',
        'website',

        // Visual Assets
        'logo',
        'logo_footer',
        'logo_footer_remove_bg',
        'logo_footer_opacity',
        'favicon',
        'profile_image',
        'organization_structure',

        // Company Profile
        'vision',
        'mission',
        'history',

        // Statistics
        'stat_years_experience',
        'stat_branch_offices',
        'stat_total_assets',
        'stat_cash_offices',
        'stat_mobile_cash_offices',
        'legacy_visitor_count',

        // Social Media
        'facebook',
        'instagram',
        'twitter',
        'youtube',
        'linkedin',
        'tiktok',

        // Regulatory Information
        'ojk_license',
        'ojk_tagline',
        'lps_tagline',
        'lps_guarantee_amount',

        // SEO & Footer
        'footer_description',
        'meta_description',
        'meta_keywords',

        // Operational Hours
        'operational_hours',
    ];

    protected $casts = [
        'established_year' => 'integer',
        'stat_years_experience' => 'integer',
        'stat_branch_offices' => 'integer',
        'stat_cash_offices' => 'integer',
        'stat_mobile_cash_offices' => 'integer',
        'legacy_visitor_count' => 'integer',
        'logo_footer_remove_bg' => 'boolean',
        'logo_footer_opacity' => 'integer',
        'operational_hours' => 'array',
    ];

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = \App\Helpers\HtmlSanitizer::clean($value);
    }

    public function setVisionAttribute($value)
    {
        $this->attributes['vision'] = \App\Helpers\HtmlSanitizer::clean($value);
    }

    public function setMissionAttribute($value)
    {
        $this->attributes['mission'] = \App\Helpers\HtmlSanitizer::clean($value);
    }

    public function setHistoryAttribute($value)
    {
        $this->attributes['history'] = \App\Helpers\HtmlSanitizer::clean($value);
    }

    public function setFooterDescriptionAttribute($value)
    {
        $this->attributes['footer_description'] = \App\Helpers\HtmlSanitizer::clean($value);
    }

    /**
     * Get cached company info
     */
    public static function getInfo(): ?self
    {
        return Cache::remember('company_info', 86400, fn() => self::first());
    }

    /**
     * Clear company info cache
     */
    public static function clearCache(): void
    {
        Cache::forget(Config::get('cache-keys.company_info'));
    }

    /**
     * Boot method to clear cache on save
     */
    protected static function booted(): void
    {
        $clearCache = function () {
            self::clearCache();
            ResponseCache::clear();
        };

        static::saved($clearCache);
        static::deleted($clearCache);
    }

    /**
     * Get logo URL with fallback
     */
    protected function logoUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->logo ? Storage::url($this->logo) : null,
        );
    }

    /**
     * Get logo footer URL with fallback
     */
    protected function logoFooterUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->logo_footer ? Storage::url($this->logo_footer) : null,
        );
    }

    /**
     * Get favicon URL with fallback
     */
    protected function faviconUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->favicon ? Storage::url($this->favicon) : null,
        );
    }

    /**
     * Get profile image URL with fallback
     */
    protected function profileImageUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->profile_image ? Storage::url($this->profile_image) : null,
        );
    }

    /**
     * Get organization structure URL with fallback
     */
    protected function organizationStructureUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->organization_structure ? Storage::url($this->organization_structure) : null,
        );
    }

    /**
     * Get formatted operational hours
     */
    protected function formattedOperationalHours(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->operational_hours) {
                    return [];
                }

                $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                $dayNames = [
                    'monday' => 'Senin',
                    'tuesday' => 'Selasa',
                    'wednesday' => 'Rabu',
                    'thursday' => 'Kamis',
                    'friday' => 'Jumat',
                    'saturday' => 'Sabtu',
                    'sunday' => 'Minggu'
                ];

                $formatted = [];
                foreach ($days as $day) {
                    if (isset($this->operational_hours[$day])) {
                        $dayData = $this->operational_hours[$day];
                        $formatted[$day] = [
                            'name' => $dayNames[$day],
                            'active' => $dayData['active'] ?? false,
                            'open' => $dayData['open'] ?? null,
                            'close' => $dayData['close'] ?? null,
                            'has_break' => $dayData['has_break'] ?? false,
                            'break_start' => $dayData['break_start'] ?? null,
                            'break_end' => $dayData['break_end'] ?? null,
                        ];
                    }
                }

                return $formatted;
            }
        );
    }

    /**
     * Jam operasional ternormalisasi (7 hari berurutan: Senin–Minggu).
     * Sumber tunggal untuk halaman detail kantor & kontak.
     * Mendukung format: indexed+day (form admin), keyed nama hari, keyed string lama,
     * rentang gabungan ("Senin - Jumat"), dan "Setiap Hari".
     */
    public function operationalSchedule(): array
    {
        $canonicalDays = ['Senin', 'Selasa', 'Rabu', 'Kamis', "Jum'at", 'Sabtu', 'Minggu'];
        $raw = is_array($this->operational_hours) ? $this->operational_hours : [];

        $hoursMap = [];
        foreach ($raw as $key => $value) {
            if ($key === 'notes') {
                continue;
            }
            if (is_array($value)) {
                if (isset($value['day'])) {
                    $entry = $value;
                } elseif (is_numeric($key)) {
                    $entry = array_merge($value, ['day' => $canonicalDays[(int) $key] ?? (string) $key]);
                } else {
                    $entry = array_merge(['day' => (string) $key], $value);
                }
            } elseif (is_string($value) && is_string($key)) {
                $text = trim($value);
                $closed = in_array(strtolower($text), ['tutup', 'libur', 'closed', 'off', '-', '', '0'], true);
                $open = $close = null;
                if (!$closed && preg_match('/(\d{1,2}:\d{2})\s*[-–—]\s*(\d{1,2}:\d{2})/', $text, $m)) {
                    $open = $m[1];
                    $close = $m[2];
                }
                $entry = ['day' => (string) $key, 'active' => !$closed, 'open' => $open, 'close' => $close];
            } else {
                continue;
            }
            $hoursMap[(string) ($entry['day'] ?? '')] = $entry;
        }

        $normDay = fn($s) => mb_strtolower(str_replace(["'", '’'], '', trim((string) $s)));
        $expanded = [];
        foreach ($hoursMap as $label => $entry) {
            $normLabel = $normDay($label);
            $matched = false;
            foreach ($canonicalDays as $i => $startDay) {
                for ($j = $i; $j < count($canonicalDays); $j++) {
                    $endDay = $canonicalDays[$j];
                    $pattern = '/^' . preg_quote($normDay($startDay), '/') . '.*' . preg_quote($normDay($endDay), '/') . '$/';
                    if (preg_match($pattern, $normLabel)) {
                        for ($k = $i; $k <= $j; $k++) {
                            $expanded[$canonicalDays[$k]] = array_merge($entry, ['day' => $canonicalDays[$k]]);
                        }
                        $matched = true;
                        break 2;
                    }
                }
            }
            if (!$matched && $normLabel === 'setiaphari') {
                foreach ($canonicalDays as $day) {
                    $expanded[$day] = array_merge($entry, ['day' => $day]);
                }
                $matched = true;
            }
            if (!$matched) {
                $single = false;
                foreach ($canonicalDays as $day) {
                    if ($normDay($label) === $normDay($day)) {
                        $expanded[$day] = array_merge($entry, ['day' => $day]);
                        $single = true;
                        break;
                    }
                }
                if (!$single) {
                    $expanded[$label] = $entry;
                }
            }
        }
        $hoursMap = $expanded;

        $hasAnyData = count($hoursMap) > 0;
        $schedule = [];
        foreach ($canonicalDays as $day) {
            if (isset($hoursMap[$day])) {
                $schedule[] = $hoursMap[$day];
            } else {
                $defaultActive = !$hasAnyData && in_array($day, ['Senin', 'Selasa', 'Rabu', 'Kamis', "Jum'at"], true);
                $schedule[] = [
                    'day' => $day,
                    'active' => $defaultActive,
                    'open' => $defaultActive ? '08:00' : null,
                    'close' => $defaultActive ? '15:00' : null,
                ];
            }
        }

        return array_merge($schedule, array_filter(
            $hoursMap,
            fn($entry, $label) => !in_array($label, $canonicalDays, true),
            ARRAY_FILTER_USE_BOTH
        ));
    }

    /**
     * Ringkasan singkat jam operasional untuk kartu (mis. "Sen—Jum 08:00—15:00").
     */
    public function operationalHoursSummary(): string
    {
        $active = array_values(array_filter($this->operationalSchedule(), fn($e) => !empty($e['active'])));
        if (empty($active)) {
            return 'Tutup';
        }

        $first = $active[0];
        $last = end($active);
        $range = $first['day'] === $last['day'] ? $first['day'] : $first['day'] . '—' . $last['day'];
        $times = ($first['open'] && $first['close']) ? " {$first['open']}—{$first['close']}" : '';

        return $range . $times;
    }

    /**
     * Get social media links
     */
    protected function socialMediaLinks(): Attribute
    {
        return Attribute::make(
            get: function () {
                return [
                    'facebook' => $this->facebook,
                    'instagram' => $this->instagram,
                    'twitter' => $this->twitter,
                    'youtube' => $this->youtube,
                    'linkedin' => $this->linkedin,
                    'tiktok' => $this->tiktok,
                ];
            }
        );
    }

    /**
     * Get company statistics
     */
    protected function statistics(): Attribute
    {
        return Attribute::make(
            get: function () {
                return [
                    'years_experience' => $this->stat_years_experience,
                    'branch_offices' => $this->stat_branch_offices,
                    'total_assets' => $this->stat_total_assets,
                    'cash_offices' => $this->stat_cash_offices,
                    'mobile_cash_offices' => $this->stat_mobile_cash_offices,
                    'legacy_visitor_count' => $this->legacy_visitor_count,
                ];
            }
        );
    }

    /**
     * Check if company has complete profile
     */
    protected function hasCompleteProfile(): Attribute
    {
        return Attribute::make(
            get: function () {
                $required = ['name', 'address', 'phone', 'email', 'description'];
                foreach ($required as $field) {
                    if (empty($this->$field)) {
                        return false;
                    }
                }
                return true;
            }
        );
    }
}
