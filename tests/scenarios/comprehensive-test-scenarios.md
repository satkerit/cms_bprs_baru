# Comprehensive Test Scenarios — CMS Bank Syariah Babel

## Scope
Functional + Security + Integration testing covering all system layers.

---

## A. FUNCTIONAL TEST SCENARIOS

### A1. Authentication & Session Management

| ID | Area | Preconditions | Steps | Expected Result | Type |
|----|------|---------------|-------|-----------------|------|
| A1-01 | Frontend Login | User registered & active | POST `/login` with valid email+password+CAPTCHA | Redirect to `/`; session created; no error | Automated |
| A1-02 | Frontend Login — Invalid CAPTCHA | User registered | POST `/login` with wrong CAPTCHA answer | Validation error; login rejected | Automated |
| A1-03 | Frontend Login — Wrong Password | User registered | POST `/login` with wrong password + correct CAPTCHA | Validation error; throttle counter incremented | Automated |
| A1-04 | Frontend Login — Inactive User | User exists, `is_active=false` | POST `/login` with valid credentials | Login rejected; error displayed | Automated |
| A1-05 | Frontend Login — Rate Limiting | — | POST `/login` 6+ times rapidly (same IP) | 429 Too Many Requests after threshold | Automated |
| A1-06 | Admin Login | Admin user active | POST `/admin/login` with valid credentials+CAPTCHA | Redirect to `admin.dashboard` | Automated |
| A1-07 | Admin Login — Non-Admin User | Editor user | POST `/admin/login` with editor credentials | Validation error; login rejected | Automated |
| A1-08 | Admin Login — Inactive Admin | Admin `is_active=false` | POST `/admin/login` | Login rejected | Automated |
| A1-09 | Logout | Authenticated user | POST `/logout` | Session destroyed; redirect; AuditTrail logged | Automated |
| A1-10 | Session — Idle Timeout | Authenticated admin | Wait > idle_timeout minutes, then access admin page | Redirected to login | Automated |
| A1-11 | Session — IP Change | Authenticated user | Simulate IP change mid-session | Session invalidated; logged out; SecurityLog entry | Automated |
| A1-12 | Session — UA Change | Authenticated user | Change User-Agent mid-session | Session invalidated; logged out | Automated |
| A1-13 | Password Reset — Request | Registered user | POST `/password/email` with valid email | Email sent; notification recorded | Automated |
| A1-14 | Password Reset — Invalid Token | — | POST `/password/reset` with tampered token | Validation error; reset rejected | Automated |
| A1-15 | Password Update — Weak Password | Authenticated user | POST `/password/confirm` with `password < 12 chars` | Validation error (StrongPassword rule) | Automated |
| A1-16 | Password Update — Reused Password | Authenticated user | Change to one of last 5 passwords | Validation error (PasswordHistory check) | Automated |
| A1-17 | Password Update — Success | Authenticated user | Change to new valid password | Success; PasswordHistory updated | Automated |
| A1-18 | Registration — Weak Password | — | POST `/register` with password < 12 chars | Validation error | Automated |

### A2. Public Pages

