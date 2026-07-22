<?php

namespace App\Jobs;

use App\Services\ImageService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessImageUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * The maximum number of unhandled exceptions to allow before failing.
     */
    public int $maxExceptions = 1;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $filePath,
        public readonly array $options = [],
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($this->filePath)) {
            Log::warning('ProcessImageUpload: file not found', ['path' => $this->filePath]);
            return;
        }

        ImageService::processUploadedImage($this->filePath, $this->options);

        Log::info('Responsive variants generated', [
            'path' => $this->filePath,
            'options' => $this->options,
        ]);
    }

    /**
     * Get the backoff strategy for failed jobs.
     *
     * @return array<int, int>
     */
    public function backoff(): array
    {
        return [5, 15, 60]; // seconds
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $e): void
    {
        Log::error('ProcessImageUpload failed', [
            'path' => $this->filePath,
            'error' => $e->getMessage(),
        ]);
    }
}
