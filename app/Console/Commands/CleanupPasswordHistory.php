<?php

namespace App\Console\Commands;

use App\Models\PasswordHistory;
use Illuminate\Console\Command;

class CleanupPasswordHistory extends Command
{
    /**
     * Nama command artisan (dipakai di routes/console.php scheduler).
     *
     * @var string
     */
    protected $signature = 'password-history:cleanup
                            {--days=365 : Simpan riwayat password maksimal N hari}';

    /**
     * Deskripsi command.
     *
     * @var string
     */
    protected $description = 'Hapus riwayat password yang lebih tua dari jumlah hari tertentu';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $days = (int) $this->option('days');

        if ($days < 30) {
            $this->error('Minimal --days adalah 30 agar riwayat password terakhir tetap bisa dicek (kebijakan reuse 5x).');

            return self::FAILURE;
        }

        $deleted = PasswordHistory::cleanup($days);

        $this->info("Riwayat password lebih tua dari {$days} hari dihapus: {$deleted}");

        return self::SUCCESS;
    }
}