| ID | Area | Preconditions | Steps | Expected Result | Type |
|----|------|---------------|-------|-----------------|------|
| A2-01 | Homepage | — | GET `/` | 200; renders hero slides, products, news, auctions | Automated |
| A2-02 | Product Listing | — | GET `/produk/{type}` | 200; lists active products by type | Automated |
| A2-03 | Product Detail | Active product exists | GET `/produk/{type}/{slug}` | 200; product details displayed | Automated |
| A2-04 | News Listing | Published news exists | GET `/berita` | 200; paginated news list | Automated |
| A2-05 | News Detail | Published news exists | GET `/berita/{slug}` | 200; news content with sanitized HTML | Automated |
| A2-06 | News — Unpublished | Unpublished news | GET `/berita/{slug}` (unpublished) | 404 | Automated |
| A2-07 | News — Scheduled | Scheduled news | GET `/berita/{slug}` (future publish) | 404 | Automated |
| A2-08 | Auction Listing | Published auctions exist | GET `/lelang` | 200; filters, search, pagination | Automated |
| A2-09 | Auction Detail | Published auction exists | GET `/lelang/{slug}` | 200; increments view_count | Automated |
| A2-10 | Auction — Draft | Draft auction | GET `/lelang/{slug}` (draft) | 404 | Automated |
| A2-11 | Career Listing | Active careers exist | GET `/karir` | 200; lists available positions | Automated |
| A2-12 | Career Detail | Active career exists | GET `/karir/{slug}` | 200; job details | Automated |
| A2-13 | Career — Expired | Expired career | GET `/karir/{slug}` (past deadline) | 200 but marked expired | Automated |
| A2-14 | Report Listing | Published reports exist | GET `/informasi-umum/{type}` | 200; filtered by type/year | Automated |
| A2-15 | About — Company Info | — | GET `/tentang-kami` | 200; company info displayed | Automated |
| A2-16 | About — Board Members | Board members exist | GET `/tentang-kami/dewan-direksi` | 200; board member list | Automated |
| A2-17 | About — Offices | Active offices exist | GET `/tentang-kami/kantor` | 200; office list with map data | Automated |
| A2-18 | Financing Simulation | — | GET `/simulasi-pembiayaan` | 200; calculator form rendered | Automated |
| A2-19 | Complaint Form (Whistleblowing) | — | GET `/whistleblowing` | 200; form rendered | Automated |
| A2-20 | Customer Complaint Form | — | GET `/pengaduan-nasabah` | 200; form rendered with settings | Automated |
| A2-21 | Contact Form | — | GET `/hubungi-kami` | 200; form with company info | Automated |
| A2-22 | Brochure Download | Brochure linked to product | GET `/brosur/{product}/download` | 200; file download or redirect | Automated |
| A2-23 | Missing Page | — | GET `/halaman-tidak-ada` | 404 custom error page | Automated |

### A3. Admin CRUD Operations

| ID | Area | Preconditions | Steps | Expected Result | Type |
|----|------|---------------|-------|-----------------|------|
| A3-01 | Dashboard — All Roles | Admin/Editor/Super Admin | GET `/admin/dashboard` | 200; respective dashboard view | Automated |
| A3-02 | Dashboard — Guest | Not authenticated | GET `/admin/dashboard` | Redirect to `admin.login` | Automated |
| A3-03 | News — Create | Super Admin | POST `/admin/news` with valid data | 302; news created; AuditTrail logged | Automated |
| A3-04 | News — Update | Super Admin | PUT `/admin/news/{id}` with changes | 302; updated; AuditTrail logged | Automated |
| A3-05 | News — Delete | Super Admin | DELETE `/admin/news/{id}` | 302; deleted; AuditTrail logged; cache cleared | Automated |
| A3-06 | News — HTML Sanitization | Super Admin | POST content containing `<script>` tags | Script stripped; safe HTML preserved | Automated |
| A3-07 | Product — CRUD | Super Admin/Admin | Full create/read/update/delete cycle | 302; success; cache cleared | Automated |
| A3-08 | Product — Brochure Association | Super Admin | Link product to brochure | Association saved; brochure downloadable | Automated |
| A3-09 | Auction — Create with Validation | Super Admin | POST with invalid data (missing required fields) | Validation errors; not created | Automated |
| A3-10 | Auction — Price Range Validation | Super Admin | Set `limit_price > estimated_price` | Validation error | Automated |
| A3-11 | Auction — Status Transition | Super Admin | Change status from `published` to `sold` with winning bid | Status updated; winning bid recorded | Automated |
| A3-12 | Report — Scheduled Posting | Super Admin | Create report with future `scheduled_at` | Report not visible until scheduled time | Automated |
| A3-13 | Hero Slide — Order Management | Super Admin | Change `order_position` values | Slides reordered on frontend | Automated |
| A3-14 | Hero Slide — Limit Enforcement | Super Admin | Create > `hero_slide_limit` slides | Extra slides inactive by default | Automated |
| A3-15 | Financing Config — Validation | Super Admin | Set `margin_rate <= 0` or `max_principal < min_principal` | Validation error | Automated |
| A3-16 | Financing Config — Editor Access | Editor | GET `/admin/financing-config` | 403 Forbidden | Automated |
| A3-17 | User Management — Super Admin Only | Super Admin | GET `/admin/users` | 200; user list | Automated |
| A3-18 | User Management — Admin Denied | Admin | GET `/admin/users` | 403 Forbidden | Automated |
| A3-19 | User Management — Editor Denied | Editor | GET `/admin/users` | 403 Forbidden | Automated |
| A3-20 | Role Management — Super Admin Only | Super Admin | GET `/admin/roles` | 200; role list | Automated |
| A3-21 | Company Info Update | Super Admin | POST company info with valid data | Updated; cache cleared | Automated |
| A3-22 | Site Settings Update | Super Admin | Update maintenance mode, hero delay, etc. | Saved; cache cleared | Automated |
| A3-23 | Security Settings Update | Super Admin | Update block threshold, rate limits, etc. | Saved; cache cleared | Automated |
| A3-24 | SMTP Settings — Password Encrypted | Super Admin | Save SMTP with password | Password encrypted in DB; never exposed | Automated |
| A3-25 | Composer Update — Confirmation | Admin | POST without `confirm` checkbox | Validation error "confirm" required | Automated |
| A3-26 | Composer Update — Editor Denied | Editor | GET `/admin/composer-update` | 403 Forbidden | Automated |

