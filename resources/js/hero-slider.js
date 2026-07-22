export function initHeroSlider() {
    return {
        active: 0,
        total: 0,
        autoplay: null,
        delay: 5000,
        isAnimating: false,
        direction: "next",
        transitions: [],
        touchStartX: 0,
        touchStartY: 0,
        touchEndX: 0,
        touchEndY: 0,
        isMobile: false,
        isTablet: false,
        isSwiping: false,

        detectDevice() {
            const width = window.innerWidth;
            this.isMobile = width < 768;
            this.isTablet = width >= 768 && width < 1024;
        },

        handleTouchStart(e) {
            if (e.touches.length !== 1) return; // Ignore multi-touch
            this.stopAutoplay();
            this.touchStartX = e.touches[0].clientX;
            this.touchStartY = e.touches[0].clientY;
            this.isSwiping = false;
        },

        handleTouchEnd(e) {
            this.touchEndX = e.changedTouches[0].clientX;
            this.touchEndY = e.changedTouches[0].clientY;

            const diffX = this.touchStartX - this.touchEndX;
            const diffY = this.touchStartY - this.touchEndY;

            // Minimum distance to trigger swipe (increase on mobile for easier interaction)
            const minSwipeDistance = this.isMobile ? 40 : 50;

            // Only trigger swipe if horizontal movement is significantly more than vertical
            // This prevents accidental swipes when scrolling vertically
            if (
                Math.abs(diffX) > Math.abs(diffY) &&
                Math.abs(diffX) > minSwipeDistance
            ) {
                this.isSwiping = true;
                if (diffX > 0) {
                    this.next();
                } else {
                    this.prev();
                }
            }

            this.isSwiping = false;
            this.startAutoplay();
        },

        handleTouchMove(e) {
            // Prevent default only if actively swiping horizontally
            if (
                this.isSwiping &&
                Math.abs(this.touchStartX - e.touches[0].clientX) > 10
            ) {
                e.preventDefault();
            }
        },

        init() {
            this.detectDevice();
            window.addEventListener("resize", () => this.detectDevice());

            // Add touch move listener for better swipe cancellation
            const sliderElement = document.querySelector(
                '[x-data="heroSlider()"]',
            );
            if (sliderElement) {
                sliderElement.addEventListener(
                    "touchmove",
                    (e) => this.handleTouchMove(e),
                    { passive: false },
                );
            }

            let start = () => this.startAutoplay();
            if ("requestIdleCallback" in window) {
                requestIdleCallback(start, { timeout: 3000 });
            } else {
                setTimeout(start, 100);
            }
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
            const duration = this.transitions[index]?.transitionDuration || 500;
            setTimeout(() => {
                this.isAnimating = false;
            }, duration);
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

        getTransitionClasses(index) {
            const isActive = this.active === index;
            const type = this.transitions[index]?.transitionType || "fade";

            if (type === "fade") {
                return isActive ? "opacity-100 z-10" : "opacity-0 z-0";
            } else if (type === "zoom") {
                return isActive
                    ? "opacity-100 scale-100 z-10"
                    : "opacity-0 scale-110 z-0";
            } else if (type === "slide") {
                if (isActive) return "translate-x-0 opacity-100 z-10";
                return this.direction === "next"
                    ? "translate-x-full opacity-0 z-0"
                    : "-translate-x-full opacity-0 z-0";
            } else if (type === "flip") {
                return isActive
                    ? "opacity-100 [transform:rotateY(0deg)] z-10"
                    : "opacity-0 [transform:rotateY(90deg)] z-0";
            } else if (type === "cube") {
                if (isActive)
                    return "opacity-100 z-10 [transform:translateZ(0)_rotateY(0deg)]";
                return this.direction === "next"
                    ? "opacity-0 z-0 [transform:translateZ(-100px)_rotateY(90deg)]"
                    : "opacity-0 z-0 [transform:translateZ(-100px)_rotateY(-90deg)]";
            } else if (type === "cards") {
                if (isActive) return "opacity-100 scale-100 translate-x-0 z-10";
                return this.direction === "next"
                    ? "opacity-0 scale-90 translate-x-full z-0"
                    : "opacity-0 scale-90 -translate-x-full z-0";
            }
            return isActive ? "opacity-100 z-10" : "opacity-0 z-0";
        },

        getTransitionStyle(index) {
            const duration = this.transitions[index]?.transitionDuration || 500;
            return "transition-duration: " + duration + "ms";
        },
    };
}
