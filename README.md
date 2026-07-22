# CMS Company Profile BPR Syariah

Sistem Content Management System (CMS) modern yang dibangun khusus untuk mengelola Company Profile Bank Pembiayaan Rakyat (BPR) Syariah. Proyek ini dikembangkan menggunakan framework Laravel terbaru dengan fokus pada keamanan tingkat tinggi, performa, dan kemudahan manajemen konten (Admin Dashboard).

## 🚀 Fitur Utama

### Manajemen Konten (CMS)

- **Laporan Perusahaan**: Manajemen laporan tahunan, laporan keuangan publikasi, laporan tata kelola, dan laporan tahunan berkelanjutan dengan pelacakan statistik (Preview & Download).
- **Hero Slider**: Pengaturan _banner_ bergerak di halaman utama (teks, gambar, waktu _delay_, limit slide).
- **Karier & Lowongan**: Publikasi informasi lowongan pekerjaan.
- **Informasi Perusahaan**: Pengaturan nama perusahaan, logo, kontak, alamat, tautan sosial media, dan lisensi/OJK.
- **Produk & Simulasi**: Informasi produk pembiayaan dan tabungan, serta integrasi Kalkulator Simulasi Pembiayaan Syariah.

### Keamanan & Infrastruktur (Enterprise Grade)

- **Middleware Proteksi Keamanan**: Terintegrasi perlindungan DDoS (`DdosProtection`), deteksi aktivitas mencurigakan (`DetectSuspiciousActivity`), _blocker_ IP otomatis (`BlockSuspiciousRequests`), dan Proteksi Sesi Aman.
- **Security Headers**: Header keamanan di-set otomatis untuk mencegah kerentanan XSS dan Clickjacking.
- **Audit Trail & Security Logs**: Pencatatan riwayat perubahan (Audit Trail) dan _login/access logs_ untuk investigasi keamanan.
- **Kebijakan Sandi (Password Policy)**: Memastikan password yang digunakan kuat dan mencatat histori agar password lama tidak digunakan ulang.
- **Spatie Roles & Permissions**: Kontrol hak akses multi-level untuk Administrator dan Staf.

### Optimasi & Performa

- **Spatie Response Cache**: Mekanisme _caching_ respons cepat untuk mempercepat akses halaman di level _production_.
- **Optimasi Upload**: Integrasi validasi dinamis (diatur via Dashboard Admin) untuk mengontrol memori dan ukuran unggahan file, menjaga _server_ dari _error_ _413 Content Too Large_.
- **Cloudinary & Intervention Image**: Pemrosesan dan manipulasi gambar (opsional via Cloudinary).
- **Content Security Policy (CSP)**: Implementasi CSP yang kompatibel dengan Alpine.js dan Livewire, memungkinkan ekspresi JavaScript modern (arrow functions, optional chaining) sambil tetap menjaga keamanan.

## 🛠️ Tech Stack (Teknologi)