### A4. Livewire Components

| ID | Area | Preconditions | Steps | Expected Result | Type |
|----|------|---------------|-------|-----------------|------|
| A4-01 | Financing Simulation — Valid Input | — | Submit valid principal + margin + tenor | Correct monthly installment returned | Automated |
| A4-02 | Financing Simulation — Invalid Input | — | Submit principal < `min_principal` | Validation error | Automated |
| A4-03 | Financing Simulation — Profit Sharing | — | Submit profit sharing type with projected revenue | Calculation based on projected revenue | Automated |
| A4-04 | Newsletter Subscription | — | POST valid email | Subscription saved | Automated |
| A4-05 | Search — Results | Active content exists | Search by keyword | Relevant results returned | Automated |
| A4-06 | Search — Empty Query | — | Search empty string | No results; validation | Automated |
| A4-07 | Search — XSS Attempt | — | Search `<script>alert(1)</script>` | Input escaped; no XSS | Automated |

### A5. Cache Behavior

| ID | Area | Preconditions | Steps | Expected Result | Type |
|----|------|---------------|-------|-----------------|------|
| A5-01 | Company Info Cache | Cached data exists | Update company info | Cache cleared; new data served | Automated |
| A5-02 | News Cache | Cached home news | Create/update/delete news | Cache cleared | Automated |
| A5-03 | Product Cache | Cached product lists | Create/update/delete product | Cache cleared | Automated |
| A5-04 | Hero Slide Cache | Cached slides | Create/update/delete slide | Cache cleared | Automated |
| A5-05 | Office Cache | Cached offices | Create/update/delete office | Cache cleared | Automated |
| A5-06 | Security Settings Cache | Cached settings | Update security settings | Cache cleared | Automated |

---

## B. SECURITY TEST SCENARIOS

### B1. HTTP Security Headers

| ID | Area | Preconditions | Steps | Expected Result | Type |
|----|------|---------------|-------|-----------------|------|
| B1-01 | X-Frame-Options | — | GET any page | Header: `SAMEORIGIN` | Automated |
| B1-02 | X-Content-Type-Options | — | GET any page | Header: `nosniff` | Automated |
| B1-03 | X-XSS-Protection | — | GET any page | Header: `1; mode=block` | Automated |
| B1-04 | Referrer-Policy | — | GET any page | Header: `strict-origin-when-cross-origin` | Automated |
| B1-05 | Content-Security-Policy | — | GET any page | Header present; contains `default-src 'self'`, `frame-ancestors 'self'`, `form-action 'self'`, `base-uri 'self'`, `object-src 'none'` | Automated |
| B1-06 | Permissions-Policy | — | GET any page | Header: restrictive policy | Automated |
| B1-07 | Strict-Transport-Security | Production env | GET any page | `max-age=31536000; includeSubDomains` | Automated |
| B1-08 | COOP / COEP / CORP | — | GET any page | Headers: `same-origin` / `unsafe-none` / `same-origin` | Automated |
| B1-09 | X-Permitted-Cross-Domain | — | GET any page | Header: `none` | Automated |
| B1-10 | Server Header Removal | — | GET any page | No `X-Powered-By` or `Server` header | Automated |
| B1-11 | CSP Nonce — Script Tags | — | GET page with CSP inspection | Each `<script>` has valid `nonce` attribute | Manual |

