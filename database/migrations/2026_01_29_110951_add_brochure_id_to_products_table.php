<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Kolom `brochure_id` sudah direferensikan model & form produk (pilih brosur
     * dari library brosur) namun belum pernah dibuat di tabel. Tambahkan agar
     * akses atribut tidak melempar MissingAttributeException di strict mode.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'brochure_id')) {
                $table->unsignedBigInteger('brochure_id')->nullable()->after('brochure');
                $table->foreign('brochure_id')
                    ->references('id')
                    ->on('brochures')
                    ->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'brochure_id')) {
                $table->dropForeign(['brochure_id']);
                $table->dropColumn('brochure_id');
            }
        });
    }
};
