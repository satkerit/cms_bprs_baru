<?php

namespace App\Jobs;

use App\Mail\ComplaintStatusUpdateMail;
use App\Models\CompanyInfo;
use App\Models\Complaint;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendComplaintStatusEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * Delete the job if its model no longer exists.
     */
    public bool $deleteWhenMissingModels = true;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly Complaint $complaint,
        public readonly string $oldStatus,
        public readonly ?string $adminNotes = null,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $complaint = $this->complaint;
        $email = $complaint->email;

        if (!$email || $email === 'anonymous@whistleblowing.local') {
            return;
        }

        $companyInfo = CompanyInfo::first();

        Mail::to($email)->send(new ComplaintStatusUpdateMail(
            $complaint,
            $this->oldStatus,
            $this->adminNotes,
            $companyInfo,
        ));

        Log::info('Complaint status email sent', [
            'complaint_id' => $complaint->id,
            'old_status' => $this->oldStatus,
            'new_status' => $complaint->status,
            'email' => $email,
        ]);
    }

    /**
     * Get the backoff strategy for failed jobs.
     *
     * @return array<int, int>
     */
    public function backoff(): array
    {
        return [5, 30, 120]; // seconds
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $e): void
    {
        Log::error('SendComplaintStatusEmail failed', [
            'complaint_id' => $this->complaint->id ?? null,
            'error' => $e->getMessage(),
        ]);
    }
}
