/**
 * Frontend Application - Optimized
 * Lazy loads heavy libraries and uses efficient event handling
 */

import "./bootstrap";
import "./cache";
import collapse from "@alpinejs/collapse";

// Suppress errors from browser extensions
window.addEventListener("unhandledrejection", (event) => {
    // Suppress Alpine transition cancellation warnings
    if (event.reason && event.reason.isFromCancelledTransition) {
        event.preventDefault();
        return;
    }
    // Suppress browser extension errors
    if (
        (event.reason &&
            event.reason.message &&
            event.reason.message.includes("message channel closed")) ||
        (event.reason.message &&
            event.reason.message.includes(
                "Listener indicated an asynchronous response",
            ))
    ) {
        event.preventDefault();
    }
});

// ===================================================
// Register Alpine Components via window.* (Livewire-safe)
// Livewire bundles its own Alpine instance. Using window.*
// functions avoids duplicate Alpine instances and ensures
// components are available when Livewire's Alpine initializes.
// ===================================================

// =====================================================================
function registerAlpineComponents() {
    window.Alpine.data("statsCounter", () => ({
        value: 0,
        target: 0,
        suffix: "",
        prefix: "",
        hasAnimated: false,
        observer: null,

        init() {
            const el = this.$el;
            this.target = parseInt(el.dataset.target) || 0;
            this.suffix = el.dataset.suffix || "";
            this.prefix = el.dataset.prefix || "";
            this.value = 0;

            this.observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting && !this.hasAnimated) {
                            this.hasAnimated = true;
                            this.animateCount();
                            this.observer.disconnect();
                        }
                    });
                },
                { threshold: 0.3 },
            );
            this.observer.observe(el);
        },

        animateCount() {
            const duration = 2000;
            const start = performance.now();
            const easeOutCubic = (t) => 1 - Math.pow(1 - t, 3);

            const frame = (now) => {
                const elapsed = now - start;
                const progress = Math.min(elapsed / duration, 1);
                const easedProgress = easeOutCubic(progress);
                this.value = Math.round(easedProgress * this.target);
                if (progress < 1) requestAnimationFrame(frame);
                else this.value = this.target;
            };

            requestAnimationFrame(frame);
        },

        destroy() {
            if (this.observer) this.observer.disconnect();
        },
    }));

    // Scroll Progress (uses Alpine.data lookup)
    window.Alpine.data("scrollProgress", () => ({
        progress: 0,

        init() {
            const updateProgress = () => {
                const scrollTop = window.scrollY;
                const docHeight =
                    document.documentElement.scrollHeight - window.innerHeight;
                this.progress = docHeight > 0 ? scrollTop / docHeight : 0;
            };
            window.addEventListener("scroll", updateProgress, {
                passive: true,
            });
            updateProgress();
        },
    }));
}

// If Alpine already loaded (e.g. via Livewire), register immediately.
// Otherwise wait for alpine:init event.
if (window.Alpine) {
    registerAlpineComponents();
} else {
    document.addEventListener("alpine:init", registerAlpineComponents);
}

// ============================================
// PRODUCT GALLERY — Zoom + Lightbox
// ============================================
window.productGallery = () => ({
    lightboxOpen: false,
    zoomActive: false,
    zoomX: 50,
    zoomY: 50,
    loaded: false,
    imageEl: null,

    init() {
        this.imageEl = this.$refs.mainImage;
        if (this.imageEl && this.imageEl.complete) {
            this.loaded = true;
        }
    },

    onImageLoad() {
        this.loaded = true;
    },

    handleMouseMove(e) {
        const rect = this.imageEl.getBoundingClientRect();
        this.zoomX = ((e.clientX - rect.left) / rect.width) * 100;
        this.zoomY = ((e.clientY - rect.top) / rect.height) * 100;
    },

    openLightbox() {
        this.lightboxOpen = true;
        document.body.style.overflow = "hidden";
    },

    closeLightbox() {
        this.lightboxOpen = false;
        document.body.style.overflow = "";
    },
});

