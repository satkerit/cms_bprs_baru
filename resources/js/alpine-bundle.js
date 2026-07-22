/**
 * Alpine.js Bundle - Local Installation
 * This file bundles Alpine.js locally to avoid CDN tracking prevention issues
 */

import Alpine from "alpinejs";
import collapse from "@alpinejs/collapse";
import intersect from "@alpinejs/intersect";

// Register Alpine plugins
Alpine.plugin(collapse);
Alpine.plugin(intersect);

// Make Alpine available globally
window.Alpine = Alpine;

// Log Alpine initialization
console.log("[Alpine Bundle] Alpine.js loaded from local bundle");
console.log("[Alpine Bundle] Version:", Alpine.version || "3.x");

// Start Alpine
document.addEventListener("DOMContentLoaded", () => {
    console.log("[Alpine Bundle] DOM loaded, starting Alpine.js");
    Alpine.start();
    console.log("[Alpine Bundle] Alpine.js started successfully");
});

// Export Alpine for module usage
export default Alpine;
