# Simulasi Pembiayaan Modal Kerja - Dokumentasi Lengkap

## Overview

Fitur simulasi pembiayaan modal kerja memungkinkan calon nasabah untuk menghitung estimasi angsuran berdasarkan proyeksi pendapatan usaha/proyek, bukan berdasarkan plafond pembiayaan.

## Fitur Utama

### 1. Form Input

- **Jenis Pembiayaan**: Pilih "Pembiayaan Modal Kerja"
- **Jumlah Pembiayaan (Plafond)**: Nominal yang ingin diajukan
- **Jangka Waktu**: Durasi pembiayaan (1-60 bulan)
- **Proyeksi Pendapatan**: Perkiraan keuntungan bersih tahunan dari usaha/proyek yang akan dibiayai
- **Uang Muka (DP)**: Opsional, jika ada

### 2. Validasi Input

- Plafond: Rp 5.000.000 - Rp 500.000.000
- Tenor: 1-60 bulan
- Proyeksi Keuntungan: Harus diisi (tidak ada batasan minimum terhadap plafond)
- DP: Sesuai persentase yang ditentukan

### 3. Perhitungan Bagi Hasil

```
Total Bagi Hasil = Proyeksi Pendapatan × Rate Tahunan × (Tenor / 12)
Total Pembayaran = Plafond + Total Bagi Hasil
Angsuran/Bulan = Total Pembayaran / Tenor
```

## Contoh Perhitungan

### Skenario Modal Kerja

```
Jenis Pembiayaan: Pembiayaan Modal Kerja
Plafond: Rp 50.000.000
Proyeksi Keuntungan: Rp 30.000.000 per tahun
Rate: 12% per tahun
Tenor: 12 bulan
DP: Rp 0

Perhitungan:
- Total Bagi Hasil = Rp 30.000.000 × 12% × (12/12)
                   = Rp 30.000.000 × 0.12 × 1
                   = Rp 3.600.000

- Total Pembayaran = Rp 50.000.000 + Rp 3.600.000
                   = Rp 53.600.000

- Angsuran/Bulan = Rp 53.600.000 / 12
                 = Rp 4.466.667
```

### Perbandingan dengan Murabahah

```
Jenis Pembiayaan: Pembiayaan Kendaraan Bermotor (Murabahah)
Plafond: Rp 50.000.000
Rate: 12% per tahun
Tenor: 12 bulan

Perhitungan:
- Monthly Rate = 12% / 12 = 1% per bulan
- Total Margin = Rp 50.000.000 × 1% × 12
               = Rp 6.000.000

- Total Pembayaran = Rp 50.000.000 + Rp 6.000.000
                   = Rp 56.000.000

- Angsuran/Bulan = Rp 56.000.000 / 12
                 = Rp 4.666.667
```

**Perbedaan**: Modal Kerja menggunakan proyeksi pendapatan, Murabahah menggunakan plafond.

## Implementasi Teknis

### Database

```sql
-- Tabel financing_configs
- id: INT
- type: VARCHAR (murabahah, musyarakah, pembiayaan_cikgu)
- calculation_type: VARCHAR (margin, profit_sharing)
- name: VARCHAR
- margin_rate: DECIMAL
- min_principal: BIGINT
- max_principal: BIGINT
- available_tenors: JSON
- is_active: BOOLEAN
```

### Model (FinancingConfig)

```php
public function isProfitSharing(): bool
{
    return $this->calculation_type === 'profit_sharing';
}

public function isMargin(): bool
{
    return $this->calculation_type === 'margin';
}

public function getRateLabel(): string
{
    return $this->isProfitSharing() ? 'Proyeksi Bagi Hasil' : 'Margin';
}
```

### Livewire Component (Calculator)

```php
public $projectedRevenue = '';

// Validasi untuk profit sharing
if ($config->isProfitSharing()) {
    if (empty($this->projectedRevenue) || $cleanProjectedRevenue < 1) {
        $this->addError('projectedRevenue', 'Proyeksi pendapatan wajib diisi...');
        return;
    }

    if ($cleanProjectedRevenue < $cleanPrincipal) {
        $this->addError('projectedRevenue', 'Proyeksi pendapatan harus lebih besar...');
        return;
    }
}

// Kirim ke service
$this->result = $service->calculate(
    $principalAfterDp,
    (float) $config->margin_rate,
    $cleanTenor,
    $config->calculation_type,
    $cleanProjectedRevenue
);
```

### Service (FinancingCalculatorService)

```php
public function calculate(
    int $principal,
    float $marginRate,
    int $tenor,
    string $calculationType = 'margin',
    int $projectedRevenue = 0
): array
{
    if ($calculationType === 'profit_sharing' && $projectedRevenue > 0) {
        // Profit Sharing: Total = Projected Revenue × Rate × (Tenor / 12)
        $totalMarginRaw = $projectedRevenue * $marginRate * ($tenor / 12);
    } else {
        // Margin: Total = Principal × Monthly Rate × Tenor
        $monthlyMarginRate = $marginRate / 12;
        $totalMarginRaw = $principal * $monthlyMarginRate * $tenor;
    }

    // ... rest of calculation
}
```

### View (calculator.blade.php)