- **Backend**: PHP 8.3+ | [Laravel 13](https://laravel.com)
- **Frontend**: Blade | [Livewire 4.3](https://livewire.laravel.com/) | [Alpine.js](https://alpinejs.dev/) | [Tailwind CSS 3.4](https://tailwindcss.com/)
- **Database**: MySQL / SQLite (Tergantung Environtment)
- **Library Tambahan**:
    - [Spatie Permission](https://spatie.be/docs/laravel-permission/v6/introduction) (Autentikasi Hak Akses)
    - [SweetAlert2](https://sweetalert2.github.io/) (Notifikasi UI)
    - [Swiper](https://swiperjs.com/) (Slider)
    - [Leaflet](https://leafletjs.com/) (Pemetaan Interaktif)
    - [Summernote](https://summernote.org/) (WYSIWYG Editor)

## 📋 Persyaratan Sistem

- PHP >= 8.3
- Composer >= 2.0
- Node.js & NPM
- Ekstensi PHP: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML, GD/Imagick.

## ⚙️ Panduan Instalasi (Development)

1. **Kloning Repositori**

    ```bash
    git clone https://github.com/satkerit/companyprofle.git
    cd companyprofle
    ```

2. **Jalankan Skrip Setup Bawaan**
   Aplikasi ini memiliki _script_ otomasi di `composer.json` untuk mempermudah _setup_.

    ```bash
    composer setup
    ```

    _(Perintah ini otomatis menjalankan `composer install`, membuat `.env`, `key:generate`, `migrate`, `npm install`, dan `npm run build`)._

3. **Konfigurasi Lingkungan (`.env`)**
   Sesuaikan koneksi database Anda di file `.env`.

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database_anda
    DB_USERNAME=root
    DB_PASSWORD=
    ```

    _Opsional: Jalankan ulang migrasi jika menggunakan database baru: `php artisan migrate:fresh --seed`_

4. **Jalankan Server Lokal**
   Gunakan perintah `dev` untuk menjalankan server PHP, Vite (Frontend), dan Queue secara bersamaan:

    ```bash
    composer dev
    ```

    Kunjungi: `http://localhost:8000`

## 🎛️ Konfigurasi Tingkat Lanjut (Production)

### Server Upload Limits (Untuk Admin Dashboard)

Meskipun batas unggah bisa diubah di Dashboard -> Pengaturan Website, batas maksimum _server fisik_ harus tetap dinaikkan.

**Untuk Apache:**
Tidak perlu diatur ulang (Aplikasi otomatis membaca limit melalui file `public/.htaccess`).

**Untuk Nginx:**
Tambahkan baris berikut di dalam blok server konfigurasi `nginx.conf` Anda untuk menghindari _Error 413_:

```nginx
client_max_body_size 100M;
```

### Optimasi Cache

Sebelum aplikasi _live_, sangat dianjurkan untuk menjalankan:

```bash
php artisan optimize
php artisan view:cache
```

## 🔒 Konfigurasi Content Security Policy (CSP)

Sistem ini mengimplementasikan CSP (Content Security Policy) yang dikonfigurasi khusus untuk bekerja dengan Alpine.js dan Livewire, memungkinkan penggunaan fitur JavaScript modern.

### Kebijakan CSP yang Diterapkan

| Directive     | Kebijakan                                                       |
| ------------- | --------------------------------------------------------------- |
| `default-src` | `'self'` - Hanya mengizinkan sumber dari domain sendiri         |
| `script-src`  | Nonce-based + `'unsafe-eval'` untuk Alpine.js + CDNs terpercaya |
| `style-src`   | `'unsafe-inline'` untuk dynamic styles Alpine.js + CDNs font    |
| `img-src`     | `data:`, `https:`, `blob:` untuk gambar                         |
| `font-src`    | Google Fonts, Bunny CDN, jsDelivr, Cloudflare CDN, dan data URI |
| `connect-src` | OpenStreetMap, Nominatim, dan Aladhan API                       |
| `frame-src`   | Google Maps dan blob URLs                                       |

### Troubleshooting CSP

Jika Anda mengalami masalah CSP di environment baru:

1. **Alpine.js Expression Errors**: Pastikan `config/livewire.php` memiliki `'csp_safe' => false` untuk menggunakan build Alpine.js standar yang mendukung arrow functions dan optional chaining.

2. **Style Tidak Terap**: Pastikan `style-src` memiliki `'unsafe-inline'`. Browser mengabaikan `'unsafe-inline'` jika ada nonce di directive tersebut.

3. **Gambar/Glyph Font Tidak Tampil**: Tambahkan domain sumber ke `img-src` atau `font-src`.

### File Konfigurasi CSP

- `app/Http/Middleware/SecurityHeaders.php` - Middleware utama CSP
- `config/livewire.php` - Konfigurasi Livewire CSP mode

## 📝 Lisensi

Proyek ini bersifat tertutup (Private Repository). Dilarang mendistribusikan ulang atau menyalin kode tanpa seizin pemegang hak cipta terkait.
