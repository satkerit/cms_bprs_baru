# 🛡️ Laporan Keamanan Terpadu — BPRS Bangka Belitung (CMS)

> **Jenis dokumen:** Security Report (laporan keamanan aplikasi web)
> **Tanggal:** 2026-08-01
> **Stack:** Laravel 13.20.0 · PHP 8.4 · Livewire 4.3 · Blade + Alpine.js (bukan React/Inertia) · Spatie Permission & ResponseCache
> **Status produksi:** ✅ Sudah di-deploy ke production
> **Metodologi:** Tiga skill keamanan digabung — OWASP Top 10 (A01–A10), Audit Risiko Terklasifikasi (Critical/High/Medium/Low/Informational), dan Best Practices Konfigurasi Produksi

---

## Ringkasan Eksekutif

Fondasi keamanan aplikasi ini **di atas rata-rata** untuk aplikasi Laravel:
rate limiting berlapis, anti-DDoS, deteksi ancaman (pattern WAF custom), pemindaian
virus pada seluruh upload, sanitasi HTML di level model, dan security headers lengkap
dengan CSP nonce.

| Level Risiko | Jumlah | Keterangan |
|---|---|---|
| 🔴 **Critical** | 0 | — |
| 🟠 **High** | 2 | IP spoofing via trusted proxies; dokumen whistleblowing di public disk |
| 🟡 **Medium** | 4 | Guzzle CVE; composer update via web; cache clear via GET; escaping flash JSON |
| 🔵 **Low** | 6 | `unsafe-eval` di CSP; `shell_exec` di ImageService; session lifetime; env() langsung di route; header deprecated; dev-diagnostics di production |
| ⚪ **Informational** | 4 | Catatan non-mendesak |

---

# Bagian 1 — OWASP Top 10 (Skill: laravel-owasp-security)

> Status: **Tidak ada React/Inertia.js terdeteksi** — hanya checklist Laravel OWASP yang diterapkan.

## 1. Broken Access Control (A01:2021) — ✅ PASS

- **PASS** `routes/web.php` — Seluruh route admin dibungkus middleware `['auth', 'role', 'idle.timeout', 'menu.permission']`
- **PASS** `app/Http/Middleware/CheckMenuPermission.php` — RBAC berbasis menu dengan `superAdminOnlyRoutes` (roles, users, menu-permissions) dan deny (403) untuk menu tanpa akses
- **PASS** `app/Http/Middleware/CheckRole.php` — Cek role + status `is_active`; super admin punya akses penuh via `hasPermission()`
- **PASS** `app/Models/User.php` — RBAC terpusat: `hasPermission()`, `canManageUsers()`, `canManageSettings()` dengan pembatasan super-admin-only
- **PASS** Tidak ditemukan IDOR yang eksploitable tanpa autentikasi admin: seluruh resource admin diakses via route model binding + middleware auth. Catatan: controller admin seperti `StorageController::delete` & `DatabaseBackupController::download/delete` memakai nama file dari request (sudah disanitasi via `sanitizePath`/`basename`, belum di-scope per-ownership) — risiko terbatas karena digate auth + menu.permission

## 2. Cryptographic Failures (A02:2021) — ✅ PASS

- **PASS** Password di-hash dengan `Hash::make()` / cast `'hashed'` di seluruh controller auth (bcrypt, default Laravel)
- **PASS** Tidak ada MD5/SHA1 untuk hashing password
- **PASS** Password email/SMTP dienkripsi dengan `Crypt::encryptString()` (`app/Models/EmailSetting.php`, `SmtpSetting.php`)
- **PASS** `APP_KEY` ter-set di `.env` (terverifikasi via flag audit)
- **PASS** Signed URLs digunakan untuk verifikasi email (`signed` middleware + `temporarySignedRoute` di tests)

## 3. Injection (A03:2021) — ✅ PASS

**SQL Injection:**
- **PASS** Seluruh `whereRaw/orderByRaw/DB::raw` menggunakan **string statis** (CASE WHEN dengan nilai hardcoded, `DATE(created_at)`), tidak ada interpolasi input user
- **PASS** Tidak ada `$request->all()` yang diteruskan langsung ke `create()`/`update()` — semua controller memakai `$request->validated()`
- **PASS** Tidak ada `forceFill()`/`forceCreate()` dengan input user
- **PASS** Model mendefinisikan `$fillable` eksplisit (tidak ada `$guarded = []`)

