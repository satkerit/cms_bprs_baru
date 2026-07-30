# CMS Company Profile BPR Syariah

Sistem Content Management System (CMS) modern untuk mengelola Company Profile Bank Pembiayaan Rakyat (BPR) Syariah. Dibangun dengan Laravel — fokus pada keamanan enterprise, performa, dan kemudahan manajemen konten melalui Admin Dashboard.

## Fitur Utama

### Manajemen Konten (CMS)

- **Berita & Artikel** — Publikasi berita dengan galeri gambar multiple, kategori, status publish/draft.
- **Produk & Layanan** — Informasi produk simpanan, pembiayaan, dan deposito syariah dengan gambar, brosur, fitur, keunggulan, persyaratan.
- **Simulasi Pembiayaan** — Kalkulator pembiayaan syariah interaktif dengan formula margin & profit sharing.
- **Hero Slider** — Banner halaman utama dengan teks, gambar, delay, dan pengaturan dimensi slider.
- **Karier & Lowongan** — Publikasi lowongan pekerjaan dengan deskripsi, persyaratan, batas waktu.
- **Laporan Perusahaan** — Manajemen laporan tahunan, keuangan, tata kelola, dan ESG dengan preview & download.
- **Brosur (Brochure Library)** — Upload brosur/PDF, reusable di modul Product.
- **Why Choose Us** — Alasan memilih perusahaan (ikon, judul, deskripsi, urutan tampil).

### Manajemen Operasional

- **Kas Keliling** — Jadwal layanan kas keliling per area dengan PIC, fasilitas, jam operasional, export CSV, cek overlap jadwal.
- **Lelang (Auction)** — Manajemen barang lelang dengan multi-image, status (draft/published/closed), featured auction, bulk actions, filter asset type/city/status.
- **Kantor & Cabang** — Data kantor pusat, cabang, dan kantor kas dengan foto, alamat, peta interaktif (Leaflet).
- **Dewan & Direksi** — Profil dewan komisaris, direksi, dan pengawas syariah dengan foto, jabatan, biografi.

### Layanan Pengaduan

- **Pengaduan Nasabah** — Ticketing system (prioritas, kategori, SLA, workflow pending→resolved→closed), assignment handler, notifikasi email via queue.
- **Whistleblowing (WBS)** — Sistem pengaduan internal anonim dengan format tiket `WBS-YYYYMMDD-xxxxxx`, attachment, status investigasi.

### Keamanan & Infrastruktur (Enterprise Grade)

- **Security Middleware** — DDoS protection (`DdosProtection`), deteksi aktivitas mencurigakan (`DetectSuspiciousActivity`), blocker IP otomatis (`BlockSuspiciousRequests`), proteksi sesi aman.
- **Security Headers & CSP** — Header keamanan untuk mencegah XSS/Clickjacking. Content Security Policy (CSP) nonce-based kompatibel dengan Alpine.js & Livewire.
- **File Scanner (Anti-Malware)** — Multi-layer scanning: ClamAV socket/network, pattern-based detection (ELF/PE/Mach-O, MIME mismatch, PHP code in non-PHP, PDF JavaScript macro), karantina file terindikasi berbahaya.
- **Security Monitor** — Dashboard ancaman dengan stats, grafik 7-hari, IP blocking (temporary/permanent), export CSV security logs.
- **Audit Trail** — Logging semua perubahan data (create/update/delete) per model, filter by action/user/model_type/date range.
- **Spatie Roles & Permissions** — Kontrol hak akses multi-level. Menu admin visibility per role.
- **Rate Limiting** — Terpisah untuk web, admin, login, password reset, download. Konfigurasi via dashboard.
- **Password Policy** — Password kuat, histori cegah penggunaan ulang password lama.

### Optimasi & Performa

- **Responsive Images** — Upload otomatis generate multiple formats (AVIF, WebP, JPEG) di breakpoints: 480px, 768px, 1024px, 1280px, 1920px.
- **Spatie Response Cache** — Caching respons cepat untuk production.
- **Optimasi Upload** — Validasi dinamis untuk mengontrol memori dan ukuran unggahan per fitur (gambar umum, gambar produk, hero slider, lelang, dokumen).
- **Image Standards** — Validasi rasio 4:3 untuk gambar produk, resolusi min 800×600px, maks 3840×2880px, ukuran maks 2MB.
- **Dynamic PHP ini Override** — Middleware `OptimizeFileUpload` set memory_limit, max_execution_time, upload_max_filesize sesuai konfigurasi SiteSetting.

### Lainnya

