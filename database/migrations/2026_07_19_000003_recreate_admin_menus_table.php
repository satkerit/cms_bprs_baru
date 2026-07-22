<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This migration exists because the original admin_menus table
     * was dropped but the original migration is already marked as ran.
     */
    public function up(): void
    {
        if (!Schema::hasTable('admin_menus')) {
            Schema::create('admin_menus', function (Blueprint $table) {
                $table->id();
                $table->string('key')->unique();
                $table->string('name');
                $table->string('route')->nullable();
                $table->string('icon')->nullable();
                $table->string('section')->nullable();
                $table->unsignedInteger('order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('admin_menu_permissions')) {
            Schema::create('admin_menu_permissions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('admin_menu_id')->constrained('admin_menus')->onDelete('cascade');
                $table->unsignedBigInteger('role_id');
                $table->boolean('can_access')->default(true);
                $table->timestamps();

                $table->unique(['admin_menu_id', 'role_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Do not drop to prevent accidental data loss
    }
};
