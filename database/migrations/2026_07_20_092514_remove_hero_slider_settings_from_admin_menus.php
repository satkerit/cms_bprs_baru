<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Remove the redundant "Pengaturan Slide" menu since "Slides" already exists.
     */
    public function up(): void
    {
        $menu = DB::table('admin_menus')->where('key', 'hero-slider-settings')->first();

        if ($menu) {
            DB::table('admin_menu_permissions')->where('admin_menu_id', $menu->id)->delete();
            DB::table('admin_menus')->where('id', $menu->id)->delete();

            // Revert order shifts in Konten section
            DB::table('admin_menus')
                ->where('section', 'Konten')
                ->where('order', '>', 10)
                ->decrement('order');
        }

        Cache::forget('admin_menus_all_with_permissions');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $exists = DB::table('admin_menus')->where('key', 'hero-slider-settings')->exists();

        if (!$exists) {
            $id = DB::table('admin_menus')->insertGetId([
                'key' => 'hero-slider-settings',
                'name' => 'Pengaturan Slide',
                'route' => 'admin.hero-slides.settings',
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

            // Add permissions for roles
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
};