// Lazy load SweetAlert2 only when needed
let SwalPromise = null;
window.Swal = new Proxy(
    {},
    {
        get(_, prop) {
            if (!SwalPromise) {
                SwalPromise = import("sweetalert2").then((module) => {
                    window.Swal = module.default;
                    return module.default;
                });
            }
            return async (...args) => {
                const Swal = await SwalPromise;
                return Swal[prop](...args);
            };
        },
    },
);

// NOTE: Swiper lazy loader removed — frontend uses Alpine-based hero slider, not Swiper.

// ===================================================
// Rupiah Formatting Helper for Alpine/Livewire inputs
// Prevents regex-in-Alpine-expression issues
// Guard prevents override of preloaded version.
// ===================================================
window.formatRupiah = window.formatRupiah || {
    init(el, wireField) {
        if (window.Livewire) {
            const val = window.Livewire.find(el)?.get?.(wireField);
            if (val) el.value = this.fmt(val);
        }
    },
    fmt(v) {
        return v
            ? Number(String(v).replace(/[^0-9]/g, "")).toLocaleString("id-ID")
            : "";
    },
    raw(v) {
        return String(v).replace(/[^0-9]/g, "");
    },
    input(el, wireField) {
        const raw = this.raw(el.value);
        const formatted = raw ? Number(raw).toLocaleString("id-ID") : "";
        const pos = el.selectionStart;
        const oldLen = el.value.length;

        // Guard: skip if already formatted — prevents re-entrant loop
        // caused by el.value = formatted firing another @input event.
        if (el.value === formatted) return;

        el.value = formatted;
        let newPos = pos + (formatted.length - oldLen);
        if (newPos < 0) newPos = 0;
        if (newPos > formatted.length) newPos = formatted.length;
        el.setSelectionRange(newPos, newPos);
        if (window.Livewire) {
            const comp = window.Livewire.find(el);
            if (comp) comp.set(wireField, raw, false);
        }
    },
    blur(el, wireField) {
        if (!window.Livewire) return;
        const comp = window.Livewire.find(el);
        if (!comp) return;
        const val = comp.get(wireField);
        el.value = val ? this.fmt(val) : el.value;
    },
};

// ============================================
// HIGH-END v2: Lazy load Leaflet (map-utils.js)
// Only loads on pages with map containers
// ============================================
const lazyLoadMaps = () => {
    if (document.querySelector('[data-map-init]')) {
        import('./map-utils.js').then(() => {
            document.querySelectorAll('[data-map-init]').forEach(el => {
                try {
                    const points = JSON.parse(el.dataset.points || '[]');
                    const opts = JSON.parse(el.dataset.options || '{}');
                    if (window.BPRSMaps?.initSimpleMap) {
                        window.BPRSMaps.initSimpleMap(el, points, opts);
                    }
                } catch(e) {
                    console.warn('Map init failed:', e);
                }
            });
        }).catch(() => {
            // Silently fail — map is non-critical
        });
    }
};

// ============================================
// Progressive Image Loading with blur-up effect
// Optimized: uses IntersectionObserver for offscreen images
// ============================================
const initProgressiveImages = () => {
    // Use native lazy loading + blur-up for progressive loading
    const images = document.querySelectorAll('img[loading="lazy"], .img-progressive');

    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                const img = entry.target;

                if (img.complete && img.naturalHeight !== 0) {
                    img.classList.add("loaded");
                    img.setAttribute('data-loaded', 'true');
                } else {
                    img.addEventListener("load", () => {
                        img.classList.add("loaded");
                        img.setAttribute('data-loaded', 'true');
                    }, { once: true });
                    // Force re-check if already loaded but event missed
                    if (img.complete) {
                        img.classList.add("loaded");
                        img.setAttribute('data-loaded', 'true');
                    }
                }

                imageObserver.unobserve(img);
            });
        }, {
            rootMargin: '200px 0px', // Start loading 200px before viewport
            threshold: 0.01
        });

        images.forEach((img) => imageObserver.observe(img));
    } else {
        // Fallback for older browsers
        images.forEach((img) => {
            if (img.complete && img.naturalHeight !== 0) {
                img.classList.add("loaded");
                img.setAttribute('data-loaded', 'true');
                return;
            }
            img.addEventListener("load", () => {
                img.classList.add("loaded");
                img.setAttribute('data-loaded', 'true');
            }, { once: true });
        });
    }
};