**XSS — Blade:**
- **PASS** Konten WYSIWYG (news, product, career, auction, office, dll) **disanitasi di level model** via `App\Helpers\HtmlSanitizer::clean()` sebelum disimpan — inilah mengapa `{!! $news->content !!}` di view aman
- **PASS** `{{ }}` digunakan untuk hampir semua output user
- **PASS** Tidak ada `eval()` / `new Function()` dengan string user
- **INFO** JSON-LD di `seo.blade.php:43` memakai `{!! json_encode(...) !!}` — aman karena `json_encode` meng-escape `<`, `>`, `&` ke `\u003C` dst (PHP ≥ 5.4)

## 4. Insecure Design (A04:2021) — ✅ PASS

- **PASS** Logika bisnis kalkulator pembiayaan dihitung server-side dengan sanitasi input numerik (`FinancingSimulation/Calculator.php`)
- **PASS** Operasi sensitif (hapus user, composer update) butuh konfirmasi / hanya super admin
- **PASS** Fitur admin terisolasi di balik middleware — tidak hanya disembunyikan di UI

## 5. Security Misconfiguration (A05:2021) — ⚠️ 1 FAIL

- **FAIL (HIGH)** `bootstrap/app.php:39` — `trustProxies(at: '*')` mempercayai **semua** proxy → spoofing header `X-Forwarded-For` dapat melewati semua proteksi berbasis IP (DdosProtection, BlockedIp, threat detection, rate limit, strict IP session)
- **PASS** `.env` ter-gitignore dan tidak pernah di-track ke git
- **PASS** `APP_DEBUG` ter-set di `.env` (pastikan `false` di production)
- **PASS** CORS `allowed_origins` dari env (default kosong = restriktif)
- **INFO** Endpoint `/dev-diagnostics` aktif di production (token-protected via `hash_equals`), mengekspos nama DB & username DB — sebaiknya dibatasi env `local`

## 6. Vulnerable & Outdated Components (A06:2021) — ⚠️ 1 FAIL

- **FAIL (MEDIUM)** `guzzlehttp/guzzle` **7.14.2** — `composer audit` menemukan 3 advisory medium (perlu ≥ 7.15.1):
  1. URI fragment bocor di header Referer saat redirect
  2. Cookie scope host-only tidak dipertahankan
  3. Cookie respons tak terbatas → risiko DoS
- **PASS** `npm audit` → **0 vulnerabilities**
- **PASS** Laravel 13.20.0 pada versi ter-support

## 7. Identification & Authentication Failures (A07:2021) — ✅ PASS

- **PASS** Rate limit login ketat: 5 percobaan + captcha (`AdminLoginController` via `RateLimiter`)
- **PASS** Password reset di-throttle (3/menit), reset password (5/menit), verifikasi email (6/menit)
- **PASS** `session()->regenerate()` setelah login sukses; `invalidate()` + `regenerateToken()` saat logout/gagal
- **PASS** Cookie session: `http_only=true`, `same_site=strict`, `secure=true` (default), `encrypt=true`, idle timeout 30 menit, strict IP check
- **PASS** Password history 5 riwayat + kebijakan password kompleks (test `PasswordPolicyTest`)
- **INFO** `SESSION_LIFETIME` 120 menit (rekomendasi 15–30) — ter-mitigasi oleh idle timeout 30 menit

## 8. Software & Data Integrity Failures (A08:2021) — ✅ PASS

- **PASS** CSRF aktif; hanya `/api/csp-report` yang dikecualikan (justified — endpoint laporan CSP)
- **PASS** Tidak ada `unserialize($request->input())`, `eval()`, atau `extract($request->all())`
- **INFO (MEDIUM)** `ComposerUpdateController` mengizinkan `composer update` dari web panel — digate super admin + CSRF + konfirmasi, tapi tetap risiko supply-chain

## 9. Security Logging & Monitoring Failures (A09:2021) — ✅ PASS

- **PASS** AuditTrail lengkap (create/update/delete, upload, download, login)
- **PASS** SecurityLog + sanitasi payload (password tidak pernah masuk log)
- **PASS** Security Monitor, BlockedIp, visitor stats, laporan CSP violations
- **PASS** Tidak ada password mentah di log

## 10. SSRF (A10:2021) — ✅ PASS

- **PASS** `Http::get()` hanya ke URL hardcoded (`api.aladhan.com`), tidak ada URL dari input user
- **PASS** Tidak ada open redirect (`redirect($request->input('url'))`)
- **PASS** Tidak ada `exec/shell_exec` dengan input user langsung — lihat L6 untuk catatan `shell_exec` di ImageService

---

