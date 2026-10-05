<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add fulltext index untuk news table (P-03)
        if (Schema::hasTable('news')) {
            Schema::table('news', function (Blueprint $table) {
                $table->fullText(['title', 'excerpt', 'content'])->change();
            });
        }

        // Add fulltext index untuk products table (P-03)
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                $table->fullText(['name', 'short_description', 'description'])->change();
            });
        }

        // Add fulltext index untuk reports table (P-03)
        if (Schema::hasTable('reports')) {
            Schema::table('reports', function (Blueprint $table) {
                $table->fullText(['title', 'description'])->change();
            });
        }
    }

    public function down(): void
    {
        // Drop fulltext indexes
        if (Schema::hasTable('news')) {
            Schema::table('news', function (Blueprint $table) {
                $table->dropFullText(['title', 'excerpt', 'content']);
            });
        }

        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropFullText(['name', 'short_description', 'description']);
            });
        }

        if (Schema::hasTable('reports')) {
            Schema::table('reports', function (Blueprint $table) {
                $table->dropFullText(['title', 'description']);
            });
        }
    }
};