// Optimized Intersection Observer for scroll animations
const initScrollAnimations = () => {
    const animatedElements = document.querySelectorAll(
        ".fade-in-section, .slide-in-left, .slide-in-right, .scale-in, .stats-counter, .reveal-on-scroll",
    );

    if (!animatedElements.length) return;

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;

                const el = entry.target;
                el.classList.add("is-visible");

                // Counter animation
                if (el.classList.contains("stats-counter")) {
                    animateCounter(el);
                }

                // Reveal animation
                if (el.classList.contains("reveal-on-scroll")) {
                    el.style.opacity = "1";
                    el.style.transform = "translateY(0)";
                }

                observer.unobserve(el);
            });
        },
        { threshold: 0.1, rootMargin: "0px 0px -50px 0px" },
    );

    animatedElements.forEach((el) => {
        if (el.classList.contains("reveal-on-scroll")) {
            el.style.opacity = "0";
            el.style.transform = "translateY(30px)";
            el.style.transition = "opacity 0.8s ease, transform 0.8s ease";
        }
        observer.observe(el);
    });
};

// Counter Animation - optimized with requestAnimationFrame
const animateCounter = (element) => {
    const target = parseInt(element.dataset.target, 10);
    const suffix = element.dataset.suffix || "";
    const duration = 2000;
    const startTime = performance.now();

    const updateCounter = (currentTime) => {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);

        // Easing function for smooth animation
        const easeOutQuart = 1 - Math.pow(1 - progress, 4);
        const current = Math.floor(target * easeOutQuart);

        element.textContent = current + suffix;

        if (progress < 1) {
            requestAnimationFrame(updateCounter);
        }
    };

    requestAnimationFrame(updateCounter);
};

// Staggered Animation for Cards - optimized
const initStaggeredAnimations = () => {
    document.querySelectorAll(".stagger-container").forEach((container) => {
        container.querySelectorAll(".stagger-item").forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });
    });
};

// Throttled Parallax Effect
const initParallax = () => {
    const parallaxElements = document.querySelectorAll(".parallax");
    if (!parallaxElements.length) return;

    let ticking = false;

    const updateParallax = () => {
        const scrolled = window.pageYOffset;
        parallaxElements.forEach((element) => {
            const speed = parseFloat(element.dataset.speed) || 0.5;
            element.style.transform = `translateY(${-(scrolled * speed)}px)`;
        });
        ticking = false;
    };

    window.addEventListener(
        "scroll",
        () => {
            if (!ticking) {
                requestAnimationFrame(updateParallax);
                ticking = true;
            }
        },
        { passive: true },
    );
};

// Initialize on DOM ready
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
} else {
    init();
}

function init() {
    // HIGH-END v2: Optimized init sequence
    // 1. Critical: Progressive images (priority)
    initProgressiveImages();

    // 2. Lazy load Leaflet maps if needed
    lazyLoadMaps();

    // 3. Defer non-critical — let browser breathe first
    if (window.requestIdleCallback) {
        requestIdleCallback(() => initScrollAnimations(), { timeout: 2000 });
        requestIdleCallback(() => initStaggeredAnimations(), { timeout: 3000 });
        requestIdleCallback(() => initParallax(), { timeout: 4000 });
    } else {
        setTimeout(initScrollAnimations, 500);
        setTimeout(initStaggeredAnimations, 1000);
        setTimeout(initParallax, 1500);
    }
}
