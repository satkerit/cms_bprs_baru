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
        Schema::table('visitor_logs', function (Blueprint $table) {
            // Composite index untuk query analitik yang memfilter rentang created_at
            // lalu mengelompokkan (groupBy) per url / device_type / browser.
            $table->index(['created_at', 'url'], 'visitor_logs_created_url_index');
            $table->index(['created_at', 'device_type'], 'visitor_logs_created_device_index');
            $table->index(['created_at', 'browser'], 'visitor_logs_created_browser_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visitor_logs', function (Blueprint $table) {
            $table->dropIndex('visitor_logs_created_url_index');
            $table->dropIndex('visitor_logs_created_device_index');
            $table->dropIndex('visitor_logs_created_browser_index');
        });
    }
};
