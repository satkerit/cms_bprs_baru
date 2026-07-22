# Hero Slider Settings Menu - SQL Documentation

## Overview

This directory contains SQL scripts for managing the Hero Slider Settings menu in the admin panel.

## Files Included

### 1. `alter_hero_slider_settings_menu.sql`

**Purpose:** Complete setup with INSERT and ON DUPLICATE KEY UPDATE
**Use Case:**

- Initial setup with automatic duplicate checking
- Safe to run multiple times
- Uses subqueries for dynamic role ID resolution
- Best for production environments

**Key Features:**

- Uses `ON DUPLICATE KEY UPDATE` for safety
- Dynamically fetches role IDs using subqueries
- Includes verification queries (commented)
- Includes rollback/cleanup queries (commented)

**How to Run:**

```bash
mysql -u user -p database_name < alter_hero_slider_settings_menu.sql
```

---

### 2. `alter_hero_slider_settings_menu_simple.sql`

**Purpose:** Simple, straightforward INSERT statements
**Use Case:**

- Quick setup for fresh installations
- Easier to read and understand
- Direct IDs (menu_id = 56)
- Best for development/testing

**Key Features:**

- Simple INSERT statements
- Fixed menu ID (56)
- Verification queries included
- Minimal complexity

**How to Run:**

```bash
mysql -u user -p database_name < alter_hero_slider_settings_menu_simple.sql
```

**Note:** Only use if menu_id is actually 56. Check first:

```sql
SELECT `id` FROM `admin_menus` WHERE `key` = 'hero-slider-settings';
```

---

### 3. `update_hero_slider_settings_menu.sql`

**Purpose:** Modify existing menu settings and permissions
**Use Case:**

- Change menu name/position/route
- Update permissions for different roles
- Batch updates and role transfers
- Includes extensive verification queries

**Key Features:**

- UPDATE statements for menu properties
- Permission update/grant/revoke operations
- Menu renaming examples
- Role permission transfer templates
- Comprehensive diagnostic queries
- Cleanup and removal statements

**How to Run:**

```bash
mysql -u user -p database_name < update_hero_slider_settings_menu.sql
```

---

## Current Setup Details

### Menu Item

| Property  | Value                             |
| --------- | --------------------------------- |
| Key       | `hero-slider-settings`            |
| Name (ID) | `Pengaturan Slide`                |
| Route     | `admin.hero-slider-settings.edit` |
| Section   | `Konten`                          |
| Order     | 11                                |
| Is Active | 1 (true)                          |
| ID in DB  | 56                                |

### Permissions

| Role        | Has Access | Role ID |
| ----------- | ---------- | ------- |
| Super Admin | ✅ Yes     | 1       |
| Admin       | ✅ Yes     | 2       |
| Editor      | ✅ Yes     | 3       |

### Menu Position (Konten Section)

```
1. Slides (order: 10)
2. Pengaturan Slide (order: 11) ← NEW
3. Berita (order: 12)
4. Produk (order: 13)
5. Brosur Pembiayaan (order: 14)
6. Lelang Agunan (order: 15)
7. Laporan (order: 16)
8. Keunggulan (order: 17)
```

---

## Common SQL Operations

### Check if Menu Exists

```sql
SELECT `id`, `key`, `name`, `route`
FROM `admin_menus`
WHERE `key` = 'hero-slider-settings';
```

### View Menu with Permissions

```sql
SELECT
    m.id,
    m.`key`,
    m.name,
    r.name as role,
    p.can_access
FROM `admin_menus` m
JOIN `admin_menu_permissions` p ON m.id = p.admin_menu_id
JOIN `roles` r ON p.role_id = r.id
WHERE m.`key` = 'hero-slider-settings'
ORDER BY r.id;
```

### Change Menu Name

```sql
UPDATE `admin_menus`
SET `name` = 'Hero Slider Configuration',
    `updated_at` = NOW()
WHERE `key` = 'hero-slider-settings';
```

### Change Menu Position

```sql
UPDATE `admin_menus`
SET `order` = 10,
    `updated_at` = NOW()
WHERE `key` = 'hero-slider-settings';
```

### Grant Permission to Specific Role

