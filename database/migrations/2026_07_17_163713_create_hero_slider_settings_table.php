<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hero_slider_settings', function (Blueprint $table) {
            $table->id();
            
            // Minimal dimensions
            $table->unsignedInteger('min_width')->default(320)->comment('Minimum width in pixels');
            $table->unsignedInteger('min_height')->default(240)->comment('Minimum height in pixels');
            
            // Maximum dimensions
            $table->unsignedInteger('max_width')->default(3840)->comment('Maximum width in pixels');
            $table->unsignedInteger('max_height')->default(2160)->comment('Maximum height in pixels');
            
            // File size limit
            $table->unsignedInteger('max_file_size_mb')->default(5)->comment('Maximum file size in MB');
            
            // Aspect ratio (stored as string "16:9")
            $table->string('aspect_ratio')->default('16:9')->comment('Aspect ratio format');
            
            // Delay/Duration
            $table->unsignedInteger('slider_delay_ms')->default(7000)->comment('Auto-play delay in milliseconds');
            
            // Container settings
            $table->unsignedInteger('min_height_px')->default(320)->comment('Minimum container height');
            $table->unsignedInteger('max_height_px')->default(600)->comment('Maximum container height');
            
            // Enable/Disable features
            $table->boolean('enable_autoplay')->default(true);
            $table->boolean('enable_touch_swipe')->default(true);
            $table->boolean('enable_navigation_arrows')->default(true);
            $table->boolean('enable_dot_indicators')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_slider_settings');
    }
};

