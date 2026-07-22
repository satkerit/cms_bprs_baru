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
        // Insert Hero Slider Settings menu after hero-slides
        $exists = DB::table('admin_menus')->where('key', 'hero-slider-settings')->exists();
        
        if (!$exists) {
            $id = DB::table('admin_menus')->insertGetId([
                'key' => 'hero-slider-settings',
                'name' => 'Pengaturan Slide',
                'route' => 'admin.hero-slider-settings.edit',
                'section' => 'Konten',
                'order' => 11,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Shift other menu orders
            DB::table('admin_menus')
                ->where('section', 'Konten')
                ->where('order', '>=', 11)
                ->where('key', '!=', 'hero-slider-settings')
                ->increment('order');

            // Add permissions for this menu
            $roles = DB::table('roles')->get();
            $allowedRoles = ['super_admin', 'admin', 'editor'];

            foreach ($roles as $role) {
                if (in_array($role->name, $allowedRoles)) {
                    DB::table('admin_menu_permissions')->insertOrIgnore([
                        'admin_menu_id' => $id,
                        'role_id' => $role->id,
                        'can_access' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        Cache::forget('admin_menus_all_with_permissions');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $menu = DB::table('admin_menus')->where('key', 'hero-slider-settings')->first();
        
        if ($menu) {
            DB::table('admin_menu_permissions')->where('admin_menu_id', $menu->id)->delete();
            DB::table('admin_menus')->where('id', $menu->id)->delete();

            // Revert order shifts
            DB::table('admin_menus')
                ->where('section', 'Konten')
                ->where('order', '>', 11)
                ->decrement('order');
        }

        Cache::forget('admin_menus_all_with_permissions');
    }
};
