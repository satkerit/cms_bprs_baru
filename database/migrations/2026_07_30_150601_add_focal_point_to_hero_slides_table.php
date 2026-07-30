<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hero_slides', function (Blueprint $table) {
            $table->decimal('focal_x', 4, 3)->default(0.5)->after('image')->comment('Horizontal focal point 0.0-1.0 (left to right)');
            $table->decimal('focal_y', 4, 3)->default(0.5)->after('focal_x')->comment('Vertical focal point 0.0-1.0 (top to bottom)');
        });
    }

    public function down(): void
    {
        Schema::table('hero_slides', function (Blueprint $table) {
            $table->dropColumn(['focal_x', 'focal_y']);
        });
    }
};
