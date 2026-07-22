# ============================================================
# PERFORMANCE DEPLOYMENT GUIDE
# ============================================================
# BPRS Bangka Belitung CMS - Performance Optimization Guide
# ============================================================

## Overview

This guide covers all performance optimizations for both load time
and high concurrent connections.

## Quick Start

### 1. Install Redis
```bash
# Ubuntu/Debian
sudo apt install redis-server
sudo systemctl enable redis-server

# Verify
redis-cli ping  # Should return PONG
```

### 2. Install PHP Redis Extension
```bash
sudo apt install php8.3-redis
sudo systemctl restart php8.3-fpm
```

### 3. Update .env
```bash
# Copy performance settings from database/.env.performance
# Key changes:
CACHE_STORE=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

### 4. Run Database Indexes
```bash
# Execute the SQL file
mysql -u username -p database_name < database/performance_indexes.sql
```

### 5. Install OPcache
```bash
sudo cp database/performance_opcache.ini /etc/php/8.3/fpm/conf.d/20-opcache.ini
sudo systemctl restart php8.3-fpm
```

### 6. Optimize Laravel
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

## Architecture Overview

### High Concurrency Stack
```
User Request
    ↓
Nginx (gzip, static caching, SSL)
    ↓
PHP-FPM (process manager, opcache)
    ↓
Laravel (middleware, controllers)
    ↓
Redis (cache, sessions, queues)
    ↓
MySQL (optimized indexes)
```

## Load Time Optimizations

### Frontend
- ✅ Hero slider uses AVIF/WebP with srcset
- ✅ Logo preloaded with fetchpriority="high"
- ✅ Static assets served with immutable cache headers
- ✅ CSS/JS code-split by Vite
- ✅ Lazy loading on below-fold images
- ✅ Scroll animations with Intersection Observer

### Backend
- ✅ ResponseCache for full page caching (Spatie)
- ✅ Model caching in CacheService (30min-24h TTL)
- ✅ View fragment caching (navbar, footer)
- ✅ Eager loading to prevent N+1 queries
- ✅ Selective column queries

### Database
- ✅ Composite indexes for common queries
- ✅ Proper column types (utf8mb4)

## Concurrency Optimizations

### Redis (Replacing File-based Cache)
| Feature | File | Redis | Improvement |
|---------|------|-------|-------------|
| Cache Read | ~5ms | ~0.5ms | 10x faster |
| Session Lock | File lock | Atomic ops | No contention |
| Queue Jobs | DB polling | Push/pull | 5x faster |

### PHP-FPM Tuning
```ini
pm = dynamic
pm.max_children = 50
pm.start_servers = 5
pm.min_spare_servers = 3
pm.max_spare_servers = 10
pm.max_requests = 500
```

### Nginx Tuning
- Gzip compression enabled
- Static asset caching (1 year, immutable)
- FastCGI buffer optimization
- Open file cache
- Keepalive connections

## Monitoring

### Check Redis
```bash
redis-cli info stats
redis-cli monitor  # Real-time view
```

### Check OPcache
```bash
php -r "print_r(opcache_get_status());"
```

### Check PHP-FPM
```bash
curl http://localhost/fpm-status
```

### Load Test
```bash
# Using Apache Bench
ab -n 1000 -c 50 https://your-domain.com/

# Using wrk
wrk -t12 -c400 -d30s https://your-domain.com/
```

## Troubleshooting

### Redis Connection Failed
```bash
# Check Redis is running
sudo systemctl status redis-server

# Check Redis config
redis-cli CONFIG GET bind
```

### High Memory Usage
```bash
# Monitor Redis memory
redis-cli INFO memory

# Flush old cache
redis-cli FLUSHDB
```

### PHP-FPM Not Starting
```bash
# Check error log
tail -f /var/log/php8.3-fpm-error.log

# Test config
php-fpm8.3 -t
```

## Production Checklist

- [ ] Redis installed and running
- [ ] PHP Redis extension installed
- [ ] .env updated with Redis settings
- [ ] Database indexes applied
- [ ] OPcache enabled
- [ ] PHP-FPM tuned for concurrency
- [ ] Nginx configured with gzip and caching
- [ ] Laravel caches built (config, route, view, event)
- [ ] SSL certificate installed
- [ ] CDN configured (optional)
- [ ] Load testing completed
