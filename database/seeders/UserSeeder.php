<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Get (or create) roles — memastikan user selalu mendapat role_id yang valid,
        // baik saat dijalankan via DatabaseSeeder maupun secara terpisah (--class=UserSeeder)
        // sebelum RolePermissionSeeder dieksekusi.
        $superAdminRole = Role::firstOrCreate(
            ['name' => User::ROLE_SUPER_ADMIN],
            ['display_name' => 'Super Admin', 'is_system' => true, 'is_active' => true]
        );
        $adminRole = Role::firstOrCreate(
            ['name' => User::ROLE_ADMIN],
            ['display_name' => 'Admin', 'is_system' => true, 'is_active' => true]
        );
        $editorRole = Role::firstOrCreate(
            ['name' => User::ROLE_EDITOR],
            ['display_name' => 'Editor', 'is_system' => true, 'is_active' => true]
        );

        // Super Admin
        User::updateOrCreate(
            ['email' => 'superadmin@bprsyariah.co.id'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role_id' => $superAdminRole->id,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Admin
        User::updateOrCreate(
            ['email' => 'admin@bprsyariah.co.id'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Editor
        User::updateOrCreate(
            ['email' => 'editor@bprsyariah.co.id'],
            [
                'name' => 'Editor',
                'password' => Hash::make('password'),
                'role_id' => $editorRole->id,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
