<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Index untuk complaints.status
        if (Schema::hasTable('complaints') && !$this->indexExists('complaints', 'complaints_status_index')) {
            Schema::table('complaints', function (Blueprint $table) {
                $table->index('status', 'complaints_status_index');
            });
        }

        // Index untuk careers.is_active
        if (Schema::hasTable('careers') && !$this->indexExists('careers', 'careers_is_active_index')) {
            Schema::table('careers', function (Blueprint $table) {
                $table->index('is_active', 'careers_is_active_index');
            });
        }

        // Index untuk news.is_published + published_at (composite)
        if (Schema::hasTable('news') && !$this->indexExists('news', 'news_published_at_index')) {
            Schema::table('news', function (Blueprint $table) {
                $table->index(['is_published', 'published_at'], 'news_published_at_index');
            });
        }
    }

    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropIndexIfExists('complaints_status_index');
        });
        Schema::table('careers', function (Blueprint $table) {
            $table->dropIndexIfExists('careers_is_active_index');
        });
        Schema::table('news', function (Blueprint $table) {
            $table->dropIndexIfExists('news_published_at_index');
        });
    }

    private function indexExists(string $table, string $index): bool
    {
        return collect(\DB::select("SHOW INDEX FROM `{$table}`"))
            ->pluck('Key_name')
            ->contains($index);
    }
};
