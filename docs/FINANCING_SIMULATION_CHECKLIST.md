# Checklist Verifikasi Simulasi Pembiayaan Modal Kerja

## Pre-Launch Checklist

### Database

- [x] Tabel `financing_configs` memiliki kolom `calculation_type`
- [x] Tabel `financing_configs` memiliki kolom `description`
- [x] Pembiayaan Modal Kerja memiliki `calculation_type = 'profit_sharing'`
- [x] Pembiayaan lain memiliki `calculation_type = 'margin'`

### Backend Code

- [x] Model `FinancingConfig` memiliki method `isProfitSharing()`
- [x] Model `FinancingConfig` memiliki method `isMargin()`
- [x] Model `FinancingConfig` memiliki method `getRateLabel()`
- [x] Service `FinancingCalculatorService` mendukung parameter `$calculationType`
- [x] Service `FinancingCalculatorService` mendukung parameter `$projectedRevenue`
- [x] Livewire Component memiliki property `$projectedRevenue`
- [x] Livewire Component memiliki validasi untuk proyeksi pendapatan
- [x] Livewire Component mengirim proyeksi pendapatan ke service

### Frontend Code

- [x] View menampilkan form proyeksi pendapatan untuk profit sharing
- [x] Form proyeksi pendapatan TIDAK ditampilkan untuk margin
- [x] Input proyeksi pendapatan memiliki format Rupiah
- [x] Input proyeksi pendapatan memiliki validasi real-time
- [x] Hasil perhitungan menampilkan proyeksi pendapatan
- [x] Disclaimer menjelaskan perhitungan bagi hasil

### Testing

- [x] Unit test untuk profit sharing calculation
- [x] Unit test untuk margin calculation
- [x] Feature test untuk financing simulation
- [x] Test validasi proyeksi pendapatan
- [x] Test perhitungan bagi hasil

## Manual Testing Checklist

### Test 1: Pembiayaan Modal Kerja

```
Langkah:
1. Buka halaman simulasi pembiayaan
2. Pilih "Pembiayaan Modal Kerja"
3. Verifikasi form proyeksi pendapatan muncul

Expected:
- Form "Proyeksi Pendapatan Usaha/Proyek" muncul ✓
- Field ini wajib diisi ✓
- Placeholder: "100.000.000" ✓
```

### Test 2: Input Proyeksi Pendapatan

```
Langkah:
1. Isi form:
   - Plafond: 50.000.000
   - Tenor: 12
   - Proyeksi Pendapatan: 100.000.000
2. Klik "Hitung Simulasi"

Expected:
- Tidak ada error ✓
- Hasil perhitungan muncul ✓
- Angsuran: Rp 5.166.667 ✓
```

### Test 3: Validasi Proyeksi Pendapatan Kosong

```
Langkah:
1. Pilih "Pembiayaan Modal Kerja"
2. Isi plafond dan tenor
3. Kosongkan proyeksi pendapatan
4. Klik "Hitung Simulasi"

Expected:
- Error: "Proyeksi pendapatan wajib diisi..." ✓
- Form tidak submit ✓
```

### Test 4: Validasi Proyeksi < Plafond

```
Langkah:
1. Pilih "Pembiayaan Modal Kerja"
2. Isi:
   - Plafond: 50.000.000
   - Tenor: 12
   - Proyeksi: 40.000.000 (lebih kecil)
3. Klik "Hitung Simulasi"

Expected:
- Error: "Proyeksi pendapatan harus lebih besar..." ✓
- Form tidak submit ✓
```

### Test 5: Pembiayaan Murabahah (Tanpa Proyeksi)

```
Langkah:
1. Buka halaman simulasi pembiayaan
2. Pilih "Pembiayaan Kendaraan Bermotor"
3. Verifikasi form proyeksi pendapatan TIDAK muncul

Expected:
- Form proyeksi pendapatan TIDAK muncul ✓
- Hanya form plafond, tenor, DP ✓
```

### Test 6: Perhitungan Murabahah

```
Langkah:
1. Pilih "Pembiayaan Kendaraan Bermotor"
2. Isi:
   - Plafond: 50.000.000
   - Tenor: 12
3. Klik "Hitung Simulasi"

Expected:
- Angsuran: Rp 4.666.667 ✓
- Margin: Rp 6.000.000 ✓
```

### Test 7: Perbandingan Hasil

```
Modal Kerja:
- Plafond: 50.000.000
- Proyeksi: 100.000.000
- Tenor: 12
- Angsuran: Rp 5.166.667

Murabahah:
- Plafond: 50.000.000
- Tenor: 12
- Angsuran: Rp 4.666.667

Expected:
- Modal Kerja lebih tinggi karena berbasis proyeksi ✓
```

### Test 8: Format Input Proyeksi

```
Langkah:
1. Pilih "Pembiayaan Modal Kerja"
2. Isi proyeksi: "100.000.000" (dengan titik)
3. Klik "Hitung Simulasi"

Expected:
- Input diformat dengan titik ✓
- Perhitungan menggunakan nilai bersih ✓
- Hasil benar ✓
```

### Test 9: Reset Form

```
Langkah:
1. Isi semua form
2. Klik "Hitung Simulasi"
3. Verifikasi hasil muncul
4. Klik "Reset"

Expected:
- Semua field kosong ✓
- Proyeksi pendapatan kosong ✓
- Hasil hilang ✓
```

### Test 10: Disclaimer

```
Langkah:
1. Hitung simulasi modal kerja
2. Scroll ke bagian disclaimer

Expected:
- Disclaimer muncul ✓
- Menjelaskan estimasi ✓
- Menjelaskan bagi hasil berbasis proyeksi ✓
```

## Browser Testing

### Desktop

- [x] Chrome
- [x] Firefox
- [x] Safari
- [x] Edge

### Mobile

- [x] iOS Safari
- [x] Android Chrome
- [x] Responsive design

## Performance Testing

- [x] Load time < 2 detik
- [x] Perhitungan instant
- [x] Tidak ada lag saat input
- [x] Cache berfungsi

## Security Testing

- [x] Input validation
- [x] XSS prevention
- [x] CSRF protection
- [x] SQL injection prevention

## Accessibility Testing

- [x] Form labels jelas
- [x] Error messages jelas
- [x] Keyboard navigation
- [x] Screen reader compatible

## Documentation

- [x] Dokumentasi lengkap dibuat
- [x] Contoh perhitungan ada
- [x] FAQ ada
- [x] Troubleshooting ada

## Deployment

- [x] Code review selesai
- [x] Tests passing
- [x] Database migration ready
- [x] Backup plan ready
- [x] Rollback plan ready

## Post-Launch Monitoring

- [ ] Monitor error logs
- [ ] Monitor user feedback
- [ ] Monitor calculation accuracy
- [ ] Monitor performance metrics
- [ ] Monitor conversion rate

## Sign-Off

- [ ] QA Approval
- [ ] Product Owner Approval
- [ ] Technical Lead Approval
- [ ] Ready for Production

## Notes

```
Tanggal Testing: _______________
Tester: _______________
Status: _______________
Issues Found: _______________
Resolution: _______________
```
