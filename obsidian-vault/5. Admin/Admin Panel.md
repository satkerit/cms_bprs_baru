---
title: Admin Panel
description: Admin dashboard, CRUD management, and settings
tags:
  - admin
  - crud
  - management
---

# Admin Panel

> [!info] Admin Access
> URL: `/admin/login` — Requires Math CAPTCHA verification
> Roles: `super_admin`, `admin`, `editor`

## Dashboard

The admin dashboard provides:
- **Welcome card** with current date
- **Quick stats** — News, Products, Auctions, Complaints counts
- **Visitor chart** — 7-day visitor statistics (Chart.js)
- **Recent news** — Latest articles with status
- **Recent complaints** — Latest tickets with status
- **Account info** — Email, role, status

> [!tip] Staggered Animation
> Dashboard stats use `admin-stagger` class for staggered fade-in entrance animation.

## Content Management

### News (Berita)
| Feature | Description |
|---------|-------------|
| Editor | CKEditor 5 (Classic) |
| Images | Multiple image upload with gallery |
| Categories | Custom categories |
| SEO | Meta title, description per article |
| Schedule | Scheduled publishing |
| Author | Tracking per article |

### Products (Produk & Layanan)
| Feature | Description |
|---------|-------------|
| Types | Simpanan Syariah, Pembiayaan, Deposito |
| Sections | Description, Benefits, Requirements, Procedure |
| Brochure | PDF upload per product |
| Icon | Product icon/image |
| Categories | Product categorization |

### Auctions (Lelang Agunan)
| Feature | Description |
|---------|-------------|
| Statuses | Draft → Published → Registration → Scheduled → Sold/Cancelled |
| Images | Main image with fallback |
| Sold watermark | Visual overlay on sold items |
| Legal basis | Legal document text |

### Kas Keliling
| Feature | Description |
|---------|-------------|
| Units | Manage mobile cash office units |
| Schedules | Day/time/location per unit |
| PIC | Person in charge per schedule |

## Settings

### Company Info
- Company name, address, contact
- Logo (with preview and remove)
- Footer logo
- Favicon
- Social media links (Facebook, Instagram, YouTube, Twitter, TikTok, LinkedIn)
- Statistics (years, branches, assets)
- OJK/LPS taglines

### Security Settings
- Login attempts, lockout duration
- Password expiry
- Session timeout
- Idle timeout with warning
- Auto-extend session
- IP block management

### Site Settings
- Site name, description
- Maintenance mode
- Hero slider limit

## File Management

> [!tip] Image Optimization
> Uploaded images are automatically optimized:
> - Resized to responsive breakpoints
> - Converted to WebP and AVIF
> - Compressed for performance

## CRUD Pattern

All CRUD controllers follow the same pattern:
1. **Index** — Paginated list with search/filter
2. **Create** — Form with validation
3. **Store** — Save with file upload handling
4. **Edit** — Form with existing data
5. **Update** — Save changes
6. **Destroy** — Soft delete or permanent

## Related

- [[Architecture Overview]]
- [[Security Setup]]
- [[Frontend Components]]
