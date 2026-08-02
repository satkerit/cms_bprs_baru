<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('seo_site_name', 100)->nullable()->after('max_auction_image_size_kb');
            $table->string('seo_default_description', 300)->nullable()->after('seo_site_name');
            $table->string('seo_default_keywords', 500)->nullable()->after('seo_default_description');
            $table->string('seo_og_image', 500)->nullable()->after('seo_default_keywords');
            $table->string('seo_twitter_handle', 100)->nullable()->after('seo_og_image');
            $table->string('seo_google_verification', 200)->nullable()->after('seo_twitter_handle');
            $table->string('seo_bing_verification', 200)->nullable()->after('seo_google_verification');
            $table->string('seo_robots_default', 50)->nullable()->default('index, follow')->after('seo_bing_verification');
            $table->boolean('seo_canonical_enabled')->default(true)->after('seo_robots_default');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'seo_site_name', 'seo_default_description', 'seo_default_keywords',
                'seo_og_image', 'seo_twitter_handle', 'seo_google_verification',
                'seo_bing_verification', 'seo_robots_default', 'seo_canonical_enabled',
            ]);
        });
    }
};
