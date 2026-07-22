<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileScanner
{
    protected bool $enabled;
    protected bool $quarantineEnabled;
    protected string $quarantinePath;
    protected array $malwarePatterns;

    public function __construct()
    {
        $this->enabled = config('security.upload.scan_viruses', false);
        $this->quarantineEnabled = config('security.upload.quarantine_suspicious', true);
        $this->quarantinePath = 'quarantine';

        $this->malwarePatterns = [
            'elf' => [0x7f, 0x45, 0x4c, 0x46],
            'mach_o' => [0xcf, 0xfa, 0xed, 0xfe],
            'pe_dos' => [0x4d, 0x5a],
            'php_script' => null,
            'shell_script' => null,
        ];
    }

    public function scan(UploadedFile $file): ScanResult
    {
        if (!$this->enabled) {
            return ScanResult::skipped();
        }

        try {
            $result = $this->scanWithClamAv($file);

            if ($result !== null) {
                return $result;
            }

            return $this->scanByPatterns($file);
        } catch (\Throwable $e) {
            Log::warning('FileScanner error: ' . $e->getMessage(), [
                'file' => $file->getClientOriginalName()
            ]);
            return ScanResult::error($e->getMessage());
        }
    }

    public function scanPath(string $absolutePath, ?string $originalName = null): ScanResult
    {
        if (!$this->enabled) {
            return ScanResult::skipped();
        }

        try {
            $result = $this->scanWithClamAvPath($absolutePath);

            if ($result !== null) {
                return $result;
            }

            return $this->scanByPatternsPath($absolutePath, $originalName);
        } catch (\Throwable $e) {
            Log::warning('FileScanner path error: ' . $e->getMessage());
            return ScanResult::error($e->getMessage());
        }
    }

    public function quarantine(UploadedFile $file): ?string
    {
        if (!$this->quarantineEnabled) {
            return null;
        }

        try {
            $name = 'suspicious_' . time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs($this->quarantinePath, $name, 'local');

            Log::warning('File quarantined', [
                'original_name' => $file->getClientOriginalName(),
                'quarantine_path' => $path,
                'size' => $file->getSize(),
            ]);

            return $path;
        } catch (\Throwable $e) {
            Log::error('Failed to quarantine file: ' . $e->getMessage());
            return null;
        }
    }

    public function quarantinePath(string $absolutePath): ?string
    {
        if (!$this->quarantineEnabled) {
            return null;
        }

        try {
            $name = 'suspicious_' . time() . '_' . basename($absolutePath);
            $destPath = storage_path('app/' . $this->quarantinePath . '/' . $name);

            if (!is_dir(dirname($destPath))) {
                mkdir(dirname($destPath), 0755, true);
            }

            copy($absolutePath, $destPath);

            Log::warning('File quarantined from path', [
                'source' => $absolutePath,
                'destination' => $destPath,
            ]);

            return $destPath;
        } catch (\Throwable $e) {
            Log::error('Failed to quarantine file path: ' . $e->getMessage());
            return null;
        }
    }

    protected function scanWithClamAv(UploadedFile $file): ?ScanResult
    {
        try {
            $socket = @fsockopen('unix:///var/run/clamav/clamd.sock', -1, $errno, $errstr, 5);

            if (!$socket) {
                $socket = @fsockopen('127.0.0.1', 3310, $errno, $errstr, 5);
            }

            if (!$socket) {
                return null;
            }

            $filePath = $file->getRealPath();
            if (!$filePath || !file_exists($filePath)) {
                fclose($socket);
                return null;
            }

            $command = "SCAN {$filePath}\n";
            fwrite($socket, $command);

            $response = '';
            while (!feof($socket)) {
                $response .= fgets($socket, 4096);
            }

            fclose($socket);

            if (preg_match('/^\s*' . preg_quote($filePath, '/') . ':\s*(.+)\s*$/m', $response, $matches)) {
                $status = trim($matches[1]);

                if ($status === 'OK') {
                    return ScanResult::clean();
                }

                if (stripos($status, 'FOUND') !== false) {
                    $virusName = str_replace(' FOUND', '', $status);
                    return ScanResult::infected($virusName);
                }

                if (stripos($status, 'ERROR') !== false) {
                    return ScanResult::error($status);
                }
            }

            return ScanResult::clean();
        } catch (\Throwable $e) {
            Log::debug('ClamAV scan unavailable: ' . $e->getMessage());
            return null;
        }
    }

    protected function scanWithClamAvPath(string $absolutePath): ?ScanResult
    {
        if (!file_exists($absolutePath)) {
            return null;
        }

        try {
            $socket = @fsockopen('unix:///var/run/clamav/clamd.sock', -1, $errno, $errstr, 5);

            if (!$socket) {
                $socket = @fsockopen('127.0.0.1', 3310, $errno, $errstr, 5);
            }

            if (!$socket) {
                return null;
            }

            $command = "SCAN {$absolutePath}\n";
            fwrite($socket, $command);

            $response = '';
            while (!feof($socket)) {
                $response .= fgets($socket, 4096);
            }

            fclose($socket);

            if (preg_match('/^\s*' . preg_quote($absolutePath, '/') . ':\s*(.+)\s*$/m', $response, $matches)) {
                $status = trim($matches[1]);

                if ($status === 'OK') {
                    return ScanResult::clean();
                }

                if (stripos($status, 'FOUND') !== false) {
                    $virusName = str_replace(' FOUND', '', $status);
                    return ScanResult::infected($virusName);
                }

                if (stripos($status, 'ERROR') !== false) {
                    return ScanResult::error($status);
                }
            }

            return ScanResult::clean();
        } catch (\Throwable $e) {
            Log::debug('ClamAV path scan unavailable: ' . $e->getMessage());
            return null;
        }
    }

    protected function scanByPatterns(UploadedFile $file): ScanResult
    {
        $filePath = $file->getRealPath();
        if (!$filePath || !file_exists($filePath)) {
            return ScanResult::error('File not accessible');
        }

        return $this->scanByPatternsPath($filePath, $file->getClientOriginalName());
    }

    protected function scanByPatternsPath(string $absolutePath, ?string $originalName = null): ScanResult
    {
        if (!file_exists($absolutePath)) {
            return ScanResult::error('File not found');
        }

        $ext = $originalName ? strtolower(pathinfo($originalName, PATHINFO_EXTENSION)) : '';
        $mime = @mime_content_type($absolutePath);
        $extMap = [
            'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png', 'gif' => 'image/gif',
            'webp' => 'image/webp', 'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ];

        if ($ext && isset($extMap[$ext]) && $mime) {
            $expectedMime = $extMap[$ext];

            $allowedMimes = [
                'image/jpeg', 'image/png', 'image/gif', 'image/webp',
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/octet-stream',
                'text/plain',
                'text/csv',
            ];

            if (!in_array($mime, $allowedMimes, true)) {
                if (!str_starts_with($mime, 'image/') && $extMap[$ext] !== $mime) {
                    return ScanResult::infected("MIME mismatch: extension={$ext}, detected={$mime}");
                }
            }

            if ($extMap[$ext] !== $mime && $mime !== 'application/octet-stream') {
                if (!str_starts_with($mime, 'image/')) {
                    return ScanResult::infected("MIME type mismatch: expected {$extMap[$ext]}, got {$mime}");
                }
            }
        }

        $size = filesize($absolutePath);
        if ($size === 0) {
            return ScanResult::clean();
        }

        $handle = @fopen($absolutePath, 'rb');
        if (!$handle) {
            return ScanResult::error('Cannot read file');
        }

        $header = fread($handle, 4096);
        fclose($handle);

        if ($header === false || strlen($header) < 4) {
            return ScanResult::clean();
        }

        $bytes = array_values(unpack('C*', $header));

        if ($bytes[0] === 0x7f && $bytes[1] === 0x45 && $bytes[2] === 0x4c && $bytes[3] === 0x46) {
            return ScanResult::infected('ELF executable detected');
        }

        if ($bytes[0] === 0x4d && $bytes[1] === 0x5a) {
            return ScanResult::infected('PE executable detected');
        }

        if ($bytes[0] === 0xcf && $bytes[1] === 0xfa && $bytes[2] === 0xed && $bytes[3] === 0xfe) {
            return ScanResult::infected('Mach-O executable detected');
        }

        if ($ext === 'pdf') {
            $text = @file_get_contents($absolutePath, false, null, 0, 1048576);
            if ($text !== false) {
                if (preg_match('/\/JavaScript\s*>/i', $text) || preg_match('/\/Type\s*\/\s*Action\s*>/i', $text)) {
                    if (preg_match('/\/JS\s+/i', $text) || preg_match('/\/Launch\s+/i', $text)) {
                        return ScanResult::infected('PDF contains JavaScript or Launch action');
                    }
                }
            }
        }

        if (in_array($ext, ['doc', 'docx', 'xls', 'xlsx'])) {
            $text = @file_get_contents($absolutePath, false, null, 0, 524288);
            if ($text !== false) {
                if (stripos($text, 'AutoOpen') !== false || stripos($text, 'AutoExec') !== false
                    || stripos($text, 'Auto_Open') !== false || stripos($text, 'AutoExec') !== false) {
                    return ScanResult::infected('Office document with auto-exec macros');
                }
            }
        }

        $lowerHeader = strtolower(substr($header, 0, 512));
        if (preg_match('/<\?php/i', $lowerHeader) || preg_match('/<\?=/i', $lowerHeader)) {
            if (!in_array($ext, ['php', 'phtml', 'php3', 'php4', 'php5', 'pht', 'shtml', 'inc'])) {
                return ScanResult::infected('PHP code detected in non-PHP file');
            }
        }

        return ScanResult::clean();
    }
}

class ScanResult
{
    const CLEAN = 'clean';
    const INFECTED = 'infected';
    const ERROR = 'error';
    const SKIPPED = 'skipped';

    public string $status;
    public ?string $detail;

    protected function __construct(string $status, ?string $detail = null)
    {
        $this->status = $status;
        $this->detail = $detail;
    }

    public static function clean(): self
    {
        return new self(self::CLEAN);
    }

    public static function infected(string $virus): self
    {
        return new self(self::INFECTED, $virus);
    }

    public static function error(string $message): self
    {
        return new self(self::ERROR, $message);
    }

    public static function skipped(): self
    {
        return new self(self::SKIPPED);
    }

    public function isClean(): bool
    {
        return $this->status === self::CLEAN || $this->status === self::SKIPPED;
    }

    public function isInfected(): bool
    {
        return $this->status === self::INFECTED;
    }
}
