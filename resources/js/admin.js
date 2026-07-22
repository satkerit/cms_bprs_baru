// Admin Panel Application - Optimized
// Lazy-loads jQuery, Summernote, and SweetAlert2 when needed

// Global error handler for browser extension errors
window.addEventListener("unhandledrejection", function (event) {
    // Suppress errors from browser extensions
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
        return;
    }
});

import "./bootstrap";

// Import Alpine.js components first — these register window functions like adminLayout, fileUpload, etc.
// MUST be imported BEFORE alpine-bundle so they're available when Alpine starts
import "./alpine-components";

// Import Alpine.js bundle to initialize Alpine
import "./alpine-bundle";

// ====================================================
// LAZY LOAD SweetAlert2 via Proxy (transparent lazy loading)
// Swal.fire() works immediately — loads on first call
// ====================================================
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

// Also expose loadSwal for direct use
window.loadSwal = async function () {
    if (!SwalPromise) {
        SwalPromise = import("sweetalert2").then((module) => {
            window.Swal = module.default;
            return module.default;
        });
    }
    return SwalPromise;
};

// ====================================================
// LAZY LOAD jQuery & Summernote (only when needed)
// ====================================================
let $ = null;

async function loadJQuery() {
    if ($) return Promise.resolve($);
    const module = await import("jquery");
    $ = module.default;
    window.jQuery = window.$ = $;
    return $;
}

async function loadSummernote() {
    await loadJQuery();
    await import("summernote/dist/summernote-lite.css");
    await import("summernote/dist/summernote-lite.js");
}

