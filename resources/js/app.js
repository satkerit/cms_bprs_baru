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

// Hero Slider Component
window.heroSlider = (delay = 7000) => ({
    active: 0,
    total: 2,
    autoplay: null,
    isAnimating: false,
    direction: "next",
    touchStartX: 0,
    touchEndX: 0,

    init() {
        const countEl = document.querySelector('[x-ref="slideCount"]');
        if (countEl) {
            this.total = parseInt(countEl.value) || 2;
        }
        this.delay = delay || 7000;
        this.startAutoplay();
    },

    handleTouchStart(e) {
        this.stopAutoplay();
        this.touchStartX = e.touches[0].clientX;
    },

    handleTouchEnd(e) {
        this.touchEndX = e.changedTouches[0].clientX;
        const diff = this.touchStartX - this.touchEndX;
        if (Math.abs(diff) > 50) {
            diff > 0 ? this.next() : this.prev();
        }
        this.startAutoplay();
    },

    startAutoplay() {
        this.stopAutoplay();
        this.autoplay = setInterval(() => this.next(), this.delay);
    },

    stopAutoplay() {
        if (this.autoplay) clearInterval(this.autoplay);
    },

    goTo(index) {
        if (this.isAnimating || index === this.active) return;
        this.direction = index > this.active ? "next" : "prev";
        this.isAnimating = true;
        this.active = index;
        setTimeout(() => {
            this.isAnimating = false;
        }, 500);
        this.stopAutoplay();
        this.startAutoplay();
    },

    next() {
        if (this.isAnimating || this.total <= 1) return;
        this.goTo((this.active + 1) % this.total);
    },

    prev() {
        if (this.isAnimating || this.total <= 1) return;
        this.goTo((this.active - 1 + this.total) % this.total);
    },
});

// Register Alpine plugins via alpine:init (Livewire-safe)
// Always use the event listener to ensure Alpine hasn't started yet.
document.addEventListener("alpine:init", () => {
    window.Alpine.plugin(collapse);
});

// Prayer Widget Sidebar Controller
window.prayerWidgetSidebar = () => ({
    show: true,
    minimized: false,
    topPosition: 96,
    ready: false,

    init() {
        // Defer rendering to improve FCP
        setTimeout(() => {
            this.ready = true;
            if (window.innerWidth < 1024) {
                this.minimized = true;
            }
            this.calculateTopPosition();
            window.addEventListener(
                "resize",
                () => {
                    this.calculateTopPosition();
                    this.minimized = window.innerWidth < 1024;
                },
                { passive: true },
            );
        }, 1500);
    },

    calculateTopPosition() {
        const header = document.querySelector("header");
        if (header) {
            this.topPosition = header.offsetHeight + 16;
        }
    },
});

