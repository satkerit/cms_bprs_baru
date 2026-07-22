# Tasks

- [x] Task 1: Planning & Spec — Dokumen perencanaan (spec.md, tasks.md, checklist.md)
- [x] Task 2: Definisikan palet warna syariah di `app.css` — Ubah primary dari teal ke emerald, tambah gold accent
- [x] Task 3: Definisikan palet warna syariah di `admin.css` — Sama dengan app.css, khusus admin
- [x] Task 4: Hapus `frontend-fixes.css` & pindahkan utility penting ke Tailwind
- [x] Task 5: Refaktor `frontend-layout.blade.php` — Pindahkan `<style>` block ke CSS, hapus inline styles
- [x] Task 6: Refaktor admin dashboard (`dashboard.blade.php`) — Ganti semua `style="..."` dengan Tailwind classes
- [x] Task 7: Update `vite.config.js` — Hapus entry `frontend-fixes.css`
- [x] Task 8: Hapus file build lama & rebuild assets
- [x] Task 9: Verifikasi — Pastikan frontend dan admin tampil dengan palet syariah yang konsisten

# Task Dependencies

- Task 2 depends on Task 1
- Task 3 depends on Task 1
- Task 4 depends on Task 2, Task 3
- Task 5 depends on Task 4
- Task 6 depends on Task 4
- Task 7 depends on Task 1
- Task 8 depends on Task 4, Task 5, Task 6, Task 7
- Task 9 depends on Task 8
