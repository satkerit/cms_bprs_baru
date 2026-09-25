<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanExpiredSessions extends Command
{
    /**
     * Nama command artisan (dipakai di routes/console.php scheduler).
     *
     * @var string
     */
    protected $signature = 'sessions:clean-expired';

    /**
     * Deskripsi command.
     *
     * @var string
     */
    protected $description = 'Hapus session kedaluwarsa dari tabel sessions (driver database)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // Hanya relevan bila session driver = database
        if (config('session.driver') !== 'database') {
            $this->info('Session driver bukan database — tidak ada yang perlu dibersihkan.');

            return self::SUCCESS;
        }

        $table = config('session.table', 'sessions');
        $lifetime = (int) config('session.lifetime', 60);

        $deleted = DB::table($table)
            ->where('last_activity', '<', now()->subMinutes($lifetime)->getTimestamp())
            ->delete();

        $this->info("Session kedaluwarsa dihapus: {$deleted}");

        return self::SUCCESS;
    }
}