### B2. Input Validation & Attack Detection

| ID | Area | Preconditions | Steps | Expected Result | Type |
|----|------|---------------|-------|-----------------|------|
| B2-01 | SQL Injection — URL Parameter | — | GET `/?id=1' OR '1'='1` | Blocked 403; SecurityLog created | Automated |
| B2-02 | SQL Injection — POST Body | — | POST with body containing `UNION SELECT * FROM users` | Blocked 403; SecurityLog created | Automated |
| B2-03 | SQL Injection — Time-based | — | GET `/?id=1; WAITFOR DELAY '0:0:5'` | Blocked 403; SecurityLog created | Automated |
| B2-04 | SQL Injection — Comment Injection | — | GET `/?id=1--` | Blocked 403 | Automated |
| B2-05 | XSS — Reflected | — | GET `/?q=<script>alert(1)</script>` | Blocked 403; SecurityLog created | Automated |
| B2-06 | XSS — Event Handler | — | POST `?body=<img onerror=alert(1) src=x>` | Blocked 403 | Automated |
| B2-07 | XSS — Encoded | — | GET `/?q=%3Cscript%3Ealert(1)%3C/script%3E` | Blocked 403 (after URL decode) | Automated |
| B2-08 | Path Traversal | — | GET `/?file=../../../etc/passwd` | Blocked 403; SecurityLog created | Automated |
| B2-09 | Path Traversal — Encoded | — | GET `/?file=..%2F..%2F..%2Fetc/passwd` | Blocked 403 | Automated |
| B2-10 | Command Injection | — | GET `/?cmd=; ls -la` | Blocked 403; SecurityLog created | Automated |
| B2-11 | Command Injection — Backtick | — | GET `/?cmd=\`cat /etc/passwd\`` | Blocked 403 | Automated |
| B2-12 | File Inclusion | — | GET `/?page=php://filter/convert.base64-encode/resource=config` | Blocked 403 | Automated |
| B2-13 | File Inclusion — Expect | — | GET `/?page=expect://id` | Blocked 403 | Automated |
| B2-14 | Suspicious User Agent | — | GET `/` with `User-Agent: sqlmap/1.6` | Blocked 403; SecurityLog | Automated |
| B2-15 | Suspicious User Agent — Scanner | — | GET `/` with `User-Agent: nikto/2.5` | Blocked 403 | Automated |
| B2-16 | Multiple Attack Attempts — Auto Block | — | Send 5+ attack requests from same IP | IP auto-blocked in `blocked_ips` table | Automated |
| B2-17 | Blocked IP — Subsequent Access | IP already blocked | Any request from blocked IP | 403 immediately (cached check) | Automated |
| B2-18 | Unblock IP — Admin Action | IP blocked | POST `/admin/security/blocked-ips/{id}/unblock` | IP removed; cache cleared | Automated |

### B3. XSS in Content (WYSIWYG)

| ID | Area | Preconditions | Steps | Expected Result | Type |
|----|------|---------------|-------|-----------------|------|
| B3-01 | HTML Sanitizer — Script Tag | — | Input `<script>alert(1)</script>` | Output: empty string | Automated |
| B3-02 | HTML Sanitizer — Event Handler | — | Input `<img onerror=alert(1) src=x>` | Output `<img src="x">` or stripped | Automated |
| B3-03 | HTML Sanitizer — javascript: URI | — | Input `<a href="javascript:alert(1)">link</a>` | Link stripped of javascript: | Automated |
| B3-04 | HTML Sanitizer — data: URI | — | Input `<iframe src="data:text/html,<script>...</script>">` | Iframe/data stripped | Automated |
| B3-05 | HTML Sanitizer — Safe Tags Allowed | — | Input `<p><strong>Safe</strong> <em>HTML</em></p>` | Safe tags preserved | Automated |
| B3-06 | HTML Sanitizer — External Links | — | Input `<a href="https://evil.com">bad</a>` | `target="_blank"` + `rel="noopener noreferrer"` added | Automated |
| B3-07 | HTML Sanitizer — CSS Expression | — | Input `<div style="color:expression(alert(1))">test</div>` | CSS expression stripped | Automated |
| B3-08 | News — Stored XSS Prevention | — | Create news with XSS content in `content` field | XSS sanitized before storage | Automated |
| B3-09 | Product — Stored XSS Prevention | — | Create product with XSS in `description` | XSS sanitized | Automated |
| B3-10 | WYSIWYG — Summernote Payload | — | Submit summernote content with embedded script | Script removed; safe HTML retained | Automated |

