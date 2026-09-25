<?php

namespace App\Console\Commands;

use App\Models\BlockedIp;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CleanupBlockedIps extends Command
{
    /**
     * Nama command artisan (dipakai di routes/console.php scheduler).
     *
     * @var string
     */
    protected $signature = 'security:cleanup-blocked-ips';

    /**
     * Deskripsi command.
     *
     * @var string
     */
    protected $description = 'Hapus IP yang blokirnya sudah kedaluwarsa (non-permanent) dari tabel blocked_ips';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // Ambil dulu daftar IP yang akan dihapus untuk keperluan log
        $expiredIps = BlockedIp::expired()->pluck('ip_address');

        $deleted = BlockedIp::expired()->delete();

        if ($deleted > 0) {
            Log::info('security:cleanup-blocked-ips', [
                'deleted' => $deleted,
                'ips' => $expiredIps->all(),
            ]);
        }

        $this->info("Blokir IP kedaluwarsa dihapus: {$deleted}");

        return self::SUCCESS;
    }
}
