---
title: API Endpoints
description: Complete API documentation for all routes
tags:
  - api
  - routes
  - endpoints
---

# API Endpoints

> [!info] Route Structure
> The application uses Laravel routes organized by function:
> - `routes/web.php` — Main frontend routes + admin routes
> - `routes/auth.php` — Authentication routes
> - `routes/hero-slider-routes.php` — Hero slider management
> - `routes/debug.php` — Debug utilities (admin only)

## Frontend Routes

### Homepage
| Method | URI | Controller | Description |
|--------|-----|------------|-------------|
| GET | `/` | `HomeController@index` | Homepage with hero, products, news, stats |

### Products
| Method | URI | Controller | Description |
|--------|-----|------------|-------------|
| GET | `/products` | `ProductController@index` | Product listing with categories |
| GET | `/products/simpanan-syariah` | `ProductController@simpananSyariah` | Savings products |
| GET | `/products/pembiayaan-syariah` | `ProductController@pembiayaanSyariah` | Financing products |
| GET | `/products/deposito-syariah` | `ProductController@depositoSyariah` | Deposit products |
| GET | `/products/kas-keliling` | `ProductController@kasKeliling` | Mobile cash schedule |
| GET | `/products/{slug}` | `ProductController@show` | Product detail |

### News
| Method | URI | Controller | Description |
|--------|-----|------------|-------------|
| GET | `/news` | `NewsController@index` | News listing with search & filter |
| GET | `/news/{slug}` | `NewsController@show` | News detail with related articles |

### Auctions
| Method | URI | Controller | Description |
|--------|-----|------------|-------------|
| GET | `/auctions` | `AuctionController@index` | Auction listing |
| GET | `/auctions/{slug}` | `AuctionController@show` | Auction detail |

### Careers
| Method | URI | Controller | Description |
|--------|-----|------------|-------------|
| GET | `/karir` | `CareerController@index` | Career listing with filters |
| GET | `/karir/{slug}` | `CareerController@show` | Career detail |

### Reports
| Method | URI | Controller | Description |
|--------|-----|------------|-------------|
| GET | `/laporan` | `ReportController@index` | Reports listing |
| GET | `/laporan/keuangan-publikasi` | `ReportController@keuanganPublikasi` | Financial reports |
| GET | `/laporan/tata-kelola` | `ReportController@tataKelola` | Governance reports |
| GET | `/laporan/tahunan` | `ReportController@tahunan` | Annual reports |
| GET | `/laporan/berkelanjutan` | `ReportController@tahunanBerkelanjutan` | Sustainability reports |

### About
| Method | URI | Description |
|--------|-----|-------------|
| GET | `/tentang-kami` | Company profile |
| GET | `/tentang-kami/komisaris` | Board of commissioners |
| GET | `/tentang-kami/direksi` | Board of directors |
| GET | `/tentang-kami/pengawas-syariah` | Sharia supervisory board |
| GET | `/tentang-kami/struktur-organisasi` | Organization structure |
| GET | `/tentang-kami/kantor-kami` | Office locations with map |

### Contact & Forms
| Method | URI | Controller | Description |
|--------|-----|------------|-------------|
| GET | `/hubungi-kami` | `ContactController@index` | Contact page with map |
| POST | `/contact/send` | `ContactController@send` | Contact form submission |
| GET | `/pengaduan-nasabah` | `ComplaintController@index` | Complaint form |
| POST | `/pengaduan-nasabah` | `ComplaintController@store` | Submit complaint |
| GET | `/whistleblowing` | `WhistleblowingController@index` | Whistleblowing form |
| POST | `/whistleblowing` | `WhistleblowingController@store` | Submit report |
| GET | `/simulasi-pembiayaan` | `FinancingSimulationController@index` | Financing calculator |
| GET | `/brosur` | `BrochureController@index` | Brochure listing |

## Auth Routes

### Login
| Method | URI | Controller | Description |
|--------|-----|------------|-------------|
| GET | `/admin/login` | `AdminLoginController@showLoginForm` | Login form with CAPTCHA |
| POST | `/admin/login` | `AdminLoginController@login` | Login with validation |
| POST | `/admin/logout` | `SessionController@destroy` | Logout |

### Password Management
| Method | URI | Controller | Description |
|--------|-----|------------|-------------|
| GET | `/forgot-password` | `PasswordResetLinkController@create` | Forgot password form |
| POST | `/forgot-password` | `PasswordResetLinkController@store` | Send reset link |
| GET | `/reset-password/{token}` | `NewPasswordController@create` | Reset form |
| POST | `/reset-password` | `NewPasswordController@store` | Execute reset |
| GET | `/confirm-password` | `ConfirmablePasswordController@show` | Confirm password |
| POST | `/confirm-password` | `ConfirmablePasswordController@store` | Verify password |

> [!tip] Rate Limiting
> Login attempts are rate-limited to 5 per minute per IP. See [[Security Setup]].

## Admin Routes

All admin routes are prefixed with `/admin` and protected by auth + role middleware.

### Dashboard
| Method | URI | Description |
|--------|-----|-------------|
| GET | `/admin/dashboard` | Dashboard with stats & charts |

### CRUD Resources
| URI Prefix | Controller | Features |
|------------|------------|----------|
| `/admin/news` | `Admin\NewsController` | CRUD + image gallery + SEO |
| `/admin/products` | `Admin\ProductController` | CRUD + brochure upload |
| `/admin/auctions` | `Admin\AuctionController` | CRUD + bulk actions |
| `/admin/hero-slides` | `Admin\HeroSlideController` | CRUD + reorder + settings |
| `/admin/kas-keliling` | `Admin\KasKelilingController` | CRUD + schedules + export |
| `/admin/careers` | `Admin\CareerController` | CRUD |
| `/admin/users` | `Admin\UserController` | CRUD |
| `/admin/roles` | `Admin\RoleController` | CRUD + permissions |
| `/admin/complaints` | `Admin\CustomerComplaintController` | CRUD + print |
| `/admin/reports` | `Admin\ReportController` | CRUD + preview |
| `/admin/offices` | `Admin\OfficeController` | CRUD + coordinates |
| `/admin/brochures` | `Admin\BrochureController` | CRUD + download |
| `/admin/storage` | `Admin\StorageController` | File browser + upload |

### Settings
| URI | Controller | Description |
|-----|------------|-------------|
| `/admin/settings/company` | `Admin\CompanyInfoController` | Company profile |
| `/admin/settings/site` | `Admin\SiteSettingController` | Site settings |
| `/admin/settings/security` | `Admin\SecuritySettingController` | Security config + IP blocks |
| `/admin/settings/complaint` | `Admin\ComplaintSettingController` | Complaint settings |
| `/admin/settings/menu-permissions` | `Admin\MenuPermissionController` | Menu permissions |
| `/admin/settings/financing` | `Admin\FinancingConfigController` | Financing config |

### Session Management
| Method | URI | Controller | Description |
|--------|-----|------------|-------------|
| GET | `/admin/session/status` | `SessionController@getStatus` | Session status (Alpine.js) |
| POST | `/admin/session/activity` | `SessionController@updateActivity` | Update activity timestamp |

## API Routes

### Prayer Times (Public)
| Method | URI | Controller | Description |
|--------|-----|------------|-------------|
| GET | `/api/prayer-times` | `PrayerTimeController` | Daily prayer times |

## Related

- [[Architecture Overview]]
- [[Admin Panel]]