```sql
UPDATE `admin_menu_permissions`
SET `can_access` = 1,
    `updated_at` = NOW()
WHERE `admin_menu_id` = (SELECT `id` FROM `admin_menus` WHERE `key` = 'hero-slider-settings')
  AND `role_id` = 2;  -- 1=Super Admin, 2=Admin, 3=Editor
```

### Revoke Permission from Specific Role

```sql
UPDATE `admin_menu_permissions`
SET `can_access` = 0,
    `updated_at` = NOW()
WHERE `admin_menu_id` = (SELECT `id` FROM `admin_menus` WHERE `key` = 'hero-slider-settings')
  AND `role_id` = 3;  -- Remove Editor access
```

### Deactivate Menu

```sql
UPDATE `admin_menus`
SET `is_active` = 0,
    `updated_at` = NOW()
WHERE `key` = 'hero-slider-settings';
```

### Delete Menu and Permissions

```sql
-- Delete permissions first
DELETE FROM `admin_menu_permissions`
WHERE `admin_menu_id` = (SELECT `id` FROM `admin_menus` WHERE `key` = 'hero-slider-settings');

-- Then delete menu
DELETE FROM `admin_menus`
WHERE `key` = 'hero-slider-settings';
```

---

## Database Schema Reference

### admin_menus Table

```sql
CREATE TABLE admin_menus (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    key VARCHAR(255) UNIQUE,
    name VARCHAR(255),
    route VARCHAR(255),
    icon LONGTEXT NULL,
    section VARCHAR(255) NULL,
    order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### admin_menu_permissions Table

```sql
CREATE TABLE admin_menu_permissions (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    admin_menu_id BIGINT UNSIGNED,
    role_id BIGINT UNSIGNED,
    can_access BOOLEAN DEFAULT false,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (admin_menu_id) REFERENCES admin_menus(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);
```

### roles Table

```sql
CREATE TABLE roles (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) UNIQUE,
    display_name VARCHAR(255),
    description TEXT NULL,
    is_system BOOLEAN DEFAULT false,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

---

## Best Practices

1. **Always Backup Before Running SQL**

    ```bash
    mysqldump -u user -p database_name > backup.sql
    ```

2. **Test in Development First**
    - Always test SQL scripts in a development database first
    - Verify results match expectations

3. **Use Transactions for Multiple Operations**

    ```sql
    START TRANSACTION;
    -- Your SQL statements here
    COMMIT;  -- or ROLLBACK; to undo
    ```

4. **Clear Cache After Updates**

    ```bash
    php artisan cache:clear
    ```

5. **Verify Menu in Admin Panel**
    - Login to admin panel
    - Navigate to "Konten" section
    - Verify "Pengaturan Slide" appears

---

## Troubleshooting

### Menu doesn't appear in admin panel

1. Check if menu `is_active` is set to 1
2. Verify user role has permission
3. Clear cache: `php artisan cache:clear`
4. Check if route exists in `routes/web.php`

### Permission not working

1. Verify `can_access` is set to 1 in admin_menu_permissions
2. Check if role_id is correct (1=Super Admin, 2=Admin, 3=Editor)
3. Ensure user is assigned to the correct role

### Menu appears in wrong position

1. Check `order` value in admin_menus table
2. Verify all menus in same section have unique order values
3. Update order if needed: `UPDATE admin_menus SET order = X WHERE key = 'hero-slider-settings'`

---

## Related Files

- Migration: `database/migrations/2026_07_17_170000_add_hero_slider_settings_menu_to_admin_menus_table.php`
- Model: `app/Models/AdminMenu.php`
- Menu Template: `resources/views/layouts/admin/menu.blade.php`
- Controller: `app/Http/Controllers/Admin/HeroSliderSettingsController.php`

---

## Version History

| Date       | Version | Change                    |
| ---------- | ------- | ------------------------- |
| 2026-07-17 | 1.0     | Initial SQL files created |

---

## Support

For questions or issues regarding these SQL scripts, refer to:

- Database documentation
- Laravel migration system
- Admin panel configuration guide

---

**Last Updated:** 2026-07-17
**Created By:** Kiro Development System
