# Admin Session Management - Dynamic Configuration

## Overview

Session management untuk admin telah diimplementasikan dengan konfigurasi dinamis melalui halaman admin, bukan via file `.env`. Ini memungkinkan administrator untuk mengubah pengaturan session tanpa perlu restart aplikasi.

## Fitur Utama

### 1. Session Lifetime

- **Deskripsi**: Durasi maksimal sesi admin
- **Range**: 30-1440 menit (0.5-24 jam)
- **Default**: 120 menit
- **Fungsi**: Menentukan berapa lama sesi tetap valid

### 2. Idle Timeout

- **Deskripsi**: Waktu idle sebelum auto logout
- **Range**: 5-480 menit (5 menit - 8 jam)
- **Default**: 30 menit
- **Fungsi**: Logout otomatis jika user tidak aktif

### 3. Idle Warning

- **Deskripsi**: Waktu warning sebelum idle timeout
- **Range**: 1-60 menit
- **Default**: 5 menit
- **Validasi**: Harus lebih kecil dari idle timeout
- **Fungsi**: Menampilkan warning kepada user sebelum logout

### 4. Auto Extend Session

- **Tipe**: Boolean (On/Off)
- **Default**: On
- **Fungsi**: Perpanjang sesi otomatis saat ada aktivitas user

### 5. Enable Session Tracking

- **Tipe**: Boolean (On/Off)
- **Default**: On
- **Fungsi**: Aktifkan pelacakan aktivitas sesi untuk keamanan

## Cara Mengakses

1. Login ke admin panel
2. Navigasi ke **Settings → Keamanan**
3. Scroll ke bagian **Manajemen Sesi Admin**
4. Ubah pengaturan sesuai kebutuhan
5. Klik **Simpan Pengaturan**

## Implementasi Teknis

### Database Schema

```sql
ALTER TABLE security_settings ADD COLUMN session_lifetime INT DEFAULT 120;
ALTER TABLE security_settings ADD COLUMN idle_timeout INT DEFAULT 30;
ALTER TABLE security_settings ADD COLUMN idle_warning INT DEFAULT 5;
ALTER TABLE security_settings ADD COLUMN auto_extend_session BOOLEAN DEFAULT true;
ALTER TABLE security_settings ADD COLUMN enable_session_tracking BOOLEAN DEFAULT true;
```

### Model (SecuritySetting)

```php
protected $fillable = [
    // ... existing fields
    'session_lifetime',
    'idle_timeout',
    'idle_warning',
    'auto_extend_session',
    'enable_session_tracking',
];

protected $casts = [
    // ... existing casts
    'auto_extend_session' => 'boolean',
    'enable_session_tracking' => 'boolean',
];
```

### Middleware (IdleTimeoutMiddleware)

Middleware membaca pengaturan dari database:

```php
$settings = SecuritySetting::getSettings();
$idleTimeout = $settings->idle_timeout * 60; // Convert to seconds
```

### Controller (SecuritySettingController)

Validasi pengaturan:

```php
'session_lifetime' => 'required|integer|min:30|max:1440',
'idle_timeout' => 'required|integer|min:5|max:480',
'idle_warning' => 'required|integer|min:1|max:60',
```

## Cara Kerja Session

### 1. User Login

- Session dibuat dengan lifetime sesuai setting
- Last activity time dicatat di cache

### 2. User Aktif

- Setiap request memperbarui last activity time
- Jika `auto_extend_session` aktif, sesi diperpanjang

### 3. User Idle

- Jika idle > `idle_timeout`, user logout otomatis
- Jika idle > `idle_timeout - idle_warning`, warning ditampilkan

### 4. User Logout

- Session dihapus
- Cache cleared
- Redirect ke login page

## Contoh Skenario

### Skenario 1: Keamanan Tinggi

```
Session Lifetime: 60 menit
Idle Timeout: 15 menit
Idle Warning: 3 menit
Auto Extend: On
```

- Sesi berakhir maksimal 60 menit
- Logout otomatis jika idle 15 menit
- Warning muncul 3 menit sebelum logout

### Skenario 2: Keamanan Rendah (Development)

```
Session Lifetime: 480 menit (8 jam)
Idle Timeout: 120 menit (2 jam)
Idle Warning: 10 menit
Auto Extend: On
```

- Sesi lebih lama untuk development
- Logout otomatis jika idle 2 jam
- Warning muncul 10 menit sebelum logout

## Troubleshooting

### Session Berakhir Terlalu Cepat

1. Periksa `Idle Timeout` setting
2. Verifikasi `Auto Extend Session` aktif
3. Cek cache driver berfungsi

### Session Tidak Logout Otomatis

1. Verifikasi `Enable Session Tracking` aktif
2. Cek middleware `idle.timeout` terdaftar di routes
3. Clear cache: `php artisan cache:clear`

### Warning Tidak Muncul

1. Verifikasi `Idle Warning` < `Idle Timeout`
2. Cek JavaScript console untuk error
3. Verifikasi response headers berisi `X-Idle-Warning`

## Best Practices

1. **Idle Timeout**: Set 20-30 menit untuk keamanan optimal
2. **Idle Warning**: Set 5-10 menit sebelum timeout
3. **Auto Extend**: Aktifkan untuk UX yang lebih baik
4. **Session Tracking**: Selalu aktifkan untuk audit trail
5. **Session Lifetime**: Set lebih besar dari idle timeout

## Related Files

- `app/Models/SecuritySetting.php` - Model
- `app/Http/Controllers/Admin/SecuritySettingController.php` - Controller
- `app/Http/Middleware/IdleTimeoutMiddleware.php` - Middleware
- `resources/views/admin/settings/security.blade.php` - View
- `database/migrations/2026_03_10_add_session_settings_to_security_settings.php` - Migration

## API Response Headers

Middleware menambahkan header untuk JavaScript:

```
X-Idle-Timeout: 1800 (seconds)
X-Last-Activity: 1234567890 (timestamp)
X-Current-Time: 1234567900 (timestamp)
X-Idle-Warning: 300 (seconds)
```

## Cache Management

Settings di-cache selama 1 jam:

```php
Cache::remember('security_settings', 3600, function () {
    return SecuritySetting::first() ?? SecuritySetting::create([]);
});
```

Cache di-clear otomatis saat settings diupdate.