### B4. Rate Limiting & DDoS Protection

| ID | Area | Preconditions | Steps | Expected Result | Type |
|----|------|---------------|-------|-----------------|------|
| B4-01 | Web Rate Limit | — | Exceed `rate_limit_web` requests/minute | 429 response | Automated |
| B4-02 | Admin Rate Limit | Authenticated admin | Exceed `rate_limit_admin` requests/min | 429 response | Automated |
| B4-03 | Login Rate Limit | — | Exceed `rate_limit_login` attempts/IP | 429; subsequent attempts blocked | Automated |
| B4-04 | DDoS — Rapid Fire | — | 20+ requests in 5 seconds from same IP | Temporary block; DDoS protection triggered | Automated |
| B4-05 | DDoS — Endpoint Abuse | — | 30+ requests to same endpoint in 60s | Endpoint abuse detected; blocked | Automated |
| B4-06 | DDoS — Escalating Block | — | Multiple violations (1st, 2nd, 3rd+ occurrences) | Block duration increases: 5 → 15 → 60 → 360 → 1440 min → permanent | Automated |
| B4-07 | Rate Limit — Whitelist Bypass | IP in whitelist | Exceed rate limit | Not throttled | Automated |
| B4-08 | Rate Limit — Headers Present | — | GET any page after throttling threshold | `X-RateLimit-Limit` and `X-RateLimit-Remaining` headers | Automated |

### B5. RBAC & Authorization

| ID | Area | Preconditions | Steps | Expected Result | Type |
|----|------|---------------|-------|-----------------|------|
| B5-01 | Super Admin — Full Access | Super Admin | Access all admin routes | 200 on all | Automated |
| B5-02 | Admin — Content CRUD Allowed | Admin | Create/update/delete news, products, auctions | 200/302 | Automated |
| B5-03 | Admin — User Management Denied | Admin | GET `/admin/users` | 403 | Automated |
| B5-04 | Admin — Role Management Denied | Admin | GET `/admin/roles` | 403 | Automated |
| B5-05 | Admin — Menu Permission Denied | Admin | GET `/admin/menu-permissions` | 403 | Automated |
| B5-06 | Editor — Content CRUD Allowed | Editor | GET `/admin/news`, products, etc. | 200 | Automated |
| B5-07 | Editor — Settings Denied | Editor | GET `/admin/settings` | 403 | Automated |
| B5-08 | Editor — Composer Update Denied | Editor | GET `/admin/composer-update` | 403 | Automated |
| B5-09 | Editor — User Management Denied | Editor | GET `/admin/users` | 403 | Automated |
| B5-10 | Menu Permission — News Access | Editor assigned news | Access news routes | Allowed via menu permission check | Automated |
| B5-11 | Menu Permission — Unauthorized Menu | No permission for menu | Access route mapped to unauthorized menu | 403 | Automated |
| B5-12 | Inactive User — All Admin Denied | User `is_active=false` | Access any admin route | Logged out; redirected to login | Automated |

### B6. File Upload Security

| ID | Area | Preconditions | Steps | Expected Result | Type |
|----|------|---------------|-------|-----------------|------|
| B6-01 | Upload — Disallowed Extension | — | Upload `.exe` file | Validation error; rejected | Automated |
| B6-02 | Upload — Oversized File | — | Upload > 10MB file | Validation error; rejected | Automated |
| B6-03 | Upload — Double Extension | — | Upload `malicious.jpg.php` | Rejected by extension whitelist | Automated |
| B6-04 | Upload — Null Byte Injection | — | Upload `malicious.php%00.jpg` | Rejected | Automated |
| B6-05 | Upload — Valid Image | — | Upload valid `.jpg` 500KB | Accepted; stored; thumbnail generated | Automated |
| B6-06 | Upload — Image MIME Check | — | Upload `.jpg` with PHP content inside | MIME validation catches mismatch | Manual |
| B6-07 | Storage — Directory Traversal | — | GET `/storage/../../../etc/passwd` | Blocked by path traversal detection | Automated |
| B6-08 | Storage — Access Control | — | Access non-public storage files | 403 or 404 as appropriate | Automated |

