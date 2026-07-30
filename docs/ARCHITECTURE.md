# Architecture Documentation — BPRS Bangka Belitung CMS

> Generated from graphify codebase analysis

---

## Table of Contents
1. [System Overview](#1-system-overview)
2. [Request Flow](#2-request-flow)
3. [Middleware Stack](#3-middleware-stack)
4. [Model Layer (Community 24 Hub)](#4-model-layer)
5. [Caching Architecture](#5-caching-architecture)
6. [Image Processing Pipeline](#6-image-processing-pipeline)
7. [Email & Queue System](#7-email--queue-system)
8. [Performance Analysis](#8-performance-analysis)

---

## 1. System Overview

```mermaid
graph TB
    subgraph "Frontend (Public)"
        HC[HomeController]
        AC[AuctionController]
        NC[NewsController]
        PC[ProductController]
        RC[ReportController]
    end

    subgraph "Admin Panel"
        AdminC[Admin Controllers]
        DBoard[DashboardService]
        Livewire[Livewire Components]
    end

    subgraph "Service Layer"
        CS[CacheService]
        IS[ImageService]
        SM[SeoMeta]
        DS[DashboardService]
    end

    subgraph "Infrastructure"
        MW[Middleware Stack]
        Queue[Queue Jobs]
        Email[Mailables]
    end

    subgraph "Data Layer"
        Models[(Models)]
        Cache[(Cache)]
        DB[(Database)]
    end

    Frontend --> MW
    AdminC --> MW
    MW --> CS
    MW --> SM
    CS --> Models
    Models --> DB
    Models --> Cache
    AdminC --> Queue
    Queue --> Email
    AdminC --> IS
    IS --> Queue
```

---

## 2. Request Flow

### Public Page Request (e.g. Auction Detail)

```mermaid
sequenceDiagram
    participant User as Browser
    participant MW as Middleware Stack
    participant Ctrl as AuctionController
    participant SEO as SeoMeta
    participant Model as Auction Model
    participant Cache as Cache Layer
    participant DB as Database

    User->>MW: GET /lelang/{slug}
    MW->>MW: DdosProtection → RateLimit → ThreatDetection → SecurityHeaders
    
    Note over MW: Cek IP, rate limit, SQL injection, XSS
    
    MW->>Ctrl: Request diteruskan
    Ctrl->>SEO: SeoMeta::setTitle(), setDescription(), addSchema()
    SEO->>SEO: Singleton pattern → render OpenGraph + Schema.org
    Ctrl->>Model: Auction::published()->whereSlug()
    
    Model->>DB: Query auction
    DB-->>Model: Auction data
    
    Note over Ctrl: Increment view_count
    Ctrl->>Cache: Cache::remember('auctions_featured', 3600, ...)
    
    Ctrl-->>MW: Response + SecurityHeaders
    MW-->>User: HTML page + CSP headers + HSTS
```

### Admin CRUD Request (e.g. Update Auction)

```mermaid
sequenceDiagram
    participant Admin as Admin Browser
    participant MW as Middleware Stack
    participant Auth as CheckMenuPermission
    participant Ctrl as Admin/AuctionController
    participant IS as ImageService
    participant CS as CacheService
    participant Model as Auction Model
    participant DB as Database

    Admin->>MW: POST /admin/auctions/{id}
    MW->>Auth: Cek role & permission
    Auth-->>MW: Authorized (admin/editor)
    MW->>Ctrl: Request diteruskan
    
    Ctrl->>Ctrl: AuthorizesAdminActions::authorizeEdit()
    
    Note over Ctrl: Handle image updates
    Ctrl->>IS: compressForWeb() / upload()
    IS-->>Ctrl: Image path
    
    Ctrl->>Model: $auction->update($validated)
    Model->>DB: UPDATE query
    DB-->>Model: Updated
    
    Note over Ctrl: Invalidate cache
    Ctrl->>CS: clearAuctionCache()
    CS->>CS: Cache::forget('auctions_home_*')
    CS->>CS: Cache::forget('auctions_featured')
    CS->>CS: Cache::forget('auctions_upcoming')
    CS->>CS: ResponseCache::clear()
    
    Ctrl-->>Admin: Redirect + success message
```

---

## 3. Middleware Stack

```mermaid
graph LR
    subgraph "Security Layer"
        DP[DdosProtection<br/>extends BaseDdosProtection]
        RL[RateLimitRequests]
        STD[SecurityThreatDetection]
        SS[SecureSessionMiddleware]
        SH[SecurityHeaders]
    end

    subgraph "Auth Layer"
        CMP[CheckMenuPermission]
        CR[CheckRole]
    end

    subgraph "Application Layer"
        LV[LogVisitor<br/>dispatch LogVisitorVisit job]
        LV2[CacheStaticAssets]
    end

    Request --> DP
    DP --> RL
    RL --> STD
    STD --> SS
    SS --> SH
    SH --> CMP
    CMP --> CR
    LV --> LV2
    LV2 --> CR
    CR --> Controller
```

### Layer Details

| # | Middleware | Class | Thresholds | Response on Block |
|---|---|---|---|---|
| 1 | **DdosProtection** | `app/Http/Middleware/DdosProtection.php` | 10 req/s, 120/min, 3000/h | 429 + progressive block (5min→24h) |
| 2 | **RateLimitRequests** | `app/Http/Middleware/RateLimitRequests.php` | Configurable per route | 429 Too Many Requests |
| 3 | **SecurityThreatDetection** | `app/Http/Middleware/SecurityThreatDetection.php` | 79 regex patterns (SQLi, XSS, etc) | 403 + auto-block IP at 5 violations |
| 4 | **SecureSessionMiddleware** | `app/Http/Middleware/SecureSessionMiddleware.php` | Device fingerprint mismatch → hijack | 302 redirect to login + session invalidate |
| 5 | **SecurityHeaders** | `app/Http/Middleware/SecurityHeaders.php` | CSP, HSTS, X-Frame-Options | N/A (response header) |
| 6 | **CheckMenuPermission** | `app/Http/Middleware/CheckMenuPermission.php` | Role-based menu access | 403 if no permission |
| 7 | **CheckRole** | `app/Http/Middleware/CheckRole.php` | Role-based route access | 403 if wrong role |
| 8 | **LogVisitor** | `app/Http/Middleware/LogVisitor.php` | N/A | Dispatches `LogVisitorVisit` job |

---

## 4. Model Layer

### Community 24 — Central Model Hub

```mermaid
classDiagram
    class KasKeliling {
        +string area_name
        +array schedule
        +boolean is_active
        +schedules() HasMany
        +upcomingSchedules() HasMany
    }
    
    class Role {
        +string name
        +string display_name
        +users() HasMany
        +permissions() BelongsToMany
        +hasPermission() bool
        +syncPermissions()
    }
    
    class User {
        +string name
        +string email
        +string role
        +roleModel() BelongsTo
        +getRoles() Collection
    }
    
    class Permission {
        +string name
        +string guard_name
        +getGroupedPermissions()
    }
    
    class AdminMenu {
        +string name
        +string route
        +string icon
        +int parent_id
        +canAccess() bool
        +getGroupedMenusForRole()
    }
    
    class FinancingConfig {
        +string type
        +decimal margin_rate
        +decimal profit_share_rate
        +decimal min_principal
        +decimal max_principal
        +scopeActive()
    }
    
    class Auditable {
        <<trait>>
        +log() void
        +getAuditDescription() string
    }

    KasKeliling "1" --> "*" KasKelilingSchedule : schedules
    Role "*" --> "*" Permission : permissions
    User "*" --> "1" Role : roleModel
    AdminMenu "*" --> "*" Role : permissions
    
    Auditable <|.. KasKeliling : uses
    Auditable <|.. Role : uses
    Auditable <|.. User : uses
    Auditable <|.. FinancingConfig : uses
    Auditable <|.. Auction : uses
    Auditable <|.. News : uses
    Auditable <|.. Product : uses
```

### Full Model Map

```mermaid
graph TB
    subgraph "Content Models"
        News[News]
        Product[Product]
        Auction[Auction]
        Report[Report]
        ReportCat[ReportCategory]
        Career[Career]
        Brochure[Brochure]
    end

    subgraph "Company Profile"
        CompanyInfo[CompanyInfo]
        Office[Office]
        BoardMember[BoardMember]
        WhyChooseUs[WhyChooseUs]
        HeroSlide[HeroSlide]
    end

    subgraph "Customer Service"
        Complaint[Complaint]
        CustomerComplaint[CustomerComplaint]
        KasKeliling[KasKeliling]
        KasKelilingSchedule[KasKelilingSchedule]
    end

    subgraph "Auth & Admin"
        User[User]
        Role[Role]
        Permission[Permission]
        AdminMenu[AdminMenu]
        AdminMenuPermission[AdminMenuPermission]
    end

    subgraph "Security & Config"
        SecuritySetting[SecuritySetting]
        SecurityLog[SecurityLog]
        BlockedIp[BlockedIp]
        EmailSetting[EmailSetting]
        SiteSetting[SiteSetting]
        FinancingConfig[FinancingConfig]
    end

    subgraph "Infrastructure"
        AuditTrail[AuditTrail]
        VisitorLog[VisitorLog]
        PasswordHistory[PasswordHistory]
        SmtpSetting[SmtpSetting]
        ComplaintSetting[ComplaintSetting]
        HeroSliderSettings[HeroSliderSettings]
    end

    KasKeliling --> KasKelillingSchedule
    User --> Role
    Role --> Permission
    Role --> AdminMenuPermission
    AdminMenuPermission --> AdminMenu
    Complaint --> ReportCat
    CustomerComplaint --> ReportCat
    News --> NewsImage
```

---

## 5. Caching Architecture

### Cache Keys & Durations

```mermaid
graph LR
    subgraph "24 Hours (CACHE_LONG)"
        CI[company_info]
        PH[products_home_*]
        BM[board_members_*]
        WCU[why_choose_us*]
        RY[report_years_*]
        AFT[auctions_featured]
        ACT[auctions_cities<br/>auctions_asset_types]
    end

    subgraph "1 Hour (CACHE_MEDIUM)"
        HS[hero_slides_*]
        NH[news_home_*]
        AH[auctions_home_*]
        OF[offices_*]
        KK[kas_keliling*]
        PT[products_*]
        NC[news_categories]
    end

    subgraph "5 Minutes"
        DS[dashboard_stats]
        AS[auction_stats]
    end

    subgraph "No Cache (Live Query)"
        VL[visitor_logs<br/>chart data]
        AD[admin listings<br/>with filters]
    end
```

### Invalidation Flow

```mermaid
sequenceDiagram
    participant Admin as Admin Action
    participant Ctrl as Controller
    participant CS as CacheService
    participant RC as ResponseCache (Spatie)
    participant FC as Frontend

    Admin->>Ctrl: Create/Update/Delete
    
    Ctrl->>CS: clearXxxCache()
    
    CS->>CS: Cache::forget('news_home_*')
    CS->>CS: Cache::forget('news_categories')
    CS->>CS: Cache::forget('products_home_*')
    
    CS->>RC: ResponseCache::clear()
    RC->>RC: Hapus semua cached pages
    
    Note over FC: Next request → cache miss → fresh data
    FC->>FC: Cache::remember(..., fn() => Model::query())
```

### Cache Invalidation Mapping

| Admin Action | Cache Cleared | Method |
|---|---|---|
| News CRUD | `news_home_*`, `news_categories` + ResponseCache | `clearNewsCache()` |
| Product CRUD | `products_home_*`, `products_*` + ResponseCache | `clearAll()` |
| Auction CRUD | `auctions_home_*`, `auctions_featured`, `auctions_upcoming`, `auctions_asset_types`, `auctions_cities` + ResponseCache | `clearAuctionCache()` |
| Site Settings | `site_settings` + Cache flush | `clearCache()` (model) |
| Company Info | `company_info` + ResponseCache | `clearCache()` (model) |
| Office CRUD | `offices_all`, `offices_*` + ResponseCache | booted() callback |
| Member CRUD | `board_members_*` | booted() callback |
| Kas Keliling | `kas_keliling`, `kas_keliling_schedules` + ResponseCache | `clearKasKelilingCache()` |
| Report CRUD | `report_years_*` + Cache flush + ResponseCache | `clearReportCache()` |
| Why Choose Us | `why_choose_us*` | `clearAll()` |
| **Bulk Clear** | ALL cache keys (18+ types) | `clearAll()` |

---

## 6. Image Processing Pipeline

```mermaid
flowchart LR
    A[User Upload] --> B{HandlesImageUpload trait}
    B --> C[FileScanner<br/>Security Scan]
    C --> D{Extension Valid?}
    D -->|No| E[Reject]
    D -->|Yes| F[ImageService::upload]
    
    F --> G[Resize to 5 breakpoints]
    G --> H1[JPEG Progressive<br/>quality=85-90]
    G --> H2[WebP<br/>quality=85-88]
    G --> H3[AVIF<br/>quality=85]
    
    H1 --> I[Save to storage]
    H2 --> I
    H3 --> I
    
    F --> J[Dispatch<br/>ProcessImageUpload Job]
    J --> K[Queue]
    K --> L[ImageService::processUploadedImage]
    L --> M[Generate ulang variants]
    M --> N[GD Library]
    M --> O[ffmpeg Fallback]
```

### Breakpoint Output per Upload

| Format | Mobile | Small | Medium | Large | Original |
|---|---|---|---|---|---|
| **JPEG** (progressive) | 480px | 768px | 1024px | 1280px | 1920px |
| **WebP** | 480px | 768px | 1024px | 1280px | 1920px |
| **AVIF** | 480px | 768px | 1024px | 1280px | 1920px |

### Storage Locations

| Context | Directory | Quality |
|---|---|---|
| Hero Slides | `public/storage/hero-slides/` | 90 |
| News Featured | `public/storage/news/` | 85 |
| News Gallery | `public/storage/news/gallery/` | 85 |
| Products | `public/storage/products/` | 85 |
| Offices | `public/storage/offices/` | 85 |
| Auctions | `public/storage/auctions/` | 80 |
| Company | `public/storage/company/` | 85 |

---

## 7. Email & Queue System

```mermaid
graph TB
    subgraph "Triggers"
        CF[Contact Form<br/>Livewire Component]
        CoF[Complaint Form<br/>Livewire]
        CC[ComplaintController<br/>@update]
        CCC[CustomerComplaint<br/>@update]
        LogM[LogVisitor<br/>Middleware]
        IU[Image Upload<br/>Handler]
    end

    subgraph "Queue Jobs (Community 99)"
        LV[LogVisitorVisit<br/>tries=2, backoff=5s,30s]
        PI[ProcessImageUpload<br/>tries=3, backoff=5s,15s,60s]
        SCE[SendComplaintStatusEmail<br/>tries=3, backoff=5s,30s,120s]
        SCCE[SendCustomerComplaintStatusEmail<br/>tries=3, backoff=5s,30s,120s]
    end

    subgraph "Mailables (Community 66)"
        CM[ComplaintMail]
        CCM[ComplaintConfirmationMail]
        CSUM[ComplaintStatusUpdateMail]
        CFM[ContactFormMail]
        CCM2[CustomerComplaintMail]
        CCCM[CustomerComplaintConfirmationMail]
        CCSUM[CustomerComplaintStatusUpdateMail]
    end

    subgraph "Notification"
        RPN[ResetPasswordNotification<br/>via mail channel]
    end

    CF --> CFM
    CoF --> CM
    CoF --> CCM
    CC -->|dispatch| SCE
    SCE --> CSUM
    CCC -->|dispatch| SCCE
    SCCE --> CCSUM
    LogM -->|dispatch| LV
    IU -->|dispatch| PI

    RPN -.->|Illuminate\\Notifications\\Notification| User
```

### Job Configuration

| Job | Model | Tries | Max Exceptions | Backoff | Delete When Missing |
|---|---|---|---|---|---|
| LogVisitorVisit | — | 2 | 1 | 5s, 30s | No |
| ProcessImageUpload | — | 3 | 1 | 5s, 15s, 60s | No |
| SendComplaintStatusEmail | Complaint | 3 | — | 5s, 30s, 120s | **Yes** |
| SendCustomerComplaintStatusEmail | CustomerComplaint | 3 | — | 5s, 30s, 120s | **Yes** |

---

## 8. Performance Analysis

### Hot Paths (High Frequency, Low Latency Required)

| Path | Cache? | Frequency | Query Cost | Risk |
|---|---|---|---|---|
| Homepage (hero + products + news + auctions) | ✅ 1-24h | Very High | 4 queries (cached) | Low |
| Auction listing (public) | ✅ 24h (filters) | High | 5 queries (3 cached) | Low |
| News listing + detail | ✅ 1h | High | 2 queries (cached) | Low |
| Product listing | ✅ 24h+ | Medium | 2 queries (cached) | Low |
| Admin dashboard | ✅ 5min | Medium | 6 queries (1 cached) | **Medium** |

### Cold Paths (No Cache — Live Query)

| Path | Query | Frequency | Concern |
|---|---|---|---|
| Admin listing with filters | `Auction::paginate()` + search | Medium | Acceptable — admin-only |
| Visitor chart (7 days) | `VisitorLog::groupBy(DATE)` | Per dashboard load | ✅ Efficient — single query |
| Search results | `LIKE %query%` on multiple columns | Low | **⚠️ Potential perf issue** on large datasets |

### Performance Risks

#### ⚠️ Medium: `LIKE %keyword%` Queries
```php
// In AuctionController, NewsController, ProductController:
$query->where('title', 'like', "%{$search}%")
    ->orWhere('address', 'like', "%{$search}%")
    ->orWhere('city', 'like', "%{$search}%");
```
**Impact:** Full table scan on large datasets (10k+ records). Consider MySQL FULLTEXT index.

#### ✅ Low: Cache Stampede Protection
Most cache keys use `Cache::remember()` which has built-in stampede protection (only one process regenerates).

#### ✅ Low: Queue Dispatching
Image processing and email sending are all queued — no blocking on user request.

#### ℹ️ Info: Memory Usage on Image Upload
```php
ini_set('memory_limit', '512M');
ini_set('max_execution_time', 300);
```
**Impact:** Acceptable for admin-only operations. 5 minute timeout prevents hanging processes.

### Optimization Suggestions

| Area | Suggestion | Impact |
|---|---|---|
| **Search** | Add MySQL FULLTEXT index on `title`, `address`, `city`, `description` | **High** — eliminates table scans |
| **Visitor Chart** | Add materialized aggregation table for visitor stats by day | Medium — reduces aggregation cost |
| **Auction Counts** | Already cached (`getCachedStats()`) | ✅ Done |
| **Image Processing** | Already queued (`ProcessImageUpload`) | ✅ Done |
| **Model Cache** | Most models auto-clear on save via booted() | ✅ Done |

---

## Appendix: Key Metrics

| Metric | Value |
|---|---|
| **Total Code Files** | 674 |
| **Total Models** | ~35 |
| **Total Controllers** | ~45 |
| **Total Middleware** | 8 (documented) |
| **Total Queue Jobs** | 4 |
| **Total Mailables** | 7 |
| **Total Cache Keys** | ~25 |
| **Database Tables** | ~30 |
| **Graph Communities** | 543 (69 thin) |
| **Graph Nodes (AST)** | 6,537 |
| **Graph Edges** | 14,858 |
