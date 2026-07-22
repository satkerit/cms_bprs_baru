# Database Changes Log - July 17, 2026

## Overview

File ini mencatat semua perubahan database yang dilakukan pada tanggal 17 Juli 2026. Perubahan mencakup penambahan tabel baru, data migrasi, dan pembaruan menu admin.

---

## Changes Summary

### 1. **New Table: `report_categories`**

**File Migration:** `2026_07_17_103000_create_report_categories_table.php`

**Tujuan:**
Menyimpan kategori-kategori laporan yang sebelumnya disimpan di `site_settings`. Memisahkan konfigurasi laporan ke tabel tersendiri untuk better organization dan flexibility.

**Schema:**

```
- id (bigint, primary key)
- slug (varchar 100, unique)
- name (varchar 255)
- title (varchar 255)
- subtitle (varchar 255, nullable)
- description (longtext, nullable)
- sort_order (int, default 0)
- is_active (boolean, default true)
- timestamps (created_at, updated_at)
```

**Default Data:**

```
1. keuangan_publikasi - Laporan Keuangan Publikasi (sort_order: 1)
2. tata_kelola - Laporan Tata Kelola (sort_order: 2)
3. tahunan - Laporan Tahunan (sort_order: 3)
4. tahunan_berkelanjutan - Laporan Tahunan Berkelanjutan (sort_order: 4)
```

**Migrasi Data:** Data diambil dari `site_settings` table berdasarkan field-field yang sudah ada.

---

### 2. **New Table: `hero_slider_settings`**

**File Migration:** `2026_07_17_163713_create_hero_slider_settings_table.php`

**Tujuan:**
Menyimpan konfigurasi dan pengaturan untuk hero slider section, termasuk dimensi, ukuran file, aspek rasio, delay autoplay, dan fitur-fitur yang dapat diaktifkan/dinonaktifkan.

**Schema:**

```
Dimensions:
- min_width (int, default 320px)
- min_height (int, default 240px)
- max_width (int, default 3840px)
- max_height (int, default 2160px)

File & Media:
- max_file_size_mb (int, default 5MB)
- aspect_ratio (varchar, default "16:9")

Container Settings:
- slider_delay_ms (int, default 7000ms / 7 detik)
- min_height_px (int, default 320px)
- max_height_px (int, default 600px)

Features (boolean flags):
- enable_autoplay (default true)
- enable_touch_swipe (default true)
- enable_navigation_arrows (default true)
- enable_dot_indicators (default true)

- timestamps (created_at, updated_at)
```

**Default Configuration:**

- Auto-play enabled dengan delay 7 detik
- Aspect ratio 16:9
- Max file size 5MB
- Supported range: 320px - 3840px width, 240px - 2160px height
- Semua fitur navigation diaktifkan

---

### 3. **Admin Menu Update: Hero Slider Settings**

**File Migration:** `2026_07_17_170000_add_hero_slider_settings_menu_to_admin_menus_table.php`

**Tujuan:**
Menambahkan menu item baru di admin panel untuk manage hero slider settings.

**Details:**

```
Key: hero-slider-settings
Name: Pengaturan Slide
Route: admin.hero-slider-settings.edit
Section: Konten
Order: 11
Is Active: true
```

**Permissions:**
Menu ini diberikan akses ke roles:

- `super_admin`
- `admin`
- `editor`

**Actions:**

- Insert menu item ke `admin_menus` table
- Increment order untuk menu-menu lain di section "Konten" yang memiliki order >= 11
- Insert permissions ke `admin_menu_permissions` table untuk roles yang diizinkan
- Clear cache: `admin_menus_all_with_permissions`

---

### 4. **Admin Menu Route Fix**

**File Migration:** `2026_07_17_180000_fix_hero_slider_settings_route.php`

**Tujuan:**
Memperbaiki route name untuk menu `hero-slider-settings` dari `hero-slider-settings.edit` menjadi `admin.hero-slider-settings.edit`.

**Changes:**

```
UPDATE admin_menus
SET route = 'admin.hero-slider-settings.edit'
WHERE key = 'hero-slider-settings'
```

**Cache Clear:** `admin_menus_all_with_permissions`

---

## SQL File Information

### File: `2026_07_17_latest_changes.sql`

File SQL ini berisi:

1. ✅ CREATE TABLE statements untuk kedua tabel baru
2. ✅ INSERT DEFAULT DATA untuk kategori laporan
3. ✅ INSERT DEFAULT DATA untuk hero slider settings
4. ✅ INSERT/UPDATE untuk admin menu
5. ✅ INSERT untuk admin menu permissions
6. ✅ UPDATE untuk memperbaiki route name
7. ✅ Verification queries untuk testing