### B7. CSRF & Session Security

| ID | Area | Preconditions | Steps | Expected Result | Type |
|----|------|---------------|-------|-----------------|------|
| B7-01 | CSRF — Missing Token | — | POST without `_token` | 419 Session expired | Automated |
| B7-02 | CSRF — Invalid Token | — | POST with random `_token` | 419 Session expired | Automated |
| B7-03 | Session — Fixation After Login | — | Compare session ID before/after login | Session ID regenerated | Automated |
| B7-04 | Session — Secure Cookie Flag | HTTPS | Inspect session cookie | `Secure`, `HttpOnly`, `SameSite` flags | Automated |
| B7-05 | Session — Encryption | — | Raw DB session content | Session data encrypted | Manual |
| B7-06 | Session — Periodic Regeneration | — | Stay logged in > 30 minutes | Session ID regenerated periodically | Automated |

### B8. Audit Trail & Logging

| ID | Area | Preconditions | Steps | Expected Result | Type |
|----|------|---------------|-------|-----------------|------|
| B8-01 | Audit — Model Create | Authenticated user | Create any auditable model | AuditTrail entry with action=`create`, `old_values=null`, `new_values` set | Automated |
| B8-02 | Audit — Model Update | Authenticated user | Update any auditable model | AuditTrail entry with action=`update`, both old/new values recorded | Automated |
| B8-03 | Audit — Model Delete | Authenticated user | Delete any auditable model | AuditTrail entry with action=`delete` | Automated |
| B8-04 | Audit — Login Event | — | Successful login | AuditTrail entry with action=`login` | Automated |
| B8-05 | Audit — Logout Event | Authenticated user | Logout | AuditTrail entry with action=`logout` | Automated |
| B8-06 | Audit — Failed Login | — | Failed login attempt | No AuditTrail (only SecurityLog) | Automated |
| B8-07 | SecurityLog — Attack Attempt | — | Send SQL injection payload | SecurityLog entry with threat_type, IP, payload | Automated |
| B8-08 | SecurityLog — Auto-block | — | 5+ attack attempts from same IP | BlockedIp created; SecurityLog.was_blocked=true | Automated |
| B8-09 | SecurityLog — Payload Redaction | — | Attack with password field | Payload.password = `[REDACTED]` | Automated |

### B9. Password Policy

| ID | Area | Preconditions | Steps | Expected Result | Type |
|----|------|---------------|-------|-----------------|------|
| B9-01 | Strong Password — Min Length | — | Password `Abc123!` (7 chars) | Validation fails (min 12) | Automated |
| B9-02 | Strong Password — Missing Uppercase | — | Password `abcdef123!@#` | Validation fails | Automated |
| B9-03 | Strong Password — Missing Lowercase | — | Password `ABCDEF123!@#` | Validation fails | Automated |
| B9-04 | Strong Password — Missing Number | — | Password `Abcdefgh!@#` | Validation fails | Automated |
| B9-05 | Strong Password — Missing Special | — | Password `Abcdef123456` | Validation fails | Automated |
| B9-06 | Strong Password — Valid | — | Password `Kuat!2024Babel` | Validation passes | Automated |
| B9-07 | Strong Password — Common Blocked | — | Password `password123!` | Validation fails (common password) | Automated |
| B9-08 | Strong Password — Sequential Chars | — | Password `Abcd1234!wxyz` | Validation fails (sequential) | Automated |
| B9-09 | Strong Password — Repeated Chars | — | Password `Abbbb!2024Xyz` | Validation fails (repeated) | Automated |
| B9-10 | Password History — Reuse Check | User has 5 history entries | Change to identical password | Validation fails | Automated |
| B9-11 | Password History — Max Entries | User has 5 entries | Change to new password | History pruned to keep last 5 | Automated |

