<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Role & permission harus dibuat dulu agar UserSeeder bisa
            // mengaitkan user ke role (role_id) dengan benar.
            RolePermissionSeeder::class,
            UserSeeder::class,
            AdminMenuSeeder::class,
            CompanyInfoSeeder::class,
            BoardMemberSeeder::class,
            ProductSeeder::class,
            HeroSlideSeeder::class,
            OfficeSeeder::class,
            AuctionSeeder::class,
            NewsSeeder::class,
            FinancingConfigSeeder::class,
            KasKelilingSeeder::class,
            BrochureSeeder::class,
            SiteSettingSeeder::class,
        ]);
    }
}
