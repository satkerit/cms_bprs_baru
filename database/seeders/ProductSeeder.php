<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Kas Keliling
        Product::updateOrCreate(
            ['name' => 'Kas Keliling'],
            [
                'type' => 'kas_keliling',
                'description' => 'Layanan kas keliling untuk memudahkan nasabah bertransaksi secara langsung di berbagai titik lokasi.',
                'features' => [
                    'Jemput tabungan langsung',
                    'Setoran dan penarikan tunai',
                    'Informasi produk dan layanan',
                ],
                'requirements' => [
                    'KTP yang masih berlaku',
                    'Buku tabungan / kartu identitas nasabah',
                ],
                'benefits' => [
                    'Lebih dekat dan praktis',
                    'Aman dan efisien',
                ],
                'is_active' => true,
                'order_position' => 1
            ]
        );

        Product::updateOrCreate(
            ['name' => 'Deposito Mudharabah'],
            [
                'type' => 'simpanan_syariah',
                'description' => 'Investasi berjangka dengan akad mudharabah yang memberikan bagi hasil yang menguntungkan.',
                'features' => [
                    'Jangka waktu 1, 3, 6, 12 bulan',
                    'Setoran minimal Rp 1.000.000',
                    'Bagi hasil kompetitif',
                    'Dapat diperpanjang otomatis',
                    'Dapat dijadikan jaminan pembiayaan'
                ],
                'requirements' => [
                    'KTP yang masih berlaku',
                    'NPWP',
                    'Setoran minimal Rp 1.000.000',
                    'Mengisi formulir pembukaan deposito'
                ],
                'benefits' => [
                    'Bagi hasil yang menguntungkan',
                    'Investasi yang aman',
                    'Sesuai prinsip syariah',
                    'Fleksibel dalam jangka waktu'
                ],
                'is_active' => true,
                'order_position' => 2
            ]
        );

        // Pembiayaan Syariah
        Product::updateOrCreate(
            ['name' => 'Pembiayaan Murabahah'],
            [
                'type' => 'pembiayaan_syariah',
                'description' => 'Pembiayaan dengan akad jual beli untuk keperluan investasi, modal kerja, atau konsumtif.',
                'features' => [
                    'Margin yang kompetitif',
                    'Jangka waktu hingga 5 tahun',
                    'Proses persetujuan cepat',
                    'Tanpa denda keterlambatan',
                    'Sesuai prinsip syariah'
                ],
                'requirements' => [
                    'KTP dan KK',
                    'NPWP',
                    'Slip gaji atau laporan keuangan',
                    'Jaminan sesuai plafond',
                    'Surat keterangan usaha (untuk wirausaha)'
                ],
                'benefits' => [
                    'Margin tetap',
                    'Tidak ada bunga berbunga',
                    'Proses mudah dan cepat',
                    'Sesuai syariah'
                ],
                'is_active' => true,
                'order_position' => 1
            ]
        );

        Product::updateOrCreate(
            ['name' => 'Pembiayaan Musyarakah'],
            [
                'type' => 'pembiayaan_syariah',
                'description' => 'Pembiayaan dengan akad kerjasama untuk pengembangan usaha dengan sistem bagi hasil.',
                'features' => [
                    'Sistem bagi hasil',
                    'Kerjasama dalam pengelolaan',
                    'Jangka waktu fleksibel',
                    'Monitoring berkala',
                    'Transparansi dalam pembagian hasil'
                ],
                'requirements' => [
                    'Proposal usaha',
                    'Laporan keuangan',
                    'Legalitas usaha',
                    'Jaminan',
                    'Track record usaha'
                ],
                'benefits' => [
                    'Bagi hasil yang adil',
                    'Kemitraan strategis',
                    'Pengembangan usaha optimal',
                    'Sesuai prinsip syariah'
                ],
                'is_active' => true,
                'order_position' => 2
            ]
        );
    }
}