### B10. Encryption & Sensitive Data

| ID | Area | Preconditions | Steps | Expected Result | Type |
|----|------|---------------|-------|-----------------|------|
| B10-01 | SMTP Password — Encrypted at Rest | — | Save SMTP setting with password | DB field contains encrypted string | Automated |
| B10-02 | SMTP Password — Decryption | — | Retrieve SMTP setting | `getDecryptedPassword()` returns plaintext | Automated |
| B10-03 | SMTP Password — Never in Logs | — | Trigger error with SMTP config | Password not in log output | Manual |
| B10-04 | Email Password — Encrypted | — | Save email setting with password | DB field encrypted | Automated |

---

## C. INTEGRATION TEST SCENARIOS

### C1. Complaint (Whistleblowing) Full Workflow

| ID | Area | Preconditions | Steps | Expected Result | Type |
|----|------|---------------|-------|-----------------|------|
| C1-01 | Submit Complaint — Anonymous | — | POST complaint with `is_anonymous=true`, minimal data | Created; ticket_number generated; `name/email/phone` null | Automated |
| C1-02 | Submit Complaint — Identified | — | POST complaint with full details | Created; status=`pending` | Automated |
| C1-03 | Submit Complaint — XSS in Subject | — | POST with XSS in `subject` | XSS sanitized; saved safely | Automated |
| C1-04 | Admin — View Complaint List | Super Admin | GET `/admin/complaints` | 200; ticket numbers visible | Automated |
| C1-05 | Admin — Change Complaint Status | Super Admin | PUT status to `investigating` | Updated; AuditTrail logged | Automated |
| C1-06 | Admin — Resolve Complaint | Super Admin | PUT `status=resolved`, add `admin_notes` | Resolved; `resolved_at` set | Automated |
| C1-07 | Ticket Number — Uniqueness | — | Generate 100+ tickets | All unique; format `WBS-YYYYMMDD-XXXXXX` | Automated |
| C1-08 | Ticket Number — Format Validation | — | Check format | Matches `/^WBS-\d{8}-[A-Z0-9]{6}$/` | Automated |

### C2. Customer Complaint Full Workflow

| ID | Area | Preconditions | Steps | Expected Result | Type |
|----|------|---------------|-------|-----------------|------|
| C2-01 | Submit — Valid | — | POST with all required fields | Created; `ticket_number` generated | Automated |
| C2-02 | Submit — Validation | — | POST with missing required fields | Validation errors | Automated |
| C2-03 | Admin — Assign Handler | Super Admin | PUT `handled_by` to admin user | Assigned; status may auto-update | Automated |
| C2-04 | Admin — Resolve | Super Admin | PUT to resolved | `resolved_at` set; resolution logged | Automated |
| C2-05 | Ticket Format | — | Check format | Matches `/^ADU-\d{8}-[A-Z0-9]{6}$/` | Automated |

### C3. Financing Calculator Integration

| ID | Area | Preconditions | Steps | Expected Result | Type |
|----|------|---------------|-------|-----------------|------|
| C3-01 | Calculation — Valid Input | Config exists | POST `principal=100jt, margin=12%, tenor=36` | Monthly installment returned; audit logged | Automated |
| C3-02 | Calculation — Invalid Principal | Config exists | POST principal < `min_principal` | Validation error | Automated |
| C3-03 | Calculation — Max Principal | Config exists | POST principal > `max_principal` | Validation error | Automated |
| C3-04 | Calculation — Invalid Tenor | Config exists | POST tenor not in `available_tenors` | Validation error | Automated |
| C3-05 | Calculation — Profit Sharing | Config exists | POST with `profit_sharing` type | Based on `projected_revenue` | Automated |
| C3-06 | Config — Active Only | Mixed configs | Query active configs | Only active returned | Automated |

### C4. CacheService Integration

