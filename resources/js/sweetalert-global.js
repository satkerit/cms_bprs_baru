/**
 * SweetAlert2 Global Confirmation System
 *
 * Provides automatic SweetAlert2 confirmations for:
 * - Form submissions (save/update/delete)
 * - Delete operations (via data attributes)
 * - Status changes
 * - Flash/session messages
 *
 * Usage:
 *   <form data-swal-confirm="save"> → Shows save confirmation before submit
 *   <form data-swal-confirm="delete"> → Shows delete confirmation before submit
 *   <form data-swal-confirm="status"> → Shows status change confirmation
 *   <button data-swal-delete> → Shows delete confirmation for the closest form
 *   <button data-swal-save> → Shows save confirmation for the closest form
 */

// =====================================================
// LAZY LOAD SweetAlert2
// =====================================================
let SwalPromise = null;

if (!window.Swal) {
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
}

async function getSwal() {
    if (SwalPromise) return SwalPromise;
    SwalPromise = import("sweetalert2").then((module) => {
        window.Swal = module.default;
        return module.default;
    });
    return SwalPromise;
}

// =====================================================
// CONFIGURATION — Customize per project
// =====================================================
const CONFIG = {
    confirmDelete: {
        title: "Apakah Anda yakin?",
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: "warning",
        confirmButtonColor: "#dc2626",
        cancelButtonColor: "#6b7280",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal",
        reverseButtons: true,
    },
    confirmSave: {
        title: "Konfirmasi Simpan",
        text: "Apakah Anda yakin ingin menyimpan data ini?",
        icon: "question",
        confirmButtonColor: "#059669",
        cancelButtonColor: "#6b7280",
        confirmButtonText: "Ya, simpan!",
        cancelButtonText: "Batal",
        reverseButtons: true,
    },
    confirmUpdate: {
        title: "Konfirmasi Update",
        text: "Apakah Anda yakin ingin memperbarui data ini?",
        icon: "question",
        confirmButtonColor: "#059669",
        cancelButtonColor: "#6b7280",
        confirmButtonText: "Ya, update!",
        cancelButtonText: "Batal",
        reverseButtons: true,
    },
    confirmStatus: {
        title: "Ubah Status",
        text: "Apakah Anda yakin ingin mengubah status?",
        icon: "info",
        confirmButtonColor: "#2563eb",
        cancelButtonColor: "#6b7280",
        confirmButtonText: "Ya, ubah!",
        cancelButtonText: "Batal",
        reverseButtons: true,
    },
    success: {
        icon: "success",
        title: "Berhasil!",
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false,
        toast: true,
        position: "top-end",
    },
    error: {
        icon: "error",
        title: "Gagal!",
        timer: 5000,
        timerProgressBar: true,
        showConfirmButton: false,
        toast: true,
        position: "top-end",
    },
    warning: {
        icon: "warning",
        title: "Peringatan!",
        timer: 4000,
        timerProgressBar: true,
        showConfirmButton: false,
        toast: true,
        position: "top-end",
    },
    info: {
        icon: "info",
        title: "Informasi",
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false,
        toast: true,
        position: "top-end",
    },
};

// =====================================================
// HELPER: Show confirmation dialog
// =====================================================
async function showConfirm(type, overrides = {}) {
    const Swal = await getSwal();
    const config = { ...CONFIG[type] || CONFIG.confirmSave, ...overrides };
    const result = await Swal.fire(config);
    return result.isConfirmed;
}

// =====================================================
// HELPER: Show notification/toast
// =====================================================
async function showNotification(type, overrides = {}) {
    const Swal = await getSwal();
    const config = { ...CONFIG[type] || CONFIG.info, ...overrides };
    return Swal.fire(config);
}

// Export for use in other modules
window.SwalConfirm = {
    showConfirm,
    showNotification,
    getSwal,
};

// =====================================================
// GLOBAL EVENT HANDLERS
// =====================================================
document.addEventListener("DOMContentLoaded", function () {
    initSwalConfirm();
});