# Bagian 2 — Audit Risiko Terklasifikasi (Skill: laravel-security-audit)

## 🟠 HIGH

### H1. Trust All Proxies — IP Spoofing (A05)
- **Lokasi:** `bootstrap/app.php:39` — `$middleware->trustProxies(at: '*', ...)`
- **Masalah:** Header `X-Forwarded-For` dari klien langsung dipercaya → penyerang dapat memalsukan IP dan **melewati** proteksi berbasis IP: `DdosProtection`, `AdminDdosProtection`, `SecurityThreatDetection`, `BlockedIp`, rate limiting, strict IP session, dan statistik visitor.
- **Exploit:** IP `203.0.113.5` diblokir → kirim `X-Forwarded-For: 8.8.8.8` → lolos blokir & rate limit.
- **Fix:** Ganti `at: '*'` dengan daftar IP proxy nyata (mis. range Cloudflare/cPanel) atau nonaktifkan trust proxy jika tidak diperlukan.

### H2. Dokumen Whistleblowing di Public Disk
- **Lokasi:** `app/Livewire/Frontend/Complaint/Form.php:89` — `$file->store('complaints', 'public')`
- **Masalah:** Lampiran pengaduan/whistleblowing (fraud, pelanggaran, etika) tersimpan di **disk publik** → dapat diakses siapa saja via `/storage/complaints/...` jika path diketahui. Konten bersifat sensitif & rahasia (identitas pelapor, bukti).
- **Fix:** Simpan ke disk privat + route download terautentikasi admin, atau `visibility: private`.

## 🟡 MEDIUM

### M1. Guzzle 7.14.2 — 3 Advisory (A06)
- **Lokasi:** `composer.lock` — `guzzlehttp/guzzle` 7.14.2 (< 7.15.1)
- **Fix:** `composer update guzzlehttp/guzzle --with-all-dependencies`

### M2. Composer Update dari Web Panel (A08)
- **Lokasi:** `app/Http/Controllers/Admin/ComposerUpdateController.php`
- **Kondisi saat ini:** Digate `authorizeAny(['settings.composer'])` + cek super admin + CSRF + checkbox konfirmasi; proses via `Symfony Process` (array args, tanpa shell injection) ✅. Namun route ada di `alwaysAccessibleRoutes` → proteksi hanya di controller.
- **Rekomendasi:** Verifikasi permission `settings.composer` hanya untuk super admin; pertimbangkan nonaktifkan di production (jalankan via SSH).

### M3. Cache Clear via GET (CSRF via GET)
- **Lokasi:** `routes/web.php` — `Route::get('reports/clear-caches', ...)`
- **Masalah:** GET dengan efek samping memungkinkan CSRF via `<img src="/admin/reports/clear-caches">` (GET tidak membawa token CSRF) → pembersihan cache berulang (DoS ringan/performance).
- **Fix:** Ubah ke `POST` + `@csrf`.

### M4. Escaping Flash JSON di Attribute `data-messages`
- **Lokasi:** `resources/views/layouts/admin.blade.php:341` & `frontend/layouts/app.blade.php:86` — `data-messages='{!! $__swalFlash !!}'`
- **Masalah:** `json_encode()` default **tidak meng-escape tanda kutip tunggal**. Attribute dibungkus `'...'` → flash message mengandung `'` bisa break-out attribute (potensi XSS defense-in-depth).
- **Fix:** Gunakan `{{ $__swalFlash }}` atau `json_encode(..., JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP)`.

## 🔵 LOW

| # | Temuan | Lokasi | Catatan |
|---|---|---|---|
| L1 | CSP `'unsafe-eval'` di `script-src` melemahkan proteksi XSS | `SecurityHeaders.php:69` | Verifikasi apakah benar-benar diperlukan |
| L2 | Session lifetime 120 menit | `config/session.php` | Ter-mitigasi idle timeout 30 menit + strict IP ✅ |
| L3 | `env('STORAGE_MODE')` dipanggil langsung di route | `routes/web.php:27` | Jika `config:cache` aktif, `env()` di luar config = null (bug potensial) |
| L4 | `X-XSS-Protection: 1; mode=block` deprecated | `SecurityHeaders.php` | Bisa memicu false-positive; CSP sudah cukup |
| L5 | `/dev-diagnostics` aktif di production | `routes/web.php` | Token-protected ✅ tapi ekspos nama DB/user; batasi ke env `local` |
| L6 | `shell_exec()` untuk ffmpeg di web server | `app/Services/ImageService.php:813,830,938` | Argument server-generated (`Str::uuid()`/`time()_Str::random(10)`), bukan input user langsung. Defense-in-depth: tambahkan `escapeshellarg()` pada `$fullPath`/`$outputPath`/`$ffmpeg` |

