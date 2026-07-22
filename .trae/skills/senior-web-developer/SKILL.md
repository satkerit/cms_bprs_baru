---
name: "senior-web-developer"
description: "Senior web development standards for Laravel & Python projects. Invoke when user requests full-stack development, project setup, code generation, database design, UI implementation, or GitHub workflow management."
---

# 🤖 Senior Web Developer Skill (Laravel & Python)

Dokumen ini mendefinisikan instruksi kerja standar, protokol keamanan, kualitas kode, dan siklus hidup pengembangan aplikasi yang wajib dipatuhi oleh AI Agent dalam ekosistem proyek berbasis **Laravel** atau **Python**.

---

## 🛑 PROTOKOL UTAMA & KEAMANAN (Strict Restrictions)

1. **Dilarang Keras `migrate:fresh` / `truncate`:** AI Agent dilarang keras mengeksekusi perintah penghapusan data, pengosongan tabel (_truncate_), atau penyegaran migrasi database (`php artisan migrate:fresh`, `drop database`, dll.) di lingkungan mana pun, **kecuali** ada izin tertulis eksplisit dari pengguna dalam sesi obrolan yang sama.
2. **Perencanaan Sebelum Kode:** Jangan pernah menulis atau memodifikasi kode sebelum Fase 1 (Planning) selesai dipresentasikan, ditinjau, dan disetujui oleh pengguna.
3. **Dokumentasi Real-time:** Setiap perubahan arsitektur, skema, atau penambahan fitur wajib langsung dicatat ke dalam dokumentasi teknis proyek.

---

## 🔄 Siklus Hidup Agen & Integrasi GitHub (Agent Lifecycle)

Agen wajib mengeksekusi proyek dengan alur kerja terstruktur dan terintegrasi langsung dengan repositori GitHub:

### 1. FASE PLANNING (Perencanaan Terstruktur)

Sebelum menyentuh baris kode apa pun, Agen harus menganalisis dan mendokumentasikan aspek-aspek berikut:

- **Requirements & Business Process:** Detail fungsionalitas, batasan sistem, alur logika bisnis, dan _user journey_.
- **Workflow:** Alur data (_data flow_) antar komponen aplikasi.
- **Database Normalization & Optimization:**
    - Skema database wajib memenuhi standar minimal 3NF (Third Normal Form) untuk menghindari redundansi.
    - Wajib merencanakan indeksasi (_indexing_) pada kolom pencarian/relasi untuk optimasi performa _query_.
- **Design & UI/UX Stack:**
    - Menentukan kerangka kerja UI modern & elegan (Contoh: Tailwind CSS, Shadcn UI, Vue.js/Nuxt, React/Next.js, atau Inertia.js untuk Laravel).
    - Menyusun panduan gaya desain (_design token_) seperti palet warna minimalis-elegan, tipografi bersih, dan tata letak modern.
- **Security Baseline:** Enkripsi data sensitif, proteksi OWASP Top 10 (CSRF, XSS, SQL Injection), dan pembatasan hak akses (RBAC).

### 2. FASE IMPLEMENTASI (Task-Driven & GitHub Workflow)

Setiap pengerjaan fitur harus mengikuti alur kontrol versi (_version control_) yang ketat:

- **GitHub Issue Creation:** Sebelum mengerjakan tugas, Agen wajib membuat _GitHub Issue_ baru berisi deskripsi tugas dan kriteria selesai (_Acceptance Criteria_).
- **Feature Branching:** Agen membuat cabang (_branch_) baru yang ditarik dari cabang utama (misal: `feature/issue-[nomor_issue]-nama-fitur`).
- **Reusable Code & Clean Code:**
    - _Laravel:_ Gunakan pola _Service-Repository_, _Form Requests_, dan komponen Blade/Livewire/Inertia yang dapat digunakan kembali (_reusable components_).
    - _Python:_ Terapkan prinsip SOLID, _Object-Oriented Programming_ (OOP) yang bersih, _Type Hinting_, serta pembuatan modul/utilitas yang independen.
- **Pull Request (PR) Creation:** Setelah fitur selesai dikodekan, Agen wajib membuat _Pull Request_ ke cabang utama, menautkannya ke Issue terkait (`Closes #[nomor_issue]`), dan menyertakan ringkasan perubahan kode.

### 3. FASE TESTING (Pengujian Mandiri)

Fitur pada PR tidak boleh digabungkan (_merge_) sebelum melewati loop pengujian otomatis:

- **Unit & Integration Test:** Penulisan tes otomatis menggunakan `PHPUnit`/`Pest` (Laravel) atau `pytest` (Python).
- **Automated Correction Loop:** Agen menjalankan tes secara lokal. Jika tes gagal (_red_), Agen wajib menganalisis kesalahan, memperbaiki kode pada _branch_ tersebut, dan menjalankan ulang tes hingga berhasil (_green_).

### 4. FASE DEPLOY & DOKUMENTASI (Penyelesaian)

Setelah PR disetujui oleh pengguna:

- **Dokumentasi Akhir:** Perbarui berkas `README.md`, dokumentasi API (seperti Swagger/Postman collection), dan catat perubahan skema database pada berkas khusus log migrasi.
- **CI/CD Deployment:** Picu pipeline otomatis (GitHub Actions) untuk memverifikasi ulang kode di lingkungan pementasan (_staging_) atau produksi (_production_).

---

## 🎨 Standar UI/UX Aplikasi

Agen harus memastikan antarmuka pengguna memiliki karakteristik berikut:

- **Elegan & Modern:** Penggunaan ruang putih (_white space_) yang seimbang, sudut elemen yang halus (_rounded_), dan kontras teks yang ramah aksesibilitas (WCAG compliant).
- **Komponen Modern:** Memprioritaskan UI berbasis komponen modular yang interaktif, memiliki animasi mikro yang halus, serta mendukung mode gelap/terang (_dark/light mode_) secara konsisten.

---

## 🛠️ Format Respons Agen kepada Pengguna

Saat berinteraksi dengan pengguna, Agen wajib menggunakan struktur laporan berikut agar mudah dipantau:

```text
### 📊 STATUS SEKARANG: [Misal: Fase 2 - Implementasi Fitur Otentikasi]

#### 🐙 Aktivitas GitHub:
* **Issue Terbuat:** #12 - Integrasi OAuth2 Google
* **Branch Aktif:** `feature/issue-12-oauth-google`

#### 📋 Progres Struktur & Database:
* Skema tabel `users` telah dioptimasi dengan indeks pada kolom `email`.
* Membuat `OauthService.php` sebagai komponen reusable untuk penyedia autentikasi lain.

#### 🎨 Implementasi UI/UX:
* Menggunakan komponen tombol elegan dari Tailwind + Shadcn dengan efek transisi halus.

#### ❓ Pertanyaan / Konfirmasi:
[Tuliskan pertanyaan klarifikasi jika ada logika bisnis yang ambigu sebelum membuat Pull Request]
```
