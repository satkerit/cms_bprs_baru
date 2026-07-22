# Implementasi Tailwind CSS Menyeluruh & Palet Warna Syariah

## Why

Proyek saat ini menggunakan campuran CSS kustom (`frontend-fixes.css`, `admin.css`) dan inline styles yang tidak konsisten. Perlu ditata ulang dengan Tailwind CSS secara menyeluruh untuk konsistensi visual, maintainability, dan performa. Pendekatan warna syariah (emerald/dark green + gold) memperkuat identitas BPRS Bangka Belitung sebagai lembaga keuangan syariah.

## What Changes

1. **Hapus semua CSS kustom** — `frontend-fixes.css`, file CSS publik hasil build dihapus, class kustom di `app.css` dan `admin.css` diganti dengan Tailwind utilities
2. **Palet warna syariah** — Primary color diubah dari teal/cyan ke emerald green (`#059669`/emerald-600) dengan aksen gold/amber
3. **Refaktor `app.css`** — Hanya berisi `@import "tailwindcss"`, deklarasi `@theme` dengan palet syariah, dan minimal global styles
4. **Refaktor `admin.css`** — Hanya berisi `@import "tailwindcss"`, deklarasi `@theme` dengan palet syariah, dan utility classes minimal untuk admin
5. **Hapus inline styles di blade** — Semua `style="..."` di view blade (terutama admin dashboard) diganti dengan Tailwind classes
6. **Hapus `<style>` block di layout** — Animasi kustom di frontend layout dipindah ke CSS via `@theme` atau utility Tailwind
7. **Update `vite.config.js`** — Hapus entry `frontend-fixes.css`
8. **Build ulang assets** — Hapus file build lama di `public/build/assets/css/`

## Impact

- Affected specs: Seluruh tampilan frontend dan admin panel
- Affected code: `resources/css/`, `resources/views/`, `vite.config.js`, `public/build/`

## Palet Warna Syariah

### Primary: Emerald Green (`#059669` / emerald-600)

- Mewakili identitas syariah, kesuburan, kepercayaan
- Digunakan untuk: tombol utama, link, header aktif, badge primary

### Accent: Gold/Amber (`#d97706` / amber-600)

- Mewakili nilai emas, kemakmuran, keunggulan
- Digunakan untuk: aksen, highlight, badge warning, icon penting

### Neutral: Slate

- Background: white/slate-50
- Foreground: slate-900
- Muted: slate-500
- Border: slate-200

### Semantic:

- Success: emerald
- Warning: amber
- Error: red
- Info: blue

### Dark Mode (opsional):

- Background: slate-900
- Card: slate-800
- Border: slate-700

## ADDED Requirements

### Requirement: Palet Warna Syariah di `@theme`

The system SHALL define palet warna syariah di `@theme` dalam `app.css` dan `admin.css`.

#### Scenario: Theme declaration

- **WHEN** CSS diproses oleh Tailwind
- **THEN** warna `primary` adalah emerald-600 (`#059669`), `primary-foreground` adalah white
- **AND** `primary-50` hingga `primary-900` mengikuti skala emerald Tailwind

### Requirement: CSS Kustom Dihapus

The system SHALL NOT mengandung CSS kustom (custom class, custom animation, inline style) yang bisa digantikan oleh Tailwind utilities.

#### Scenario: No custom CSS

- **WHEN** semua file CSS diperiksa
- **THEN** `frontend-fixes.css` tidak ada
- **AND** `app.css` dan `admin.css` hanya berisi `@import`, `@theme`, dan CSS minimal yang tidak bisa dicover Tailwind (misal print styles)

### Requirement: Blade Views Menggunakan Tailwind Classes

Semua view blade SHALL menggunakan Tailwind classes, bukan inline `style="..."`.

#### Scenario: Dashboard admin

- **WHEN** halaman admin dashboard di-render
- **THEN** tidak ada atribut `style="..."` di elemen HTML
- **AND** semua styling menggunakan class Tailwind

## MODIFIED Requirements

### Requirement: Vite Configuration

Entry points di `vite.config.js` dimodifikasi — hapus `resources/css/frontend-fixes.css`.

## REMOVED Requirements

### Requirement: File CSS Kustom

**Reason**: Digantikan oleh Tailwind utilities yang lebih konsisten dan maintainable.
**Migration**: Class kustom seperti `.card-hover`, `.btn-primary`, `.gradient-text` dll diganti dengan Tailwind classes (`hover:shadow-xl`, `bg-gradient-to-r`, dll).

### Requirement: Public Build Assets Lama

**Reason**: File build lama tidak relevan setelah source CSS berubah.
**Migration**: Hapus `public/build/assets/css/*` dan rebuild dengan `npm run build`.
