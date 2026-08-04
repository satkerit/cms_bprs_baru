{{-- ═══════════════════════════════════════════════════════════════
     THEME STORE — sumber tunggal dark/light mode (frontend + admin).
     Disisipkan di akhir <body> SETELAH Alpine dimuat (via alpine:init).
     Kunci localStorage tunggal: 'theme' ('dark' | 'light').
     Tanpa transisi global — ganti kelas seketika (instan).
     ═══════════════════════════════════════════════════════════════ --}}
<script nonce="{{ $nonce }}">
    document.addEventListener('alpine:init', () => {
        Alpine.store('theme', {
            darkMode: false,

            init() {
                var stored = localStorage.getItem('theme');
                var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                this.darkMode = stored === 'dark' || (!stored && prefersDark);
                this._applyTheme(this.darkMode);

                // Ikuti perubahan preferensi OS hanya jika pengguna belum memilih manual
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                    if (!localStorage.getItem('theme')) {
                        this.darkMode = e.matches;
                        this._applyTheme(e.matches);
                    }
                });
            },

            _applyTheme(isDark) {
                document.documentElement.classList.toggle('dark', isDark);
                document.documentElement.style.colorScheme = isDark ? 'dark' : 'light';

                var meta = document.querySelector('meta[name="theme-color"]');
                if (meta) {
                    meta.content = isDark ? '#0b1120' : '#059669';
                }
            },

            toggleDark() {
                this.darkMode = !this.darkMode;
                localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
                this._applyTheme(this.darkMode);
            }
        });
    });
</script>