function initSwalConfirm() {
    // -------------------------------------------------------
    // AUTO-DETECT: Beri data-swal-confirm ke semua form CRUD
    // -------------------------------------------------------
    document.querySelectorAll("form").forEach((form) => {
        if (
            form.hasAttribute("data-swal-ignore") ||
            form.hasAttribute("data-swal-confirm")
        )
            return;

        const method = (
            form.querySelector('input[name="_method"]')?.value ||
            form.getAttribute("method") ||
            "POST"
        ).toUpperCase();

        // Hanya form POST/PUT/PATCH/DELETE
        if (!["POST", "PUT", "PATCH", "DELETE"].includes(method)) return;

        // Skip search/filter/login forms
        const action = (form.getAttribute("action") || "").toLowerCase();
        if (
            action.includes("/search") ||
            action.includes("/filter") ||
            action.includes("/login") ||
            action.includes("/logout") ||
            form.closest("[data-swal-ignore]") ||
            form.hasAttribute("data-swal-ignore")
        )
            return;

        form.setAttribute("data-swal-confirm", "auto");
    });

    // -------------------------------------------------------
    // 1. Handle forms with data-swal-confirm attribute
    // -------------------------------------------------------
    document.addEventListener("submit", async function (e) {
        const form = e.target;
        const confirmType = form.getAttribute("data-swal-confirm");
        if (!confirmType) return;

        e.preventDefault();

        // Read custom message from form/button data attributes
        const submitBtn = form.querySelector('[type="submit"]');
        const customText =
            form.getAttribute("data-swal-text") ||
            submitBtn?.getAttribute("data-swal-text") ||
            null;
        const customTitle =
            form.getAttribute("data-swal-title") ||
            submitBtn?.getAttribute("data-swal-title") ||
            null;

        // Determine the confirmation type
        let type = confirmType;
        if (confirmType === "auto") {
            const method = (
                form.querySelector('input[name="_method"]')?.value ||
                form.getAttribute("method") ||
                "POST"
            ).toUpperCase();
            if (method === "DELETE") type = "confirmDelete";
            else if (method === "PUT" || method === "PATCH") type = "confirmUpdate";
            else type = "confirmSave";
        }

        const overrides = {};
        if (customText) overrides.text = customText;
        if (customTitle) overrides.title = customTitle;

        const confirmed = await showConfirm(type, overrides);
        if (confirmed) {
            // Temporarily remove data-swal-confirm to prevent loop, then submit
            form.removeAttribute("data-swal-confirm");
            form.submit();
        }
    });

    // -------------------------------------------------------
    // 2. Handle [data-swal-delete] buttons (outside forms)
    // -------------------------------------------------------
    document.addEventListener("click", async function (e) {
        const btn = e.target.closest("[data-swal-delete]");
        if (!btn) return;

        e.preventDefault();

        const form = btn.closest("form");
        if (!form) return;

        const customText =
            btn.getAttribute("data-swal-text") ||
            form.getAttribute("data-swal-text") ||
            null;
        const customTitle =
            btn.getAttribute("data-swal-title") ||
            form.getAttribute("data-swal-title") ||
            null;

        const overrides = {};
        if (customText) overrides.text = customText;
        if (customTitle) overrides.title = customTitle;

        // Also allow setting the form action from data attribute
        const action = btn.getAttribute("data-action");
        if (action) form.action = action;

        const confirmed = await showConfirm("confirmDelete", overrides);
        if (confirmed) {
            form.removeAttribute("data-swal-confirm");
            form.submit();
        }
    });

    // -------------------------------------------------------
    // 3. Handle [data-swal-save] buttons (outside forms)
    // -------------------------------------------------------
    document.addEventListener("click", async function (e) {
        const btn = e.target.closest("[data-swal-save]");
        if (!btn) return;

        e.preventDefault();

        const form = btn.closest("form");
        if (!form) return;

        const customText =
            btn.getAttribute("data-swal-text") ||
            form.getAttribute("data-swal-text") ||
            null;
        const customTitle =
            btn.getAttribute("data-swal-title") ||
            form.getAttribute("data-swal-title") ||
            null;

        const overrides = {};
        if (customText) overrides.text = customText;
        if (customTitle) overrides.title = customTitle;

        const confirmed = await showConfirm("confirmSave", overrides);
        if (confirmed) {
            form.removeAttribute("data-swal-confirm");
            form.submit();
        }
    });

    // -------------------------------------------------------
    // 4. Handle [data-swal-status] buttons
    // -------------------------------------------------------
    document.addEventListener("click", async function (e) {
        const btn = e.target.closest("[data-swal-status]");
        if (!btn) return;

        e.preventDefault();

        const form = btn.closest("form");
        if (!form) return;

        const customText =
            btn.getAttribute("data-swal-text") ||
            form.getAttribute("data-swal-text") ||
            "Apakah Anda yakin ingin mengubah status ini?";
        const customTitle =
            btn.getAttribute("data-swal-title") ||
            form.getAttribute("data-swal-title") ||
            null;

        const overrides = {};
        if (customText) overrides.text = customText;
        if (customTitle) overrides.title = customTitle;

        const action = btn.getAttribute("data-action");
        if (action) form.action = action;

        const confirmed = await showConfirm("confirmStatus", overrides);
        if (confirmed) {
            form.removeAttribute("data-swal-confirm");
            form.submit();
        }
    });

    // -------------------------------------------------------
    // 5. Flash messages with SweetAlert2 toast
    // -------------------------------------------------------
    const flashContainer = document.getElementById("swal-flash");
    if (flashContainer) {
        const messages = JSON.parse(
            flashContainer.getAttribute("data-messages") || "[]",
        );
        messages.forEach((msg, index) => {
            // Stagger multiple messages
            setTimeout(() => {
                showNotification(msg.type, {
                    title: msg.title || msg.type,
                    text: msg.text || "",
                });
            }, index * 500);
        });
        // Clear after processing
        flashContainer.setAttribute("data-messages", "[]");
    }

    // Also check for inline flash data attributes
    const flashInline = document.querySelector("[data-swal-flash]");
    if (flashInline) {
        const type = flashInline.getAttribute("data-swal-flash");
        const title = flashInline.getAttribute("data-swal-title") || "";
        const text = flashInline.textContent.trim();
        if (type && text) {
            showNotification(type, { title, text });
        }
    }

    // -------------------------------------------------------
    // 6. Handle data-swal-link (confirm before navigating)
    // -------------------------------------------------------
    document.addEventListener("click", async function (e) {
        const link = e.target.closest("[data-swal-link]");
        if (!link) return;

        e.preventDefault();

        const config = JSON.parse(link.getAttribute("data-swal-link") || "{}");
        const title = config.title || "Konfirmasi";
        const text = config.text || "Apakah Anda yakin?";
        const icon = config.icon || "question";

        const Swal = await getSwal();
        const result = await Swal.fire({
            title,
            text,
            icon,
            showCancelButton: true,
            confirmButtonColor: config.confirmColor || "#059669",
            cancelButtonColor: "#6b7280",
            confirmButtonText: config.confirmText || "Ya",
            cancelButtonText: config.cancelText || "Batal",
            reverseButtons: true,
        });

        if (result.isConfirmed) {
            window.location.href = link.href || config.url;
        }
    });

    if (import.meta.env?.PROD !== true) {
        console.log("[SwalConfirm] Global confirmation system initialized");
    }

    // -------------------------------------------------------
    // MUTATION OBSERVER: Deteksi form baru yg ditambahkan secara dinamis
    // -------------------------------------------------------
    const observer = new MutationObserver((mutations) => {
        let hasNewForm = false;
        for (const mutation of mutations) {
            for (const node of mutation.addedNodes) {
                if (node.nodeType === 1) {
                    if (node.tagName === "FORM") {
                        hasNewForm = true;
                        break;
                    }
                    if (node.querySelector && node.querySelector("form")) {
                        hasNewForm = true;
                        break;
                    }
                }
            }
            if (hasNewForm) break;
        }

        if (hasNewForm) {
            document.querySelectorAll("form:not([data-swal-ignore]):not([data-swal-confirm])").forEach((form) => {
                const method = (
                    form.querySelector('input[name="_method"]')?.value ||
                    form.getAttribute("method") ||
                    "POST"
                ).toUpperCase();
                if (!["POST", "PUT", "PATCH", "DELETE"].includes(method)) return;
                const action = (form.getAttribute("action") || "").toLowerCase();
                if (action.includes("/search") || action.includes("/filter")) return;
                form.setAttribute("data-swal-confirm", "auto");
            });
        }
    });
    observer.observe(document.body, { childList: true, subtree: true });
}

// Re-initialize on Livewire navigation (if available)
document.addEventListener("livewire:navigated", function () {
    // Re-scan forms for data-swal-confirm
    document.querySelectorAll("form:not([data-swal-ignore]):not([data-swal-confirm])").forEach((form) => {
        const method = (
            form.querySelector('input[name="_method"]')?.value ||
            form.getAttribute("method") ||
            "POST"
        ).toUpperCase();
        if (["POST", "PUT", "PATCH", "DELETE"].includes(method)) {
            form.setAttribute("data-swal-confirm", "auto");
        }
    });

    // Flash messages from Livewire session
    const flashContainer = document.getElementById("swal-flash");
    if (flashContainer) {
        const messages = JSON.parse(
            flashContainer.getAttribute("data-messages") || "[]",
        );
        if (messages.length > 0) {
            flashContainer.setAttribute("data-messages", "[]");
            messages.forEach((msg, index) => {
                setTimeout(() => {
                    showNotification(msg.type, {
                        title: msg.title || msg.type,
                        text: msg.text || "",
                    });
                }, index * 500);
            });
        }
    }
});