## ⚪ INFORMATIONAL

| # | Catatan |
|---|---|
| I1 | `{!! json_encode($schemaData, JSON_UNESCAPED_SLASHES) !!}` aman — json_encode meng-escape `<`/`>`/`&` |
| I2 | Draft form di `localStorage` (`public/js/news-form.js`) — konten draft non-sensitif |
| I3 | Route `/hero-slider-demo` publik — hanya data demo |
| I4 | Header deprecated (`X-XSS-Protection`, `Expect-CT` sudah dihapus) — menandakan app sudah beberapa kali iterasi hardening |

---

# Bagian 3 — Audit Konfigurasi Produksi (Skill: laravel-security)

## ✅ Konfigurasi yang SUDAH Benar

| Area | Status | Detail |
|---|---|---|
| **APP_KEY** | ✅ PASS | Ter-set di `.env` |
| **APP_DEBUG** | ✅ PASS | Ter-set (wajib `false` di production) |
| **Session cookie** | ✅ PASS | `http_only`, `same_site=strict`, `secure=true`, `encrypt=true`, idle timeout |
| **Session fixation** | ✅ PASS | `session()->regenerate()` setelah login di `AdminLoginController` |
| **CSRF** | ✅ PASS | Aktif; hanya `/api/csp-report` dikecualikan (justified) |
| **Mass assignment** | ✅ PASS | `$fillable` eksplisit di `User`; semua controller pakai `$request->validated()` |
| **Password hashing** | ✅ PASS | bcrypt + cast `hashed`; history 5 riwayat |
| **File upload** | ✅ PASS | `mimes:` + `max:` + **FileScanner (scan virus)** + nama unik server-generated (L6: `shell_exec` ffmpeg — pakai `escapeshellarg()`) |
| **Path traversal** | ✅ PASS | `StorageServeController` cek `realpath`+prefix; `DatabaseBackup` pakai `basename()`; `StorageController` sanitize path |
| **Security headers** | ✅ PASS | CSP nonce + HSTS + X-Frame-Options + nosniff + Referrer-Policy + Permissions-Policy + COOP/COEP/CORP |
| **ResponseCache** | ✅ PASS | `CustomCacheProfile` mengecualikan `admin*`, request terautentikasi, Livewire, AJAX ✅ |
| **`.env`** | ✅ PASS | Gitignored, tidak pernah ter-track |
| **Route debug** | ✅ PASS | `routes/debug.php` dibatasi `app()->environment('local')` |
| **Logging** | ✅ PASS | SecurityLog + sanitasi payload; AuditTrail lengkap |
| **Dependensi JS** | ✅ PASS | `npm audit` = 0 vuln |

## ⚠️ Konfigurasi yang Perlu Diperbaiki

| Area | Status | Detail |
|---|---|---|
| **Trusted proxies** | ⚠️ FAIL (High) | `at: '*'` → ganti daftar IP proxy nyata |
| **Public disk untuk dokumen sensitif** | ⚠️ FAIL (High) | Lampiran whistleblowing → pindah ke disk privat |
| **Guzzle** | ⚠️ FAIL (Medium) | Update ke ≥ 7.15.1 |
| **Composer via web** | ⚠️ WATCH | Batasi super admin / nonaktifkan di production |
| **GET dengan efek samping** | ⚠️ FAIL (Medium) | `reports/clear-caches` → POST |

---

# Bagian 4 — Status Perbaikan (Remediation Status)

> **Tanggal remediasi:** 2026-08-02 — Seluruh perbaikan di bawah ini **sudah diterapkan** dan tervalidasi (syntax OK, route terverifikasi, `composer audit` bersih).

