<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Rebuild akhir tabel auctions — pendekatan sederhana & informatif.
 *
 * Tabel hanya menyimpan data yang benar-benar dibutuhkan publik:
 * identitas aset, kategori, harga lelang, alamat, PIC, luas tanah/bangunan,
 * dokumen, dan foto. Kolom yang jarang dipakai dihapus.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('auctions', function (Blueprint $table) {
            // Dokumen lampiran (PDF brosur, sertifikat, dll) — JSON [{name, path, size}]
            if (!Schema::hasColumn('auctions', 'documents')) {
                $table->json('documents')->nullable()->after('images');
            }

            // Hapus kolom yang tidak lagi dibutuhkan (sudah diramping di migrasi sebelumnya)
            $drop = [
                'auction_type',
                'auction_method',
                'auction_time',
                'estimated_price',
                'deposit_amount',
                'winning_bid',
                'winner_name',
                'sold_at',
            ];

            foreach ($drop as $column) {
                if (Schema::hasColumn('auctions', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('auctions', function (Blueprint $table) {
            if (Schema::hasColumn('auctions', 'documents')) {
                $table->dropColumn('documents');
            }
        });
    }
};
