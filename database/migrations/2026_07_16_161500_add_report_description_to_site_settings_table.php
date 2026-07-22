<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('site_settings', 'report_keuangan_publikasi_description')) {
                $table->text('report_keuangan_publikasi_description')->nullable();
            }
            if (!Schema::hasColumn('site_settings', 'report_tata_kelola_description')) {
                $table->text('report_tata_kelola_description')->nullable();
            }
            if (!Schema::hasColumn('site_settings', 'report_tahunan_description')) {
                $table->text('report_tahunan_description')->nullable();
            }
            if (!Schema::hasColumn('site_settings', 'report_tahunan_berkelanjutan_description')) {
                $table->text('report_tahunan_berkelanjutan_description')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'report_keuangan_publikasi_description',
                'report_tata_kelola_description',
                'report_tahunan_description',
                'report_tahunan_berkelanjutan_description',
            ]);
        });
    }
};
