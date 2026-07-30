---
title: Frontend Components
description: Blade components, layouts, CSS architecture, and JS setup
tags:
  - frontend
  - blade
  - alpinejs
  - tailwind
---

# Frontend Components

> [!abstract] Stack
> **Blade** templating + **Alpine.js 3.x** for interactivity + **Tailwind CSS v4** for styling + **Vite** for building.

## Layouts

### `layouts/admin.blade.php` — Admin Layout
- Fixed sidebar (72 width) with scrollable nav
- Sticky header with user menu
- Responsive (sidebar collapses on mobile)
- CSP nonce on all `<script>` tags
- Skip-to-content link for accessibility
- Fade-in-up content animation

### `components/frontend-layout.blade.php` — Frontend Layout
- Full SEO meta tags (OG, Twitter, canonical)
- Preconnect/DNS-prefetch for fonts & storage
- Device fingerprint for session security
- Fixed navigation with scroll shadow
- Prayer time sidebar widget
- Footer with social media links

## Key Components

### Hero Slider — `components/frontend/hero-slider.blade.php`
> [!tip] Alpine.js Powered
> Full-featured slider with:
> - Responsive image sources (AVIF, WebP, fallback)
> - Autoplay with configurable delay
> - Touch/swipe support
> - Keyboard accessible
> - Dot indicators + navigation arrows

### Card Component — `components/frontend/card.blade.php`
Reusable card with:
- Image with hover zoom
- Category badge
- Title with hover color transition
- Description section
- CTA link with arrow animation

### Stats Section — `components/frontend/stats-section.blade.php`
Animated counter section with:
- SVG icons per stat
- Gradient icon backgrounds
- Counter animation on scroll
- Subtle background blur effects

## CSS Architecture

### `resources/css/app.css` — Frontend Styles
- Custom easing variables (`--ease-out`, `--ease-smooth`, `--ease-spring`)
- Animation utilities: `card-hover`, `btn-press`, `stagger-container`, `stagger-item`
- Utility classes: `glass-premium`, `shadow-hover`, `enter-scale`
- Reduced motion support via `prefers-reduced-motion`
- Focus-visible outlines for accessibility

### `resources/css/admin.css` — Admin Styles
- Admin-specific theme with emerald colors
- `admin-btn` — Button press feedback
- `admin-stagger` — Staggered list animations
- `animate-fade-in-up` — Entrance animation
- Custom scrollbar styles
- Print styles

## JavaScript

### `resources/js/app.js` — Main Entry
- Alpine.js initialization
- Hero slider component
- Statistics counter
- Prayer time widget
- Smooth scroll

### Alpine.js Components
| Component | File | Description |
|-----------|------|-------------|
| `heroSlider()` | Inline | Slideshow with autoplay |
| `prayerWidgetSidebar()` | Inline | Prayer times widget |
| `adminLayout()` | Inline | Sidebar toggle + navigation |
| `fileUpload()` | Inline | File upload with preview |

## Responsive Breakpoints

| Breakpoint | Width | Usage |
|------------|-------|-------|
| `sm` | 640px | Tablet landscape |
| `md` | 768px | Tablet portrait |
| `lg` | 1024px | Desktop |
| `xl` | 1280px | Large desktop |

## Related

- [[Architecture Overview]]
- [[Admin Panel]]