// Initialize when DOM is ready
document.addEventListener("DOMContentLoaded", async function () {
    // Lazy load jQuery only if there are elements that need it
    const needsJQuery =
        document.getElementById("summernote") ||
        document.querySelector("#title, #slug") ||
        document.querySelector(
            ".image-preview, .btn-delete, .sidebar-toggle, .sidebar-overlay, " +
            ".alert-auto-hide, .btn-confirm, .btn-status, .btn-bulk, " +
            ".select-all, .bulk-checkbox, .lightbox, .char-counter, " +
            ".toggle-password, .ajax-form, .ajax-link, .datatable",
        );

    if (needsJQuery) {
        const jQuery = await loadJQuery();

        // Summernote Initialization
        if (jQuery("#summernote").length > 0) {
            await loadSummernote();
            try {
                jQuery("#summernote").summernote({
                    placeholder: "Tulis konten berita di sini...",
                    tabsize: 2,
                    height: 400,
                    toolbar: [
                        ["style", ["style"]],
                        ["font", ["bold", "underline", "clear"]],
                        ["color", ["color"]],
                        ["para", ["ul", "ol", "paragraph"]],
                        ["table", ["table"]],
                        ["insert", ["link", "picture", "video"]],
                        ["view", ["fullscreen", "codeview", "help"]],
                    ],
                    callbacks: {
                        onInit: function () {
                            console.log("Summernote initialized successfully");
                        },
                        onChange: function (contents, $editable) {
                            jQuery("#summernote").val(contents);
                        },
                    },
                });
            } catch (e) {
                console.error("Summernote initialization error:", e);
            }
        }

        // Slug Generator for News Form
        if (jQuery("#title").length > 0 && jQuery("#slug").length > 0) {
            jQuery("#title").on("input", function () {
                var title = jQuery(this).val();
                var slug = title
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, "")
                    .replace(/\s+/g, "-")
                    .replace(/-+/g, "-")
                    .trim();
                jQuery("#slug").val(slug);
            });
        }

        // Image Preview
        jQuery(".image-preview").on("change", ".custom-file-input", function () {
            var file = this.files[0];
            var $preview = jQuery(this).closest(".image-preview").find(".preview");
            if (file) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $preview.attr("src", e.target.result).show();
                };
                reader.readAsDataURL(file);
            }
        });

        // Delete confirmation
        jQuery(document).on("click", ".btn-delete", async function (e) {
            e.preventDefault();
            var form = jQuery(this).closest("form");
            var title = jQuery(this).data("title") || "Apakah Anda yakin?";
            var text =
                jQuery(this).data("text") ||
                "Data yang dihapus tidak dapat dikembalikan!";
            var confirmText = jQuery(this).data("confirm") || "Ya, hapus!";
            var cancelText = jQuery(this).data("cancel") || "Batal";

            const Swal = await window.loadSwal();
            Swal.fire({
                title: title,
                text: text,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: confirmText,
                cancelButtonText: cancelText,
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Sidebar toggle for mobile
        jQuery(".sidebar-toggle").on("click", function (e) {
            e.preventDefault();
            jQuery("body").toggleClass("sidebar-open");
        });

        // Close sidebar when clicking outside on mobile
        jQuery(document).on("click", ".sidebar-overlay", function () {
            jQuery("body").removeClass("sidebar-open");
        });

        // Auto-hide alerts
        jQuery(".alert-auto-hide").each(function () {
            var $alert = jQuery(this);
            var delay = $alert.data("delay") || 5000;
            setTimeout(function () {
                $alert.fadeOut("slow", function () {
                    jQuery(this).remove();
                });
            }, delay);
        });

        // Confirm form submission
        jQuery(".btn-confirm").on("click", async function (e) {
            e.preventDefault();
            var form = jQuery(this).closest("form");
            var title = jQuery(this).data("title") || "Konfirmasi";
            var text = jQuery(this).data("text") || "Apakah Anda yakin?";

            const Swal = await window.loadSwal();
            Swal.fire({
                title: title,
                text: text,
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#198754",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Ya",
                cancelButtonText: "Tidak",
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Status toggle
        jQuery(".btn-status").on("click", async function (e) {
            e.preventDefault();
            var btn = jQuery(this);
            var form = btn.closest("form");
            var title = btn.data("title") || "Ubah Status";
            var text =
                btn.data("text") || "Apakah Anda yakin ingin mengubah status?";

            const Swal = await window.loadSwal();
            Swal.fire({
                title: title,
                text: text,
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "#0d6efd",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Ya",
                cancelButtonText: "Tidak",
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Bulk actions
        jQuery(".btn-bulk").on("click", async function (e) {
            e.preventDefault();
            var btn = jQuery(this);
            var form = btn.closest("form");
            var action = btn.data("action");
            var title = btn.data("title") || "Konfirmasi";
            var text = btn.data("text") || "Apakah Anda yakin?";

            // Check if any checkbox is selected
            if (jQuery(".bulk-checkbox:checked").length === 0) {
                const Swal = await window.loadSwal();
                Swal.fire({
                    title: "Peringatan",
                    text: "Pilih minimal satu data",
                    icon: "warning",
                    confirmButtonColor: "#198754",
                });
                return;
            }

            const Swal = await window.loadSwal();
            Swal.fire({
                title: title,
                text: text,
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#198754",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Ya",
                cancelButtonText: "Tidak",
            }).then((result) => {
                if (result.isConfirmed) {
                    form.attr("action", action);
                    form.submit();
                }
            });
        });

        // Select all checkboxes
        jQuery(".select-all").on("change", function () {
            var isChecked = jQuery(this).is(":checked");
            jQuery(this)
                .closest("table")
                .find(".bulk-checkbox")
                .prop("checked", isChecked);
        });

        // Checkbox selection counter
        jQuery(".bulk-checkbox").on("change", function () {
            var count = jQuery(".bulk-checkbox:checked").length;
            jQuery(".selected-count").text(count + " data dipilih");
        });

        // Image gallery lightbox
        jQuery(".lightbox").on("click", async function (e) {
            e.preventDefault();
            var src = jQuery(this).attr("href") || jQuery(this).attr("src");
            const Swal = await window.loadSwal();
            Swal.fire({
                imageUrl: src,
                imageAlt: "Gambar",
                showConfirmButton: false,
                showCloseButton: true,
                width: "90%",
            });
        });

        // Character counter for textarea
        jQuery(".char-counter").on("input", function () {
            var max = jQuery(this).data("max") || 500;
            var current = jQuery(this).val().length;
            var $counter = jQuery(this).siblings(".counter");
            $counter.text(current + "/" + max);
        });

        // Toggle password visibility
        jQuery(".toggle-password").on("click", function () {
            var input = jQuery(jQuery(this).attr("toggle"));
            if (input.attr("type") === "password") {
                input.attr("type", "text");
                jQuery(this).removeClass("fa-eye").addClass("fa-eye-slash");
            } else {
                input.attr("type", "password");
                jQuery(this).removeClass("fa-eye-slash").addClass("fa-eye");
            }
        });

        // Initialize password toggles
        jQuery('[toggle="#password"]').each(function () {
            jQuery(this).on("click", function () {
                var input = jQuery(jQuery(this).attr("toggle"));
                var icon = jQuery(this).find("i");
                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                    icon.removeClass("fa-eye").addClass("fa-eye-slash");
                } else {
                    input.attr("type", "password");
                    icon.removeClass("fa-eye-slash").addClass("fa-eye");
                }
            });
        });

        // AJAX form submission
        jQuery(".ajax-form").on("submit", async function (e) {
            e.preventDefault();
            var form = jQuery(this);
            var submitBtn = form.find('button[type="submit"]');
            var originalText = submitBtn.html();

            const Swal = await window.loadSwal();

            submitBtn
                .prop("disabled", true)
                .html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');

            jQuery.ajax({
                url: form.attr("action"),
                type: form.attr("method"),
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Berhasil",
                            text: response.message || "Data berhasil disimpan",
                            icon: "success",
                            confirmButtonColor: "#198754",
                        }).then(() => {
                            if (response.redirect) {
                                window.location.href = response.redirect;
                            }
                        });
                    } else {
                        Swal.fire({
                            title: "Gagal",
                            text: response.message || "Terjadi kesalahan",
                            icon: "error",
                            confirmButtonColor: "#dc3545",
                        });
                    }
                },
                error: function (xhr) {
                    var errors = xhr.responseJSON?.errors;
                    var message = "Terjadi kesalahan";

                    if (errors) {
                        message = Object.values(errors)[0][0];
                    } else if (xhr.responseJSON?.message) {
                        message = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        title: "Gagal",
                        text: message,
                        icon: "error",
                        confirmButtonColor: "#dc3545",
                    });
                },
                complete: function () {
                    submitBtn.prop("disabled", false).html(originalText);
                },
            });
        });

        // AJAX link click
        jQuery(".ajax-link").on("click", async function (e) {
            e.preventDefault();
            var url = jQuery(this).attr("href");
            var title = jQuery(this).data("title") || "Konfirmasi";
            var text = jQuery(this).data("text") || "Apakah Anda yakin?";

            const Swal = await window.loadSwal();
            Swal.fire({
                title: title,
                text: text,
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#198754",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Ya",
                cancelButtonText: "Tidak",
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });
    }
});

// Initialize Idle Timeout Handler for authenticated users
document.addEventListener("DOMContentLoaded", function () {
    // Check if user is authenticated (meta tags exist)
    const idleTimeoutMeta = document.querySelector('meta[name="idle-timeout"]');

    if (idleTimeoutMeta && window.IdleTimeoutHandler) {
        const idleTimeout =
            parseInt(idleTimeoutMeta.getAttribute("content")) || 30;
        const warningTime =
            parseInt(
                document
                    .querySelector('meta[name="idle-warning"]')
                    ?.getAttribute("content"),
            ) || 5;
        const logoutUrl =
            document
                .querySelector('meta[name="logout-url"]')
                ?.getAttribute("content") || "/login";
        const autoExtend =
            document
                .querySelector('meta[name="auto-extend"]')
                ?.getAttribute("content") === "true";

        // Initialize idle timeout handler
        window.idleTimeoutHandler = new window.IdleTimeoutHandler({
            idleTimeout: idleTimeout * 60 * 1000, // Convert to milliseconds
            warningTime: warningTime * 60 * 1000, // Convert to milliseconds
            logoutUrl: logoutUrl,
            extendUrl: "/extend-session",
            autoExtend: autoExtend,
        });
    }
});
