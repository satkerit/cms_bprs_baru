<?php

namespace App\Services\Seo;

use Illuminate\Support\Str;
use App\Models\CompanyInfo;

class SeoMeta
{
    private static $instance = null;

    protected $title;
    protected $description;
    protected $keywords;
    protected $image;
    protected $url;
    protected $type = 'website';
    protected $published_time;
    protected $modified_time;
    protected $section;
    protected $tags = [];
    protected $canonical;
    protected $schema = [];
    protected $robots;

    /**
     * Kanonikalkan URL saat ini ke host dari config('app.url')
     * agar canonical & og:url konsisten di semua host (www vs non-www).
     */
    private static function canonicalUrl(): string
    {
        $current = url()->current();
        $base = config('app.url');

        if (!$base) {
            return $current;
        }
        $baseHost = parse_url($base, PHP_URL_HOST);
        if (!$baseHost) {
            return $current;
        }
        $baseScheme = parse_url($base, PHP_URL_SCHEME) ?: 'https';
        $path = (string) parse_url($current, PHP_URL_PATH);

        return $baseScheme . '://' . $baseHost . $path;
    }

    private function __construct()
    {
        $company = CompanyInfo::getInfo();
        $this->title = config('app.name');
        $this->description = $company?->meta_description ?? 'BPRS Bangka Belitung - Mitra Keuangan Syariah Terpercaya';
        $this->keywords = $company?->meta_keywords ?? 'bank syariah, bprs, bangka belitung, keuangan syariah';
        $this->image = $company?->logo ? asset('storage/' . $company->logo) : asset('images/default-og.jpg');
        $this->url = static::canonicalUrl();
        $this->canonical = static::canonicalUrl();
        $this->robots = 'index, follow';
        try {
            $settings = \App\Models\SiteSetting::getSettings();
            if (!empty($settings->seo_robots_default)) {
                $this->robots = $settings->seo_robots_default;
            }
        } catch (\Throwable $e) {
            // keep default if settings unavailable (e.g. during migration)
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function setTitle($title, $appendSiteName = true)
    {
        $instance = self::getInstance();
        $siteName = config('app.name');
        $instance->title = $appendSiteName ? "{$title} - {$siteName}" : $title;
        return $instance;
    }

    public static function setDescription($description)
    {
        $instance = self::getInstance();
        $instance->description = Str::limit(strip_tags($description), 160);
        return $instance;
    }

    public static function setKeywords($keywords)
    {
        $instance = self::getInstance();
        $instance->keywords = is_array($keywords) ? implode(', ', $keywords) : $keywords;
        return $instance;
    }

    public static function setImage($image)
    {
        $instance = self::getInstance();
        $instance->image = $image;
        return $instance;
    }

    public static function setType($type)
    {
        $instance = self::getInstance();
        $instance->type = $type;
        return $instance;
    }

    public static function setPublishedTime($time)
    {
        $instance = self::getInstance();
        $instance->published_time = $time;
        return $instance;
    }

    public static function setModifiedTime($time)
    {
        $instance = self::getInstance();
        $instance->modified_time = $time;
        return $instance;
    }

    public static function setCanonical($url)
    {
        $instance = self::getInstance();
        $instance->canonical = $url;
        return $instance;
    }

    public static function setRobots($robots)
    {
        $instance = self::getInstance();
        $instance->robots = $robots;
        return $instance;
    }

    public static function addSchema($schemaData)
    {
        $instance = self::getInstance();
        $instance->schema[] = $schemaData;
        return $instance;
    }

    public static function generate()
    {
        $instance = self::getInstance();
        $company = CompanyInfo::getInfo();
        $siteName = config('app.name');

        // Base Schema (Organization/WebSite)
        $baseSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $company?->name ?? $siteName,
            'url' => url('/'),
            'logo' => $instance->image,
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => $company?->phone,
                'contactType' => 'customer service',
                'areaServed' => 'ID',
                'availableLanguage' => ['Indonesian', 'English']
            ]
        ];
        if ($company?->address) {
            $baseSchema['address'] = [
                '@type' => 'PostalAddress',
                'streetAddress' => $company->address,
                'addressCountry' => 'ID'
            ];
        }
        if ($company?->email) {
            $baseSchema['email'] = $company->email;
        }

        // Add Social Profiles to Schema if available
        if ($company && ($company->facebook || $company->instagram || $company->twitter)) {
            $sameAs = [];
            if ($company->facebook) $sameAs[] = $company->facebook;
            if ($company->instagram) $sameAs[] = $company->instagram;
            if ($company->twitter) $sameAs[] = $company->twitter;
            if (!empty($sameAs)) {
                $baseSchema['sameAs'] = $sameAs;
            }
        }

        // Organization schema on every page so search engines & AI crawlers identify the entity
        array_unshift($instance->schema, $baseSchema);

        // WebSite SearchAction schema hanya di homepage
        if (request()->is('/')) {
            $instance->schema[] = [
                '@context' => 'https://schema.org',
                '@type' => 'WebSite',
                'name' => $siteName,
                'url' => url('/'),
                'potentialAction' => [
                    '@type' => 'SearchAction',
                    'target' => url('/search?q={search_term_string}'),
                    'query-input' => 'required name=search_term_string'
                ]
            ];
        }

        return view('frontend.partials.seo', ['seo' => $instance]);
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        return null;
    }

    public function __isset($name)
    {
        return property_exists($this, $name) && isset($this->$name);
    }
}
