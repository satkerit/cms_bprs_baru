<?php

/**
 * clear.php — proxy untuk artisan-clear.php
 * Akses: https://yourdomain.com/dev/clear.php?token=YOUR_TOKEN
 *
 * Struktur hosting:
 *   public_html/dev/   ← __DIR__ (web root)
 *   cms_baru/          ← root Laravel (satu level di atas public_html)
 *
 * Sesuaikan $rootPath dengan path absolut root Laravel di hosting Anda.
 * Contoh: /home/username/cms_baru
 */

// Path relatif: public_html/dev/ → ../../cms_baru
// Atau ganti dengan path absolut jika perlu, contoh:
// $rootPath = '/home/username/cms_baru';
$rootPath = realpath(__DIR__ . '/../../app');

if (!$rootPath || !file_exists($rootPath . '/artisan-clear.php')) {
    http_response_code(500);
    die('Laravel root tidak ditemukan. Edit $rootPath di file ini dengan path absolut ke root Laravel.<br>Dicari di: ' . $rootPath);
}

require $rootPath . '/artisan-clear.php';
