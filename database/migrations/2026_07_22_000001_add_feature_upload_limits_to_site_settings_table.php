<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Menambahkan kolom untuk mengatur batas ukuran upload per fitur.
     * Semua nilai dalam Kilobyte (KB).
     */
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            // ===== General Images =====
            // Berita (featured + slide), Board Member, Office, Why Choose Us, Company Logo
            $table->unsignedInteger('max_image_size_kb')
                ->default(2048)
                ->after('max_file_uploads')
                ->comment('Batas ukuran gambar umum (KB). Berita, Board Member, Office, Logo, dll. Default: 2MB');

            // ===== Product Images =====
            $table->unsignedInteger('max_product_image_size_kb')
                ->default(2048)
                ->after('max_image_size_kb')
                ->comment('Batas ukuran gambar produk (KB). Default: 2MB');

            // ===== Documents (PDF) =====
            // Laporan (Reports) dan Brosur — menggantikan fungsi get_max_upload_size_kb() yang lama
            $table->unsignedInteger('max_document_size_kb')
                ->default(15360)
                ->after('max_product_image_size_kb')
                ->comment('Batas ukuran dokumen PDF (KB). Laporan & Brosur. Default: 15MB');

            // ===== Hero Slider =====
            $table->unsignedInteger('max_hero_image_size_kb')
                ->default(5120)
                ->after('max_document_size_kb')
                ->comment('Batas ukuran gambar hero slider (KB). Default: 5MB');

            // ===== Auction Images =====
            $table->unsignedInteger('max_auction_image_size_kb')
                ->default(5120)
                ->after('max_hero_image_size_kb')
                ->comment('Batas ukuran gambar lelang (KB). Default: 5MB');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'max_image_size_kb',
                'max_product_image_size_kb',
                'max_document_size_kb',
                'max_hero_image_size_kb',
                'max_auction_image_size_kb',
            ]);
        });
    }
};