| ID | Area | Preconditions | Steps | Expected Result | Type |
|----|------|---------------|-------|-----------------|------|
| C4-01 | getCompanyInfo | Data exists | Call CacheService::getCompanyInfo | Returns cached CompanyInfo | Automated |
| C4-02 | getHeroSlides | Slides exist | Call CacheService::getHeroSlides() | Returns limited slides | Automated |
| C4-03 | clearAll | Various caches set | Call CacheService::clearAll() | All cache keys cleared | Automated |
| C4-04 | getHomeProducts | Products exist | Call CacheService::getHomeProducts(6) | Returns ≤6 active products | Automated |

### C5. Image Processing

| ID | Area | Preconditions | Steps | Expected Result | Type |
|----|------|---------------|-------|-----------------|------|
| C5-01 | Image Upload — Valid | — | Upload 800x600 JPEG | Compressed variants generated; WebP/AVIF created | Automated |
| C5-02 | Image Upload — Too Large Dimensions | — | Upload > 3840x2160 image | Rejected or resized | Automated |
| C5-03 | Image Upload — Too Small | — | Upload < 320x240 image | Rejected | Manual |
| C5-04 | Image Upload — Invalid Type | — | Upload `.gif` | Accepted (in whitelist) or processed | Automated |
| C5-05 | Image Delete — Variants Cleanup | Image with variants exists | Delete image | All variant files removed | Manual |

### C6. Recovery & Resilience

| ID | Area | Preconditions | Steps | Expected Result | Type |
|----|------|---------------|-------|-----------------|------|
| C6-01 | Maintenance Mode — Enabled | SiteSetting toggle | GET `/` | Maintenance page; allowed IPs bypass | Automated |
| C6-02 | Maintenance Mode — Specific Pages | Page-level maintenance | GET maintained page | Maintenance message per page | Automated |
| C6-03 | Maintenance Mode — Admin Bypass | Authenticated admin | Any admin route during maintenance | 200; not redirected | Automated |
| C6-04 | DB Connection Failure | DB down | Any page | Graceful error; no stack trace leaked | Manual |
| C6-05 | Cache Failure | Cache down | Any page | Falls through; no exception | Manual |

---

## D. PERFORMANCE & OPTIMIZATION

| ID | Area | Preconditions | Steps | Expected Result | Type |
|----|------|---------------|-------|-----------------|------|
| D-01 | N+1 Query Check — Auctions | 50 auctions exist | List auctions with related data | No N+1 (eager loading used) | Manual/Profiling |
| D-02 | N+1 Query Check — News | 50 news with images | List news with images | Eager-loaded; single query | Manual/Profiling |
| D-03 | Index Usage — Key Queries | — | Explain slow queries | Indexes used on `status`, `is_active`, `published_at`, `type`, `slug` | Manual |
| D-04 | Response Time — Public Pages | — | Measure homepage TTFB | < 500ms (cached) | Manual |
| D-05 | Response Time — Admin Pages | Authenticated | Measure dashboard load | < 1s | Manual |

---

## E. COVERAGE MATRIX

| Layer | Total Scenarios | Automated | Manual |
|-------|-----------------|-----------|--------|
| Authentication & Session | 18 | 18 | 0 |
| Public Pages | 23 | 23 | 0 |
| Admin CRUD | 26 | 26 | 0 |
| Livewire Components | 7 | 7 | 0 |
| Cache Behavior | 6 | 6 | 0 |
| HTTP Security Headers | 11 | 10 | 1 |
| Input Validation & Attack Detection | 18 | 18 | 0 |
| XSS in Content | 10 | 10 | 0 |
| Rate Limiting & DDoS | 8 | 8 | 0 |
| RBAC & Authorization | 12 | 12 | 0 |
| File Upload Security | 8 | 7 | 1 |
| CSRF & Session Security | 6 | 5 | 1 |
| Audit Trail & Logging | 9 | 9 | 0 |
| Password Policy | 11 | 11 | 0 |
| Encryption & Sensitive Data | 4 | 3 | 1 |
| Complaint Workflow | 8 | 8 | 0 |
| Customer Complaint Workflow | 5 | 5 | 0 |
| Financing Calculator Integration | 6 | 6 | 0 |
| CacheService Integration | 4 | 4 | 0 |
| Image Processing | 5 | 3 | 2 |
| Recovery & Resilience | 5 | 3 | 2 |
| Performance & Optimization | 5 | 0 | 5 |
| **TOTAL** | **215** | **202** | **13** |
