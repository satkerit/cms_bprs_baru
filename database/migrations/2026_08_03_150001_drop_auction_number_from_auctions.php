<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Kolom auction_number tidak lagi dibutuhkan pada pendekatan sederhana.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('auctions', function (Blueprint $table) {
            if (Schema::hasColumn('auctions', 'auction_number')) {
                $table->dropColumn('auction_number');
            }
        });
    }

    public function down(): void
    {
        Schema::table('auctions', function (Blueprint $table) {
            if (!Schema::hasColumn('auctions', 'auction_number')) {
                $table->string('auction_number')->nullable()->after('slug');
            }
        });
    }
};
