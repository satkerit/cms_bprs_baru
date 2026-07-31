<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    use Auditable;

    protected static function getAuditModelName(): string
    {
        return 'Pengaturan Website';
    }

    protected static function getAuditIdentifier(Model $model): string
    {
        return 'Site Settings';
    }

    protected $fillable = [
        'hero_slider_delay',
        'hero_slide_limit',
        'maintenance_mode',
        'maintenance_message',
        'maintenance_allowed_ips',
        'maintenance_end_time',
        'maintenance_pages',
        'upload_max_filesize',
        'post_max_size',
        'max_execution_time',
        'max_input_time',
        'memory_limit',
        'max_file_uploads',
        // ===== Feature-specific upload size limits (all in KB) =====
        'max_image_size_kb',
        'max_product_image_size_kb',
        'max_document_size_kb',
        'max_hero_image_size_kb',
        'max_auction_image_size_kb',

    ];

    protected $casts = [
        'hero_slider_delay' => 'integer',
        'hero_slide_limit' => 'integer',
        'maintenance_mode' => 'boolean',
        'maintenance_end_time' => 'datetime',
        'maintenance_pages' => 'array',
        'upload_max_filesize' => 'string',
        'post_max_size' => 'string',
        'max_execution_time' => 'integer',
        'max_input_time' => 'integer',
        'memory_limit' => 'string',
        'max_file_uploads' => 'integer',
        // ===== Feature-specific upload size limits =====
        'max_image_size_kb' => 'integer',
        'max_product_image_size_kb' => 'integer',
        'max_document_size_kb' => 'integer',
        'max_hero_image_size_kb' => 'integer',
        'max_auction_image_size_kb' => 'integer',

    ];

    /**
     * Available pages for partial maintenance
     */
    public static function getAvailablePages(): array
    {
        return [
            // Beranda
            'home' => ['name' => 'Beranda', 'route' => 'home', 'pattern' => '/'],

            // Tentang Kami (semua sub-menu)
            'about' => ['name' => 'Tentang Kami (Semua)', 'route' => 'about.*', 'pattern' => 'tentang-kami/*'],
            'about_company' => ['name' => 'Profil Perusahaan', 'route' => 'about.company', 'pattern' => 'tentang-kami/perusahaan'],
            'about_manajemen' => ['name' => 'Manajemen (Dewan & Direksi)', 'route' => 'about.manajemen', 'pattern' => 'tentang-kami/manajemen'],
            'about_struktur' => ['name' => 'Struktur Organisasi', 'route' => 'about.struktur', 'pattern' => 'tentang-kami/struktur-organisasi'],
            'about_offices' => ['name' => 'Kantor', 'route' => 'about.offices', 'pattern' => 'tentang-kami/kantor-cabang'],

            // Produk & Layanan (semua sub-menu)
            'products' => ['name' => 'Produk & Layanan (Semua)', 'route' => 'products.*', 'pattern' => 'produk/*'],
            'products_simpanan' => ['name' => 'Simpanan Syariah', 'route' => 'products.simpanan-syariah', 'pattern' => 'produk/simpanan-syariah'],
            'products_pembiayaan' => ['name' => 'Pembiayaan Syariah', 'route' => 'products.pembiayaan-syariah', 'pattern' => 'produk/pembiayaan-syariah'],
            'products_deposito' => ['name' => 'Deposito Syariah', 'route' => 'products.deposito-syariah', 'pattern' => 'produk/deposito-syariah'],
            'products_kas_keliling' => ['name' => 'Kas Keliling', 'route' => 'products.kas-keliling', 'pattern' => 'produk/kas-keliling'],

            // Lelang
            'auctions' => ['name' => 'Lelang', 'route' => 'auctions.*', 'pattern' => 'lelang/*'],

            // Berita
            'news' => ['name' => 'Berita', 'route' => 'news.*', 'pattern' => 'berita/*'],

            // Informasi Umum / Laporan (semua sub-menu)
            'reports' => ['name' => 'Informasi Umum (Semua)', 'route' => 'reports.*', 'pattern' => 'informasi-umum/*'],
            'reports_keuangan' => ['name' => 'Laporan Keuangan Publikasi', 'route' => 'reports.keuangan-publikasi', 'pattern' => 'informasi-umum/laporan-keuangan-publikasi'],
            'reports_tata_kelola' => ['name' => 'Laporan Tata Kelola', 'route' => 'reports.tata-kelola', 'pattern' => 'informasi-umum/laporan-tata-kelola'],
            'reports_tahunan' => ['name' => 'Laporan Tahunan', 'route' => 'reports.tahunan', 'pattern' => 'informasi-umum/laporan-tahunan'],
            'reports_berkelanjutan' => ['name' => 'Laporan Tahunan Berkelanjutan', 'route' => 'reports.tahunan-berkelanjutan', 'pattern' => 'informasi-umum/laporan-tahunan-berkelanjutan'],

            // Karir
            'careers' => ['name' => 'Karir', 'route' => 'careers.*', 'pattern' => 'karir/*'],

            // Halaman Statis
            'contact' => ['name' => 'Hubungi Kami', 'route' => 'contact', 'pattern' => 'hubungi-kami'],
            'whistleblowing' => ['name' => 'Whistleblowing', 'route' => 'whistleblowing', 'pattern' => 'whistleblowing'],
            'pengaduan_nasabah' => ['name' => 'Pengaduan Nasabah', 'route' => 'pengaduan-nasabah', 'pattern' => 'pengaduan-nasabah'],
            'download_logo' => ['name' => 'Download Logo', 'route' => 'download-logo', 'pattern' => 'download-logo'],

            // Simulasi Pembiayaan
            'financing_simulation' => ['name' => 'Simulasi Pembiayaan', 'route' => 'financing-simulation', 'pattern' => 'simulasi-pembiayaan'],
        ];
    }

    public static function getSettings(): self
    {
        try {
            return Cache::remember('site_settings', 3600, function () {
                return self::first() ?? self::create([
                    'hero_slider_delay' => 5000,
                    'hero_slide_limit' => 5,
                    'maintenance_mode' => false,
                    'maintenance_message' => 'Website sedang dalam pemeliharaan untuk peningkatan layanan. Silakan kembali beberapa saat lagi.',
                    'upload_max_filesize' => '100M',
                    'post_max_size' => '100M',
                    'max_execution_time' => 300,
                    'max_input_time' => 300,
                    'memory_limit' => '512M',
                    'max_file_uploads' => 20,
                    'max_image_size_kb' => 2048,
                    'max_product_image_size_kb' => 5120,
                    'max_document_size_kb' => 15360,
                    'max_hero_image_size_kb' => 5120,
                    'max_auction_image_size_kb' => 5120,
                    'report_keuangan_publikasi_title' => 'Laporan Keuangan Publikasi',
                    'report_keuangan_publikasi_subtitle' => 'Laporan keuangan publikasi BPR Syariah',
                    'report_tata_kelola_title' => 'Laporan Tata Kelola',
                    'report_tata_kelola_subtitle' => 'Laporan tata kelola perusahaan',
                    'report_tahunan_title' => 'Laporan Tahunan',
                    'report_tahunan_subtitle' => 'Laporan tahunan BPR Syariah',
                    'report_tahunan_berkelanjutan_title' => 'Laporan Tahunan Berkelanjutan',
                    'report_tahunan_berkelanjutan_subtitle' => 'Laporan tahunan berkelanjutan BPR Syariah',
                    'report_keuangan_publikasi_description' => 'Laporan Keuangan Publikasi merupakan laporan berkala yang diterbitkan oleh BPRS Bangka Belitung sebagai bentuk transparansi dan akuntabilitas kepada publik. Laporan ini menyajikan informasi mengenai posisi keuangan, kinerja operasional, arus kas, serta rasio-rasio keuangan penting yang telah diaudit oleh auditor eksternal. Laporan Keuangan Publikasi diterbitkan setiap triwulan (Q1, Q2, Q3) dan tahunan, sesuai dengan ketentuan Otoritas Jasa Keuangan (OJK) yang berlaku.',
                    'report_tata_kelola_description' => 'Laporan Tata Kelola (Good Corporate Governance/GCG) merupakan laporan yang menyajikan penerapan prinsip-prinsip tata kelola perusahaan yang baik di BPRS Bangka Belitung. Laporan ini mencakup struktur dan mekanisme tata kelola, pelaksanaan tugas dan tanggung jawab Dewan Komisaris dan Direksi, pengelolaan risiko, sistem pengendalian internal, serta kepatuhan terhadap peraturan perundang-undangan yang berlaku. Laporan ini disusun secara periodik sebagai wujud komitmen perusahaan dalam menerapkan GCG secara konsisten dan berkelanjutan.',
                    'report_tahunan_description' => 'Laporan Tahunan (Annual Report) merupakan laporan komprehensif yang diterbitkan setiap tahun oleh BPRS Bangka Belitung. Laporan ini menyajikan gambaran menyeluruh mengenai kinerja perusahaan sepanjang tahun buku, termasuk laporan keuangan tahunan yang telah diaudit, laporan pelaksanaan tata kelola, profil perusahaan, analisis dan pembahasan manajemen, serta informasi penting lainnya. Laporan Tahunan menjadi sumber informasi utama bagi pemangku kepentingan untuk mengevaluasi kinerja dan prospek perusahaan secara keseluruhan.',
                    'report_tahunan_berkelanjutan_description' => 'Laporan Tahunan Berkelanjutan (Sustainability Report) merupakan laporan yang menyajikan informasi mengenai kinerja ekonomi, sosial, dan lingkungan (Environmental, Social, and Governance/ESG) dari BPRS Bangka Belitung. Laporan ini menggambarkan komitmen perusahaan dalam menerapkan prinsip-prinsip pembangunan berkelanjutan, termasuk pengelolaan dampak lingkungan, tanggung jawab sosial perusahaan, serta kontribusi terhadap pemberdayaan masyarakat dan ekonomi lokal. Laporan ini disusun sesuai dengan standar pelaporan keberlanjutan yang berlaku.',
                ]);
            });
        } catch (\Exception $e) {
            // Return a dummy model instance if table doesn't exist
            $settings = new self();
            $settings->hero_slider_delay = 5000;
            $settings->hero_slide_limit = 5;
            $settings->maintenance_mode = false;
            $settings->upload_max_filesize = '100M';
            $settings->post_max_size = '100M';
            $settings->max_execution_time = 300;
            $settings->max_input_time = 300;
            $settings->memory_limit = '512M';
            $settings->max_file_uploads = 20;
            $settings->max_image_size_kb = 2048;
            $settings->max_product_image_size_kb = 5120;
            $settings->max_document_size_kb = 15360;
            $settings->max_hero_image_size_kb = 5120;
            $settings->max_auction_image_size_kb = 5120;
            $settings->report_keuangan_publikasi_title = 'Laporan Keuangan Publikasi';
            $settings->report_keuangan_publikasi_subtitle = 'Laporan keuangan publikasi BPR Syariah';
            $settings->report_tata_kelola_title = 'Laporan Tata Kelola';
            $settings->report_tata_kelola_subtitle = 'Laporan tata kelola perusahaan';
            $settings->report_tahunan_title = 'Laporan Tahunan';
            $settings->report_tahunan_subtitle = 'Laporan tahunan BPR Syariah';
            $settings->report_tahunan_berkelanjutan_title = 'Laporan Tahunan Berkelanjutan';
            $settings->report_tahunan_berkelanjutan_subtitle = 'Laporan tahunan berkelanjutan BPR Syariah';
            $settings->report_keuangan_publikasi_description = 'Laporan Keuangan Publikasi merupakan laporan berkala yang diterbitkan oleh BPRS Bangka Belitung sebagai bentuk transparansi dan akuntabilitas kepada publik.';
            $settings->report_tata_kelola_description = 'Laporan Tata Kelola (Good Corporate Governance/GCG) merupakan laporan yang menyajikan penerapan prinsip-prinsip tata kelola perusahaan yang baik di BPRS Bangka Belitung.';
            $settings->report_tahunan_description = 'Laporan Tahunan (Annual Report) merupakan laporan komprehensif yang diterbitkan setiap tahun oleh BPRS Bangka Belitung.';
            $settings->report_tahunan_berkelanjutan_description = 'Laporan Tahunan Berkelanjutan (Sustainability Report) merupakan laporan yang menyajikan informasi mengenai kinerja ekonomi, sosial, dan lingkungan (ESG) dari BPRS Bangka Belitung.';
            return $settings;
        }
    }

    /**
     * Get fresh settings without cache
     */
    public static function getFreshSettings(): self
    {
        self::clearCache();
        return self::first() ?? self::create([
            'hero_slider_delay' => 5000,
            'hero_slide_limit' => 5,
            'maintenance_mode' => false,
            'maintenance_message' => 'Website sedang dalam pemeliharaan untuk peningkatan layanan. Silakan kembali beberapa saat lagi.',
            'maintenance_pages' => [],
            'upload_max_filesize' => '100M',
            'post_max_size' => '100M',
            'max_execution_time' => 300,
            'max_input_time' => 300,
            'memory_limit' => '512M',
            'max_file_uploads' => 20,
            'max_image_size_kb' => 2048,
            'max_product_image_size_kb' => 5120,
            'max_document_size_kb' => 15360,
            'max_hero_image_size_kb' => 5120,
            'max_auction_image_size_kb' => 5120,
            'report_keuangan_publikasi_title' => 'Laporan Keuangan Publikasi',
            'report_keuangan_publikasi_subtitle' => 'Laporan keuangan publikasi BPR Syariah',
            'report_tata_kelola_title' => 'Laporan Tata Kelola',
            'report_tata_kelola_subtitle' => 'Laporan tata kelola perusahaan',
            'report_tahunan_title' => 'Laporan Tahunan',
            'report_tahunan_subtitle' => 'Laporan tahunan BPR Syariah',
            'report_tahunan_berkelanjutan_title' => 'Laporan Tahunan Berkelanjutan',
            'report_tahunan_berkelanjutan_subtitle' => 'Laporan tahunan berkelanjutan BPR Syariah',
        ]);
    }

    public function getAllowedIpsArray(): array
    {
        return array_filter(array_map('trim', explode("\n", $this->maintenance_allowed_ips ?? '')));
    }

    public function isIpAllowed(?string $ip): bool
    {
        if ($ip === null || $ip === '') {
            return false;
        }

        $allowedIps = $this->getAllowedIpsArray();

        if (empty($allowedIps)) {
            return false;
        }

        return in_array($ip, $allowedIps);
    }

    public static function isMaintenanceMode(): bool
    {
        $settings = self::getSettings();

        if (!$settings->maintenance_mode) {
            return false;
        }

        // Check if maintenance end time has passed
        if ($settings->maintenance_end_time && $settings->maintenance_end_time->isPast()) {
            $settings->update(['maintenance_mode' => false]);
            self::clearCache();
            return false;
        }

        return true;
    }

    /**
     * Check if a specific page is under maintenance
     */
    public static function isPageUnderMaintenance(string $path): bool
    {
        $settings = self::getSettings();
        $maintenancePages = $settings->maintenance_pages ?? [];

        if (empty($maintenancePages)) {
            return false;
        }

        $availablePages = self::getAvailablePages();

        foreach ($maintenancePages as $pageKey) {
            if (!isset($availablePages[$pageKey])) {
                continue;
            }

            $page = $availablePages[$pageKey];
            $pattern = $page['pattern'];

            // Exact match for home
            if ($pattern === '/' && ($path === '/' || $path === '')) {
                return true;
            }

            // Pattern match with wildcard
            if (str_ends_with($pattern, '*')) {
                $prefix = rtrim($pattern, '/*');
                if (str_starts_with(ltrim($path, '/'), $prefix)) {
                    return true;
                }
            } else {
                // Exact match
                $cleanPath = ltrim($path, '/');
                if ($cleanPath === $pattern) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Get the page key from path
     */
    public static function getPageKeyFromPath(string $path): ?string
    {
        $settings = self::getSettings();
        $maintenancePages = $settings->maintenance_pages ?? [];
        $availablePages = self::getAvailablePages();

        foreach ($maintenancePages as $pageKey) {
            if (!isset($availablePages[$pageKey])) {
                continue;
            }

            $page = $availablePages[$pageKey];
            $pattern = $page['pattern'];

            if ($pattern === '/' && ($path === '/' || $path === '')) {
                return $pageKey;
            }

            if (str_ends_with($pattern, '*')) {
                $prefix = rtrim($pattern, '/*');
                if (str_starts_with(ltrim($path, '/'), $prefix)) {
                    return $pageKey;
                }
            } else {
                $cleanPath = ltrim($path, '/');
                if ($cleanPath === $pattern) {
                    return $pageKey;
                }
            }
        }

        return null;
    }

    /**
     * Get message for partial maintenance
     */
    public function getPageMaintenanceMessage(string $pageKey): string
    {
        $availablePages = self::getAvailablePages();
        $pageName = $availablePages[$pageKey]['name'] ?? 'Halaman ini';

        return "Halaman {$pageName} sedang dalam pemeliharaan. Silakan kembali beberapa saat lagi.";
    }

    public static function clearCache(): void
    {
        Cache::forget('site_settings');
        // Force clear jika menggunakan file/database cache
        Cache::flush(); // Uncomment jika perlu clear semua cache
    }

    protected static function booted(): void
    {
        static::saved(function () {
            self::clearCache();
        });

        static::updated(function () {
            self::clearCache();
        });

        static::creating(function ($model) {
            // Set default values if not present
            $defaults = [
                'hero_slider_delay' => 5000,
                'hero_slide_limit' => 5,
                'maintenance_mode' => false,
                'maintenance_message' => 'Website sedang dalam pemeliharaan untuk peningkatan layanan. Silakan kembali beberapa saat lagi.',
                'upload_max_filesize' => '100M',
                'post_max_size' => '100M',
                'max_execution_time' => 300,
                'max_input_time' => 300,
                'memory_limit' => '512M',
                'max_file_uploads' => 20,
                'max_image_size_kb' => 2048,
                'max_product_image_size_kb' => 5120,
                'max_document_size_kb' => 15360,
                'max_hero_image_size_kb' => 5120,
                'max_auction_image_size_kb' => 5120,
                'report_keuangan_publikasi_title' => 'Laporan Keuangan Publikasi',
                'report_keuangan_publikasi_subtitle' => 'Laporan keuangan publikasi BPR Syariah',
                'report_tata_kelola_title' => 'Laporan Tata Kelola',
                'report_tata_kelola_subtitle' => 'Laporan tata kelola perusahaan',
                'report_tahunan_title' => 'Laporan Tahunan',
                'report_tahunan_subtitle' => 'Laporan tahunan BPR Syariah',
                'report_tahunan_berkelanjutan_title' => 'Laporan Tahunan Berkelanjutan',
                'report_tahunan_berkelanjutan_subtitle' => 'Laporan tahunan berkelanjutan BPR Syariah',
                'report_keuangan_publikasi_description' => 'Laporan Keuangan Publikasi merupakan laporan berkala yang diterbitkan oleh BPRS Bangka Belitung sebagai bentuk transparansi dan akuntabilitas kepada publik. Laporan ini menyajikan informasi mengenai posisi keuangan, kinerja operasional, arus kas, serta rasio-rasio keuangan penting yang telah diaudit oleh auditor eksternal.',
                'report_tata_kelola_description' => 'Laporan Tata Kelola (Good Corporate Governance/GCG) merupakan laporan yang menyajikan penerapan prinsip-prinsip tata kelola perusahaan yang baik di BPRS Bangka Belitung. Laporan ini mencakup struktur dan mekanisme tata kelola, pelaksanaan tugas dan tanggung jawab Dewan Komisaris dan Direksi, pengelolaan risiko, sistem pengendalian internal, serta kepatuhan terhadap peraturan perundang-undangan yang berlaku.',
                'report_tahunan_description' => 'Laporan Tahunan (Annual Report) merupakan laporan komprehensif yang diterbitkan setiap tahun oleh BPRS Bangka Belitung. Laporan ini menyajikan gambaran menyeluruh mengenai kinerja perusahaan sepanjang tahun buku, termasuk laporan keuangan tahunan yang telah diaudit, laporan pelaksanaan tata kelola, profil perusahaan, analisis dan pembahasan manajemen, serta informasi penting lainnya.',
                'report_tahunan_berkelanjutan_description' => 'Laporan Tahunan Berkelanjutan (Sustainability Report) merupakan laporan yang menyajikan informasi mengenai kinerja ekonomi, sosial, dan lingkungan (Environmental, Social, and Governance/ESG) dari BPRS Bangka Belitung. Laporan ini menggambarkan komitmen perusahaan dalam menerapkan prinsip-prinsip pembangunan berkelanjutan, termasuk pengelolaan dampak lingkungan, tanggung jawab sosial perusahaan, serta kontribusi terhadap pemberdayaan masyarakat dan ekonomi lokal.',
            ];

            foreach ($defaults as $key => $value) {
                if (!isset($model->$key)) {
                    $model->$key = $value;
                }
            }
        });
    }
}
