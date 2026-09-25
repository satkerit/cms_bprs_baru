<?php

namespace App\Console\Commands;

use App\Models\VisitorLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CleanVisitorLogs extends Command
{
    /**
     * Nama command artisan (dipakai di routes/console.php scheduler).
     *
     * @var string
     */
    protected $signature = 'visitor-logs:clean
                            {--days=180 : Hapus log kunjungan lebih tua dari N hari}';

    /**
     * Deskripsi command.
     *
     * @var string
     */
    protected $description = 'Hapus log kunjungan (visitor_logs) yang lebih tua dari jumlah hari tertentu';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $days = (int) $this->option('days');

        if ($days < 30) {
            $this->error('Minimal --days adalah 30 agar statistik analitik minimal tersedia satu bulan.');

            return self::FAILURE;
        }

        // Hapus per-chunk agar tidak membebani memori saat tabel besar
        $deleted = 0;
        VisitorLog::where('created_at', '<', now()->subDays($days))
            ->chunkById(1000, function ($logs) use (&$deleted) {
                $deleted += $logs->count();
            });

        // chunkById hanya traverse; hapus pakai query per-batch
        $total = 0;
        do {
            $total += VisitorLog::where('created_at', '<', now()->subDays($days))
                ->limit(1000)
                ->delete();
        } while ($total > 0 && $total % 1000 === 0);

        Log::info('visitor-logs:clean', ['days' => $days, 'deleted' => $total]);

        $this->info("Log kunjungan lebih tua dari {$days} hari dihapus: {$total}");

        return self::SUCCESS;
    }
}