- **SEO & Structured Data** — Open Graph, JSON-LD Schema.org (Organization, WebSite dengan SearchAction/Sitelinks Search Box).
- **Sitemap XML** — Generate dinamis mencakup static pages, berita, lelang, produk, karier, kantor.
- **Visitor Analytics** — Tracking IP, country, ISP, device, browser, referrer. Dashboard dengan grafik harian, top pages, stats per device/browser/platform/country.
- **Database Backup** — Backup via PDO (full/structure_only/data_only), kompresi gzip, metadata header, download.
- **Storage Manager** — File browser dari admin panel, upload dengan scanning, rename, delete, image picker untuk editor.
- **Logo Download** — Download logo perusahaan dalam format PNG/JPG/SVG/WebP dengan konversi otomatis via GD.
- **Jadwal Sholat** — Floating widget dengan data real-time dari Aladhan API, countdown next prayer, auto-hide on hover-out.
- **Email Settings** — Konfigurasi SMTP/Mailgun/SES/Postmark dari dashboard, test email, encrypted credentials.
- **Composer Update via Admin** — Update package dari dashboard (Super Admin only), auto-detect composer path, output streaming.
- **Financing Calculator** — Simulasi pembiayaan syariah dengan formula margin dan profit sharing.

## Tech Stack

- **Backend:** PHP 8.3+ | Laravel 13.x
- **Frontend:** Blade | Livewire 3.x | Alpine.js 3.x | Tailwind CSS 3.4
- **Database:** MySQL / SQLite (tergantung environment)
- **Image Processing:** Intervention Image (GD Driver)
- **Library Utama:**
  - Spatie Permission (roles & permissions)
  - Spatie ResponseCache (full-page cache)
  - Spatie Sluggable (auto-slug)
  - SweetAlert2 (notifikasi)
  - Swiper (slider)
  - Leaflet (peta interaktif)
  - Summernote (WYSIWYG)
- **CI/CD:** GitHub Actions (deploy otomatis ke server production)

## Persyaratan Sistem

- PHP >= 8.3
- Composer >= 2.0
- Node.js & NPM
- Ekstensi PHP: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML, GD, MySQLi

## Panduan Instalasi (Development)

1. **Clone repositori**

   ```bash
   git clone https://github.com/satkerit/companyprofle.git
   cd companyprofle
   ```

2. **Jalankan setup**

   ```bash
   composer setup
   ```

   (Menjalankan `composer install`, membuat `.env`, `key:generate`, `migrate --seed`, `npm install`, `npm run build`)

3. **Konfigurasi `.env`**

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Jalankan server lokal**

   ```bash
   composer dev
   ```

   Kunjungi `http://localhost:8000`

## Konfigurasi Production

### Upload Limits

Batas upload dapat diatur di Dashboard → Pengaturan Website. Batas maksimum server:

**Nginx:**
```nginx
client_max_body_size 50M;
```

**Apache:** Aplikasi otomatis membaca limit dari `public/.htaccess` — tidak perlu konfigurasi tambahan.

### Optimasi Cache

```bash
php artisan optimize
php artisan view:cache
```

## Content Security Policy (CSP)

CSP nonce-based yang kompatibel dengan Alpine.js dan Livewire.

### Kebijakan

| Directive | Kebijakan |
|---|---|
| `default-src` | `'self'` |
| `script-src` | Nonce-based + `'unsafe-eval'` (Alpine.js) + CDN terpercaya |
| `style-src` | `'unsafe-inline'` + Google Fonts, Bun CDN |
| `img-src` | `data:`, `https:`, `blob:` |
| `font-src` | Google Fonts, Bunny CDN, jsDelivr, Cloudflare |
| `connect-src` | OpenStreetMap, Nominatim, Aladhan API |
| `frame-src` | Google Maps, blob: |

### Konfigurasi

- `app/Http/Middleware/SecurityHeaders.php` — middleware utama CSP
- `config/livewire.php` — konfigurasi Livewire CSP mode

## Image Standards

Modul produk dan layanan menerapkan standarisasi gambar:

| Atribut | Standar |
|---|---|
| Rasio | 4:3 (toleransi ±0.05) |
| Resolusi ideal | 1.200 × 900px |
| Resolusi minimal | 800 × 600px |
| Resolusi maksimal | 3.840 × 2.880px (4K) |
| Ukuran file maks | 2MB |
| Format | WebP (disarankan), JPEG, PNG |

Gambar yang tidak sesuai standar akan ditolak saat disimpan. Standar ditampilkan di form upload admin dan tervalidasi di backend melalui custom rule `ProductImageRatio`.

## Struktur Direktori

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/         # Admin panel controllers
│   │   └── ...            # Public controllers
│   ├── Middleware/        # Security, CSP, upload optimization
│   ├── Requests/          # Form request validations
│   └── Livewire/          # Livewire components
├── Models/                # Eloquent models
├── Rules/                 # Custom validation rules
├── Services/              # Business logic (Image, SEO, FileScanner, dll)
├── Traits/                # Reusable traits (HandlesImageUpload, Auditable, dll)
└── Helpers/               # Helper functions
resources/
├── views/
│   ├── admin/             # Admin dashboard views
│   ├── frontend/          # Public pages
│   ├── components/        # Blade components
│   └── layouts/           # Layout templates
database/
├── migrations/
└── seeders/
```

## Lisensi

Proyek internal — private repository. Dilarang mendistribusikan ulang tanpa seizin pemegang hak cipta.
