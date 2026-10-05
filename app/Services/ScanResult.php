<?php

namespace App\Services;

class ScanResult
{
    public const CLEAN = 'clean';
    public const INFECTED = 'infected';
    public const ERROR = 'error';
    public const SKIPPED = 'skipped';

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

    public function isError(): bool
    {
        return $this->status === self::ERROR;
    }

    public function isInfected(): bool
    {
        return $this->status === self::INFECTED;
    }
}
