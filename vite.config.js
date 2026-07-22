import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/admin.js",
                "resources/js/sweetalert-global.js",
                "resources/js/alpine-bundle.js",
                "resources/js/alpine-components.js",
                "resources/js/idle-timeout.js",
                "resources/js/admin-layout-patch.js",
                "resources/js/map-utils.js",
            ],
            refresh: true,
        }),
    ],
    build: {
        // Optimize chunk splitting
        rollupOptions: {
            output: {
                manualChunks: (id) => {
                    if (id.includes("node_modules")) {
                        if (id.includes("alpinejs")) {
                            return "vendor-alpine";
                        }

                        if (id.includes("sweetalert")) {
                            return "vendor-sweetalert";
                        }
                        if (
                            id.includes("jquery") ||
                            id.includes("summernote") ||
                            id.includes("leaflet")
                        ) {
                            return "vendor-admin";
                        }
                        if (id.includes("axios")) {
                            return "vendor-app";
                        }
                        return "vendor-shared";
                    }
                },
                // Optimize asset file names
                assetFileNames: (assetInfo) => {
                    if (/\.(css)$/.test(assetInfo.name)) {
                        return `assets/css/[name]-[hash][extname]`;
                    }
                    return `assets/[name]-[hash][extname]`;
                },
                chunkFileNames: "assets/js/[name]-[hash].js",
                entryFileNames: "assets/js/[name]-[hash].js",
            },
        },
        // Minification settings
        minify: "terser",
        terserOptions: {
            compress: {
                drop_debugger: true,
                passes: 2,
            },
            format: {
                comments: false, // Remove all comments
            },
        },
        // CSS optimization
        cssMinify: "lightningcss", // Faster CSS minification
        cssCodeSplit: true,
        // Reduce chunk size warnings threshold
        chunkSizeWarningLimit: 500,
        // Source maps for production debugging (optional)
        sourcemap: false,
        // Target modern browsers
        target: "es2020",
    },
    // Optimize dependencies
    optimizeDeps: {
        include: ["alpinejs", "@alpinejs/collapse"],
        exclude: [],
        // Vite 8 uses Rolldown for optimization (replaces esbuild)
        rolldownOptions: {
            transform: {
                target: "es2020",
            },
        },
    },
    server: {
        host: "0.0.0.0",
        hmr: {
            host: "localhost",
        },
    },
});
