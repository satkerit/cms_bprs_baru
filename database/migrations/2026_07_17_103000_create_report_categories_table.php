<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 100)->unique();
            $table->string('name');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Migrate data from site_settings
        $settings = DB::table('site_settings')->first();
        if ($settings) {
            $categories = [
                [
                    'slug' => 'keuangan_publikasi',
                    'name' => 'Laporan Keuangan Publikasi',
                    'title' => $settings->report_keuangan_publikasi_title ?? 'Laporan Keuangan Publikasi',
                    'subtitle' => $settings->report_keuangan_publikasi_subtitle ?? 'Laporan keuangan publikasi BPR Syariah',
                    'description' => $settings->report_keuangan_publikasi_description ?? '',
                    'sort_order' => 1,
                ],
                [
                    'slug' => 'tata_kelola',
                    'name' => 'Laporan Tata Kelola',
                    'title' => $settings->report_tata_kelola_title ?? 'Laporan Tata Kelola',
                    'subtitle' => $settings->report_tata_kelola_subtitle ?? 'Laporan tata kelola perusahaan',
                    'description' => $settings->report_tata_kelola_description ?? '',
                    'sort_order' => 2,
                ],
                [
                    'slug' => 'tahunan',
                    'name' => 'Laporan Tahunan',
                    'title' => $settings->report_tahunan_title ?? 'Laporan Tahunan',
                    'subtitle' => $settings->report_tahunan_subtitle ?? 'Laporan tahunan BPR Syariah',
                    'description' => $settings->report_tahunan_description ?? '',
                    'sort_order' => 3,
                ],
                [
                    'slug' => 'tahunan_berkelanjutan',
                    'name' => 'Laporan Tahunan Berkelanjutan',
                    'title' => $settings->report_tahunan_berkelanjutan_title ?? 'Laporan Tahunan Berkelanjutan',
                    'subtitle' => $settings->report_tahunan_berkelanjutan_subtitle ?? 'Laporan tahunan berkelanjutan BPR Syariah',
                    'description' => $settings->report_tahunan_berkelanjutan_description ?? '',
                    'sort_order' => 4,
                ],
            ];

            foreach ($categories as $cat) {
                DB::table('report_categories')->insert($cat + [
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('report_categories');
    }
};
