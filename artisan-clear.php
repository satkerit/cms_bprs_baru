<?php

/**
 * artisan-clear.php
 * Laravel cache clearer untuk production (akses via browser)
 *
 * PENTING: Hapus atau proteksi file ini setelah digunakan
 * URL: https://yourdomain.com/artisan-clear.php?token=YOUR_SECRET_TOKEN
 */

define('LARAVEL_START', microtime(true));

// ============================================
// SECURITY — Token protection
// ============================================
$secret = env_val('SECRET_CACHE_TOKEN', 'change-this-secret-token');
$token  = $_GET['token'] ?? '';

if (!hash_equals($secret, $token)) {
    http_response_code(403);
    die('403 Forbidden');
}

// ============================================
// Bootstrap Laravel
// ============================================
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// ============================================
// Run all clear commands
// ============================================
$commands = [
    'config:clear'   => 'Configuration cache',
    'cache:clear'    => 'Application cache',
    'route:clear'    => 'Route cache',
    'view:clear'     => 'View cache',
    'event:clear'    => 'Event cache',
    'schedule:clear-mutex' => 'Scheduled task mutexes',
];

$results = [];
foreach ($commands as $command => $label) {
    try {
        $exitCode = Artisan::call($command);
        $results[] = ['label' => $label, 'command' => $command, 'status' => $exitCode === 0 ? 'ok' : 'warn', 'output' => trim(Artisan::output())];
    } catch (Throwable $e) {
        $results[] = ['label' => $label, 'command' => $command, 'status' => 'error', 'output' => $e->getMessage()];
    }
}

// Opcache reset (jika tersedia)
$opcache = false;
if (function_exists('opcache_reset')) {
    opcache_reset();
    $opcache = true;
}

$elapsed = round((microtime(true) - LARAVEL_START) * 1000, 2);

// ============================================
// Helper
// ============================================
function env_val(string $key, string $default): string
{
    $val = getenv($key);
    return ($val !== false && $val !== '') ? $val : $default;
}

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cache Clear — Laravel</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: system-ui, sans-serif;
            background: #0f172a;
            color: #e2e8f0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 12px;
            padding: 2rem;
            width: 100%;
            max-width: 560px;
        }

        h1 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #f8fafc;
            margin-bottom: 0.25rem;
        }

        .meta {
            font-size: 0.75rem;
            color: #64748b;
            margin-bottom: 1.5rem;
        }

        .row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.6rem 0;
            border-bottom: 1px solid #1e293b;
            gap: 0.5rem;
        }

        .row:last-child {
            border-bottom: none;
        }

        .label {
            font-size: 0.875rem;
            color: #cbd5e1;
        }

        .cmd {
            font-size: 0.7rem;
            color: #475569;
            font-family: monospace;
        }

        .badge {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0.2rem 0.6rem;
            border-radius: 999px;
            white-space: nowrap;
        }

        .ok {
            background: #052e16;
            color: #4ade80;
        }

        .warn {
            background: #1c1917;
            color: #fbbf24;
        }

        .error {
            background: #1f0000;
            color: #f87171;
        }

        .footer {
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid #334155;
            font-size: 0.75rem;
            color: #475569;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .opcache {
            font-size: 0.7rem;
            padding: 0.2rem 0.6rem;
            border-radius: 999px;
            background: #0c1a2e;
            color: #38bdf8;
        }
    </style>
</head>

<body>
    <div class="card">
        <h1>Laravel Cache Clear</h1>
        <div class="meta"><?= date('d M Y, H:i:s') ?> &mdash; <?= htmlspecialchars(config('app.name', 'App')) ?></div>

        <?php foreach ($results as $r): ?>
            <div class="row">
                <div>
                    <div class="label"><?= htmlspecialchars($r['label']) ?></div>
                    <div class="cmd">php artisan <?= htmlspecialchars($r['command']) ?></div>
                    <?php if ($r['output']): ?>
                        <div class="cmd" style="color:#ef4444;margin-top:2px"><?= htmlspecialchars($r['output']) ?></div>
                    <?php endif; ?>
                </div>
                <span class="badge <?= $r['status'] ?>">
                    <?= $r['status'] === 'ok' ? 'Cleared' : strtoupper($r['status']) ?>
                </span>
            </div>
        <?php endforeach; ?>

        <div class="footer">
            <span><?= $elapsed ?>ms</span>
            <?php if ($opcache): ?>
                <span class="opcache">OPcache reset</span>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
