<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix route name for hero-slider-settings menu
        DB::table('admin_menus')
            ->where('key', 'hero-slider-settings')
            ->update([
                'route' => 'admin.hero-slider-settings.edit',
                'updated_at' => now(),
            ]);

        // Clear cache
        Cache::forget('admin_menus_all_with_permissions');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert route name
        DB::table('admin_menus')
            ->where('key', 'hero-slider-settings')
            ->update([
                'route' => 'hero-slider-settings.edit',
                'updated_at' => now(),
            ]);

        Cache::forget('admin_menus_all_with_permissions');
    }
};