| # | Temuan | Status | Perubahan yang Diterapkan |
|---|---|---|---|
| H1 | Trust All Proxies — IP Spoofing | ✅ **FIXED** | `bootstrap/app.php` — `trustProxies(at: '*')` diganti daftar dari `env('TRUSTED_PROXIES')` (comma-separated CIDR), default ke range privat (10.0.0.0/8, 172.16.0.0/12, 192.168.0.0/16, 127.0.0.1). Teruji: `env()` terbaca di titik callback `withMiddleware` bahkan saat `config:cache` aktif. **⚠️ AKSI PRODUCTION:** set `TRUSTED_PROXIES` di `.env` production ke IP proxy nyata (mis. range Cloudflare) — jika kosong, semua pengunjung tampil sebagai IP proxy yang sama untuk rate-limit/blocking
| H2 | Dokumen Whistleblowing di Public Disk | ✅ **FIXED** | `Complaint/Form.php` — lampiran kini `store('complaints', 'local')` (disk privat, default `visibility: private`). Route baru `admin.complaints.attachment` (GET, auth+role+menu) → `ComplaintController@downloadAttachment` menyajikan dari disk privat dengan fallback ke public untuk file lama. View `show.blade.php` memakai route ber-index. **⚠️ RESIDUAL RISK:** file **lama** yang pernah tersimpan di `storage/app/public/complaints/` tetap bisa diakses publik via `/storage/complaints/...`. Migrasi file lama: `mkdir -p storage/app/private/complaints && mv storage/app/public/complaints/* storage/app/private/complaints/ && chmod 600 storage/app/private/complaints/*` lalu update path di kolom `attachments` (JSON) tabel `complaints` (path-nya sama, hanya disk yang berubah)
| M1 | Guzzle 7.14.2 — 3 Advisory | ✅ **FIXED** | `composer update guzzlehttp/guzzle --with-all-dependencies` → **7.15.2**. `composer audit` = **No security vulnerability advisories found** |
| M2 | Composer Update dari Web Panel | ⚠️ **WATCH** | Masih aktif (digate super admin + CSRF + konfirmasi). Rekomendasi: nonaktifkan di production, jalankan via SSH |
| M3 | Cache Clear via GET (CSRF) | ✅ **FIXED** | `routes/web.php` — `reports/clear-caches` diubah dari `GET` menjadi `POST` (+ `@csrf` di form/link yang memanggilnya). Route terverifikasi via `route:list`. Catatan: tidak ada caller GET yang tersisa di views/JS (aman) |
| M4 | Escaping Flash JSON di `data-messages` | ✅ **FIXED** | `layouts/admin.blade.php` & `frontend/layouts/app.blade.php` — `{!! $__swalFlash !!}` diganti `{{ $__swalFlash }}`. Browser me-decode entity sebelum JS membaca attribute, jadi `JSON.parse` tetap berfungsi |
| L1 | CSP `'unsafe-eval'` | ⚠️ **REVERTED** | Awalnya dihapus dari `script-src`, lalu **dikembalikan** setelah verifikasi: bundle `vendor-alpine` & `vendor-sweetalert` memakai `new Function()` (Alpine v3 mengevaluasi `x-data`/`x-on` via `new Function`). Menghapusnya merusak seluruh interaktivitas UI di production. Risiko diterima (di-mitigasi nonce + tanpa eval input user); dokumentasi komentar sudah ditambahkan di `SecurityHeaders.php`. **Future hardening:** migrasi ke Alpine CSP build (`alpinejs/csp`) akan memungkinkan `'unsafe-eval'` dihapus — di luar scope sekarang |
| L2 | Session lifetime 120 menit | ✅ **FIXED** | `config/session.php` — lifetime 120 → **60 menit** |
| L3 | `env('STORAGE_MODE')` di route | ✅ **FIXED** | `routes/web.php` — ganti ke `config('app.storage_mode')`; key baru ditambahkan di `config/app.php` (baca dari env, default `development`) |
| L4 | `X-XSS-Protection` deprecated | ✅ **FIXED** | `SecurityHeaders.php` — header `X-XSS-Protection` dihapus (CSP sudah cukup) |
| L5 | `/dev-diagnostics` di production | ✅ **FIXED** | `routes/web.php` — `abort(404)` kecuali env `local` |
| L6 | `shell_exec` ffmpeg | ✅ **FIXED** | `ImageService.php` — `$fullPath`/`$outputPath`/`$ffmpeg` dibungkus `escapeshellarg()` (defense-in-depth) |

---

# Lampiran — Perintah yang Direkomendasikan

```bash
# Audit dependensi (jalankan rutin)
composer audit
npm audit

# Perbaikan CVE Guzzle
composer update guzzlehttp/guzzle --with-all-dependencies

# Verifikasi konfigurasi production
php artisan about
php artisan config:cache && php artisan route:cache
```

---

*Dokumen ini dihasilkan dari audit tiga skill keamanan (OWASP Top 10, Risk Classification, Production Best Practices) pada 2026-08-01. Remediasi diterapkan 2026-08-02 — lihat Bagian 4 untuk status per item. Sebelum deploy ke production, jalankan pengujian pada environment staging terlebih dahulu.*