```blade
<!-- Projected Revenue (for profit sharing only) -->
@if($selectedConfig && $selectedConfig->isProfitSharing())
<div class="group">
    <label>Proyeksi Pendapatan Usaha/Proyek</label>
    <input type="text" wire:model="projectedRevenue" placeholder="100.000.000">
    <p>Proyeksi pendapatan tahunan dari usaha/proyek yang akan dibiayai...</p>
</div>
@endif
```

## Alur Kerja

### 1. User Memilih Pembiayaan Modal Kerja

- Form input proyeksi pendapatan muncul
- Field ini menjadi wajib diisi

### 2. User Mengisi Form

- Plafond: Rp 50.000.000
- Tenor: 12 bulan
- Proyeksi Pendapatan: Rp 100.000.000

### 3. Validasi

- Plafond dalam range min-max ✓
- Tenor 1-60 bulan ✓
- Proyeksi > Plafond ✓

### 4. Perhitungan

- Bagi hasil = Rp 100.000.000 × 12% × 1 = Rp 12.000.000
- Total = Rp 50.000.000 + Rp 12.000.000 = Rp 62.000.000
- Angsuran = Rp 62.000.000 / 12 = Rp 5.166.667

### 5. Tampilkan Hasil

- Angsuran per bulan
- Total bagi hasil
- Proyeksi pendapatan
- Disclaimer

## Disclaimer

Hasil simulasi menampilkan:

```
Hasil simulasi ini bersifat estimasi dan tidak mengikat.
Angsuran dan perhitungan sebenarnya dapat berbeda berdasarkan
hasil analisis kelayakan, verifikasi dokumen, dan persetujuan
pembiayaan dari pihak kami.

Khusus Pembiayaan Modal Kerja:
Perhitungan menggunakan proyeksi bagi hasil yang dihitung dari
proyeksi pendapatan proyek, bukan dari plafond pembiayaan.
Bagi hasil aktual akan ditentukan berdasarkan realisasi
pendapatan usaha/proyek yang dibiayai.
```

## Testing

### Test Case 1: Modal Kerja dengan Proyeksi Keuntungan

```
Input:
- Jenis: Pembiayaan Modal Kerja
- Plafond: Rp 50.000.000
- Tenor: 12 bulan
- Proyeksi Keuntungan: Rp 30.000.000

Expected:
- Form proyeksi keuntungan muncul ✓
- Validasi proyeksi keuntungan diisi ✓
- Perhitungan berdasarkan proyeksi keuntungan ✓
- Hasil: Rp 4.466.667/bulan ✓
```

### Test Case 2: Murabahah tanpa Proyeksi Pendapatan

```
Input:
- Jenis: Pembiayaan Kendaraan Bermotor
- Plafond: Rp 50.000.000
- Tenor: 12 bulan

Expected:
- Form proyeksi pendapatan TIDAK muncul ✓
- Perhitungan berdasarkan plafond ✓
- Hasil: Rp 4.666.667/bulan ✓
```

### Test Case 3: Validasi Proyeksi Keuntungan

```
Input:
- Jenis: Pembiayaan Modal Kerja
- Plafond: Rp 50.000.000
- Proyeksi Keuntungan: (kosong)

Expected:
- Error: "Proyeksi keuntungan wajib diisi untuk pembiayaan modal kerja" ✓
```

## Related Files

- `app/Models/FinancingConfig.php` - Model
- `app/Livewire/Frontend/FinancingSimulation/Calculator.php` - Livewire Component
- `app/Services/FinancingCalculatorService.php` - Service
- `resources/views/livewire/frontend/financing-simulation/calculator.blade.php` - View
- `tests/Feature/FinancingSimulationTest.php` - Feature Tests
- `tests/Unit/Services/FinancingCalculatorServiceTest.php` - Unit Tests

## FAQ

**Q: Bagaimana jika proyeksi keuntungan lebih kecil dari plafond?**
A: Tidak masalah. Proyeksi keuntungan adalah estimasi keuntungan dari proyek, bukan total pendapatan. Bagi hasil dihitung berdasarkan proyeksi keuntungan ini, tidak ada batasan bahwa harus lebih besar dari plafond.

**Q: Bagaimana jika proyeksi keuntungan berubah?**
A: User bisa mengubah proyeksi keuntungan dan klik "Hitung Simulasi" lagi untuk mendapatkan hasil baru.

**Q: Apakah proyeksi keuntungan harus tepat?**
A: Proyeksi harus realistis berdasarkan analisis usaha. Bank akan verifikasi saat proses persetujuan.

**Q: Bagaimana jika usaha tidak mencapai proyeksi?**
A: Bagi hasil aktual akan disesuaikan berdasarkan realisasi keuntungan yang dilaporkan.

## Kesimpulan

Fitur simulasi pembiayaan modal kerja memberikan transparansi kepada calon nasabah tentang bagaimana bagi hasil dihitung berdasarkan proyeksi keuntungan usaha/proyek, bukan dari plafond pembiayaan. Proyeksi keuntungan adalah estimasi keuntungan bersih dari proyek yang akan dibiayai, dan tidak ada batasan bahwa harus lebih besar dari plafond. Ini memastikan perhitungan yang lebih adil dan sesuai dengan kemampuan usaha.
