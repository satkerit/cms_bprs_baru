<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Adds columns expected by the application that were missing from
     * the Spatie permission package's permissions and roles tables.
     */
    public function up(): void
    {
        // Fix permissions table
        if (Schema::hasTable('permissions')) {
            // Add default value for guard_name so inserts without it don't fail
            DB::statement("ALTER TABLE `permissions` MODIFY `guard_name` VARCHAR(255) NOT NULL DEFAULT 'web'");

            if (!Schema::hasColumn('permissions', 'display_name')) {
                Schema::table('permissions', function (Blueprint $table) {
                    $table->string('display_name')->after('name');
                });
            }

            if (!Schema::hasColumn('permissions', 'description')) {
                Schema::table('permissions', function (Blueprint $table) {
                    $table->text('description')->nullable()->after('display_name');
                });
            }

            if (!Schema::hasColumn('permissions', 'group')) {
                Schema::table('permissions', function (Blueprint $table) {
                    $table->string('group')->default('General')->after('description');
                });
            }

            if (!Schema::hasColumn('permissions', 'is_system')) {
                Schema::table('permissions', function (Blueprint $table) {
                    $table->boolean('is_system')->default(false)->after('group');
                });
            }

            if (!Schema::hasColumn('permissions', 'is_active')) {
                Schema::table('permissions', function (Blueprint $table) {
                    $table->boolean('is_active')->default(true)->after('is_system');
                });
            }
        }

        // Fix roles table
        if (Schema::hasTable('roles')) {
            // Add default value for guard_name so inserts without it don't fail
            DB::statement("ALTER TABLE `roles` MODIFY `guard_name` VARCHAR(255) NOT NULL DEFAULT 'web'");

            if (!Schema::hasColumn('roles', 'display_name')) {
                Schema::table('roles', function (Blueprint $table) {
                    $table->string('display_name')->after('name');
                });
            }

            if (!Schema::hasColumn('roles', 'description')) {
                Schema::table('roles', function (Blueprint $table) {
                    $table->text('description')->nullable()->after('display_name');
                });
            }

            if (!Schema::hasColumn('roles', 'is_system')) {
                Schema::table('roles', function (Blueprint $table) {
                    $table->boolean('is_system')->default(false);
                });
            }

            if (!Schema::hasColumn('roles', 'is_active')) {
                Schema::table('roles', function (Blueprint $table) {
                    $table->boolean('is_active')->default(true);
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('permissions')) {
            Schema::table('permissions', function (Blueprint $table) {
                $columns = ['display_name', 'description', 'group', 'is_system', 'is_active'];
                foreach ($columns as $column) {
                    if (Schema::hasColumn('permissions', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }

        if (Schema::hasTable('roles')) {
            Schema::table('roles', function (Blueprint $table) {
                $columns = ['display_name', 'description', 'is_system', 'is_active'];
                foreach ($columns as $column) {
                    if (Schema::hasColumn('roles', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