// Prayer Time Widget
window.prayerTimeWidget = () => ({
    loading: true,
    error: null,
    location: "Jakarta, Indonesia",
    latitude: -6.2088,
    longitude: 106.8456,
    currentTime: "",
    currentDate: "",
    prayerTimes: [],
    nextPrayer: null,
    countdown: { hours: "00", minutes: "00", seconds: "00" },
    timeInterval: null,
    countdownInterval: null,
    lastDate: null,

    init() {
        this.updateCurrentTime();
        this.timeInterval = setInterval(() => this.updateCurrentTime(), 1000);
        const deferredInit = () => this.getUserLocation();
        if (window.requestIdleCallback) {
            requestIdleCallback(deferredInit, { timeout: 3000 });
        } else {
            setTimeout(deferredInit, 1000);
        }
    },

    async getUserLocation() {
        if (!navigator.geolocation) {
            this.fetchPrayerTimes();
            return;
        }
        if (navigator.permissions) {
            try {
                const permission = await navigator.permissions.query({
                    name: "geolocation",
                });
                if (permission.state === "denied") {
                    this.fetchPrayerTimes();
                    return;
                }
            } catch (e) {
                /* ignore */
            }
        }
        navigator.geolocation.getCurrentPosition(
            (position) => {
                this.latitude = position.coords.latitude;
                this.longitude = position.coords.longitude;
                this.reverseGeocode();
                this.fetchPrayerTimes();
            },
            () => this.fetchPrayerTimes(),
            { timeout: 10000, maximumAge: 300000, enableHighAccuracy: false },
        );
    },

    async reverseGeocode() {
        try {
            const r = await fetch(
                `https://nominatim.openstreetmap.org/reverse?lat=${this.latitude}&lon=${this.longitude}&format=json`,
            );
            const d = await r.json();
            if (d.address) {
                const city =
                    d.address.city ||
                    d.address.town ||
                    d.address.village ||
                    d.address.county;
                const state = d.address.state;
                this.location =
                    city && state ? `${city}, ${state}` : "Indonesia";
            }
        } catch (e) {
            /* ignore */
        }
    },

    async fetchPrayerTimes() {
        this.loading = true;
        this.error = null;
        try {
            const r = await fetch(
                `/api/prayer-times?latitude=${this.latitude}&longitude=${this.longitude}`,
            );
            const d = await r.json();
            if (d.success && d.timings) {
                this.processPrayerTimes(d.timings);
                this.findNextPrayer();
                this.startCountdown();
            } else {
                this.error = "Gagal memuat jadwal sholat";
            }
        } catch (e) {
            this.error = "Terjadi kesalahan";
        } finally {
            this.loading = false;
        }
    },

    processPrayerTimes(timings) {
        const prayers = [
            { name: "Subuh", key: "Fajr", icon: "🌅" },
            { name: "Dzuhur", key: "Dhuhr", icon: "☀️" },
            { name: "Ashar", key: "Asr", icon: "🌤️" },
            { name: "Maghrib", key: "Maghrib", icon: "🌆" },
            { name: "Isya", key: "Isha", icon: "🌙" },
        ];
        this.prayerTimes = prayers.map((p) => ({
            name: p.name,
            time: timings[p.key],
            icon: p.icon,
            key: p.key,
            isNext: false,
        }));
    },

    findNextPrayer() {
        const now = new Date();
        const currentMinutes = now.getHours() * 60 + now.getMinutes();
        for (let prayer of this.prayerTimes) {
            const [h, m] = prayer.time.split(":").map(Number);
            if (h * 60 + m > currentMinutes) {
                prayer.isNext = true;
                this.nextPrayer = prayer;
                return;
            }
        }
        if (this.prayerTimes.length > 0) {
            this.prayerTimes[0].isNext = true;
            this.nextPrayer = this.prayerTimes[0];
        }
    },

    startCountdown() {
        if (this.countdownInterval) clearInterval(this.countdownInterval);
        this.updateCountdown();
        this.countdownInterval = setInterval(
            () => this.updateCountdown(),
            1000,
        );
    },

    updateCountdown() {
        if (!this.nextPrayer) return;
        const now = new Date();
        const [h, m] = this.nextPrayer.time.split(":").map(Number);
        let target = new Date();
        target.setHours(h, m, 0, 0);
        if (target <= now) target.setDate(target.getDate() + 1);
        const diff = target - now;
        if (diff <= 0) {
            this.findNextPrayer();
            return;
        }
        const totalSeconds = Math.floor(diff / 1000);
        this.countdown = {
            hours: String(Math.floor(totalSeconds / 3600)).padStart(2, "0"),
            minutes: String(Math.floor((totalSeconds % 3600) / 60)).padStart(
                2,
                "0",
            ),
            seconds: String(totalSeconds % 60).padStart(2, "0"),
        };
    },

    updateCurrentTime() {
        const now = new Date();
        this.currentTime = now.toLocaleTimeString("id-ID", {
            hour: "2-digit",
            minute: "2-digit",
            second: "2-digit",
        });
        this.currentDate = now.toLocaleDateString("id-ID", {
            weekday: "long",
            year: "numeric",
            month: "long",
            day: "numeric",
        });
        if (this.lastDate && this.lastDate !== now.toDateString())
            this.fetchPrayerTimes();
        this.lastDate = now.toDateString();
    },

    destroy() {
        if (this.timeInterval) clearInterval(this.timeInterval);
        if (this.countdownInterval) clearInterval(this.countdownInterval);
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
// ===================================================
window.formatRupiah = {
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
        el.value = formatted;
        const newPos = pos + (formatted.length - oldLen);
        el.setSelectionRange(newPos, newPos);
        if (window.Livewire)
            window.Livewire.find(el).set(wireField, raw, false);
    },
    blur(el, wireField) {
        if (window.Livewire) {
            const val = window.Livewire.find(el)?.get?.(wireField);
            el.value = val ? this.fmt(val) : "";
        }
    },
};

// Progressive Image Loading with blur-up effect
const initProgressiveImages = () => {
    // Native lazy loading is supported, but we add blur-up effect
    const images = document.querySelectorAll('img[loading="lazy"]');

    images.forEach((img) => {
        // Skip if already loaded
        if (img.complete && img.naturalHeight !== 0) {
            img.classList.add("loaded");
            return;
        }

        // Add loading class
        img.classList.add("img-loading");

        img.addEventListener(
            "load",
            () => {
                img.classList.remove("img-loading");
                img.classList.add("loaded");
            },
            { once: true },
        );

        img.addEventListener(
            "error",
            () => {
                img.classList.remove("img-loading");
                img.classList.add("img-error");
            },
            { once: true },
        );
    });
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
    initProgressiveImages();
    // Defer non-critical animations — let browser breathe first
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