### Cara Menggunakan:

#### Option 1: Jalankan langsung di SQL Client

```sql
source /path/to/2026_07_17_latest_changes.sql
```

#### Option 2: Import via Command Line (MySQL)

```bash
mysql -u username -p database_name < 2026_07_17_latest_changes.sql
```

#### Option 3: Import via Laravel Migration (Recommended)

```bash
php artisan migrate
```

---

## Verification Checklist

Setelah menjalankan SQL, verifikasi dengan queries berikut:

```sql
-- 1. Check report_categories created
SELECT COUNT(*) as total_categories FROM report_categories;
SELECT * FROM report_categories ORDER BY sort_order;

-- 2. Check hero_slider_settings created
SELECT * FROM hero_slider_settings;

-- 3. Check admin menu added
SELECT * FROM admin_menus WHERE key = 'hero-slider-settings';

-- 4. Check permissions added
SELECT am.name, r.name as role_name, amp.can_access
FROM admin_menu_permissions amp
JOIN admin_menus am ON am.id = amp.admin_menu_id
JOIN roles r ON r.id = amp.role_id
WHERE am.key = 'hero-slider-settings'
ORDER BY r.name;

-- 5. Count total permissions
SELECT COUNT(*) as total_permissions
FROM admin_menu_permissions amp
JOIN admin_menus am ON am.id = amp.admin_menu_id
WHERE am.key = 'hero-slider-settings';
```

---

## Related Files

```
database/migrations/
├── 2026_07_17_103000_create_report_categories_table.php
├── 2026_07_17_163713_create_hero_slider_settings_table.php
├── 2026_07_17_170000_add_hero_slider_settings_menu_to_admin_menus_table.php
└── 2026_07_17_180000_fix_hero_slider_settings_route.php

database/sql/
├── 2026_07_17_latest_changes.sql  (← Generated SQL file)
└── CHANGELOG_2026_07_17.md         (← This file)
```

---

## Database Schema Diagram

```
report_categories
├── id (PK)
├── slug (UNIQUE)
├── name
├── title
├── subtitle
├── description
├── sort_order
├── is_active
└── timestamps

hero_slider_settings
├── id (PK)
├── min_width, max_width
├── min_height, max_height
├── max_file_size_mb
├── aspect_ratio
├── slider_delay_ms
├── min_height_px, max_height_px
├── enable_autoplay
├── enable_touch_swipe
├── enable_navigation_arrows
├── enable_dot_indicators
└── timestamps

admin_menus (modified)
├── id (PK)
├── key: "hero-slider-settings"
├── name: "Pengaturan Slide"
├── route: "admin.hero-slider-settings.edit" ← FIXED
├── section: "Konten"
├── order: 11
└── is_active: true

admin_menu_permissions (modified)
├── admin_menu_id (FK) → admin_menus.id
├── role_id (FK) → roles.id
├── can_access: true (for super_admin, admin, editor)
└── timestamps
```

---

## Rollback Information

Jika perlu rollback, jalankan:

```bash
php artisan migrate:rollback --step=4
```

Atau secara manual dengan reverse SQL:

```sql
-- Drop tables in reverse order
DROP TABLE IF EXISTS hero_slider_settings;
DROP TABLE IF EXISTS report_categories;

-- Remove menu and permissions
DELETE FROM admin_menu_permissions
WHERE admin_menu_id = (SELECT id FROM admin_menus WHERE key = 'hero-slider-settings');

DELETE FROM admin_menus
WHERE key = 'hero-slider-settings';
```

---

## Notes

- ✅ Semua perubahan include dengan `IF NOT EXISTS` atau `ON DUPLICATE KEY UPDATE` untuk idempotency
- ✅ Timestamps diupdate otomatis dengan `NOW()`
- ✅ Foreign keys dan indexes sudah dioptimalkan
- ✅ Default data sudah dimigrasikan dari `site_settings`
- ✅ Cache clear signals sudah termasuk dalam migration
- ✅ Dokumentasi lengkap dengan verification queries

---

## Support

Untuk pertanyaan atau issues terkait perubahan ini, periksa:

1. Migration files di `database/migrations/`
2. Controller untuk hero slider di `app/Http/Controllers/`
3. Model untuk report categories di `app/Models/`

---

**Generated Date:** July 17, 2026  
**Database Version:** MySQL 5.7+  
**Laravel Version:** 11.x
