# Admin Flow Test Scenarios

| ID | Area | Preconditions | Steps | Expected Result | Type |
| --- | --- | --- | --- | --- | --- |
| AF-01 | Admin Guest Redirect | User belum login | Akses `/admin` atau `/admin/composer-update` langsung | Sistem redirect ke `admin.login`, bukan ke login frontend umum | Manual / Regression |
| AF-02 | Admin Login Success | Akun admin aktif tersedia | Buka `admin.login`, isi kredensial valid dan CAPTCHA benar, submit | Login berhasil dan user diarahkan ke `admin.dashboard` | Manual / Regression |
| AF-03 | Inactive Admin Access | Akun admin `is_active = false` tersedia | Login sebagai akun inactive atau akses route admin dengan session akun inactive | User di-logout dan diarahkan ke `admin.login` dengan pesan error yang sesuai | Manual / Regression |
| AF-04 | Dashboard Access | Akun admin aktif tersedia | Login lalu buka `admin.dashboard` | Halaman dashboard tampil tanpa redirect liar ke login/frontend route lain | Manual / Regression |
| AF-05 | Admin Navigation Stability | Akun admin aktif tersedia | Login, lalu navigasi berurutan: dashboard -> profile -> financing config -> composer update -> kembali ke dashboard | Session tetap aktif, user tidak logout mendadak, dan route tetap berada di area admin | Manual / Regression |
| AF-06 | Composer Update Permission Admin | Akun admin aktif tersedia | Login sebagai admin, buka `admin.composer-update.index` | Halaman Composer Update tampil normal | Manual / Regression |
| AF-07 | Composer Update Permission Editor | Akun editor aktif tersedia | Login sebagai editor, buka `admin.composer-update.index` | Sistem menolak akses dengan status `403` | Manual / Regression |
| AF-08 | Composer Update Confirmation Required | Akun admin aktif tersedia | Login sebagai admin, submit form Composer Update tanpa checklist konfirmasi | Request ditolak, validasi `confirm` muncul, proses update tidak dijalankan | Manual / Regression |
| AF-09 | Financing Config Access Admin | Akun admin aktif tersedia dan data financing config tersedia | Login sebagai admin, buka `admin.financing-config.index` | Halaman tampil dan daftar konfigurasi terlihat | Manual / Regression |
| AF-10 | Financing Config Update Admin | Akun admin aktif tersedia dan data financing config tersedia | Ubah data financing config dengan payload valid lalu submit | Data tersimpan, redirect kembali ke index, dan muncul notifikasi sukses | Manual / Regression |
| AF-11 | Financing Config Validation | Akun admin aktif tersedia dan data financing config tersedia | Submit update dengan `margin_rate <= 0` atau `max_principal <= min_principal` | Validasi gagal dan pesan error tampil pada field terkait | Manual / Regression |
| AF-12 | Financing Config Access Editor | Akun editor aktif tersedia | Login sebagai editor, buka `admin.financing-config.index` atau submit update | Sistem menolak akses dengan status `403` | Manual / Regression |
| AF-13 | Session Middleware Compatibility | Akun admin aktif tersedia | Login, refresh beberapa halaman admin, lalu akses endpoint admin lain dalam sesi yang sama | Fingerprint session tetap valid pada local, tidak ada redirect tak terduga karena salah route login | Manual / Regression |
| AF-14 | Local Environment Cookie Config | Environment lokal menggunakan HTTP | Login ke area admin lalu berpindah halaman beberapa kali | Cookie session tetap terbaca pada HTTP lokal, tidak terjadi logout karena `SESSION_SECURE_COOKIE` | Manual / Environment |
| AF-15 | Production Smoke Check | Deploy production selesai | Ulangi AF-01 sampai AF-08 pada domain production | Perilaku redirect, permission, dan session konsisten dengan hasil lokal | Manual / UAT |

## Catatan Eksekusi

| Item | Detail |
| --- | --- |
| Environment Lokal | Gunakan `.env` lokal dengan `SESSION_SECURE_COOKIE=false` dan `SESSION_STRICT_IP_CHECK=false` |
| Role Uji Minimum | `super_admin`, `admin`, `editor`, dan satu akun inactive |
| Fokus Risiko | Redirect guest ke login yang salah, logout mendadak antar halaman admin, dan mismatch permission pada menu sistem |
| Rekomendasi UAT | Jalankan smoke test ulang setelah perubahan middleware, route auth, session config, atau halaman admin sistem |
