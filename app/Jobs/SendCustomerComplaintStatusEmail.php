<?php

namespace App\Jobs;

use App\Mail\CustomerComplaintStatusUpdateMail;
use App\Models\CompanyInfo;
use App\Models\CustomerComplaint;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendCustomerComplaintStatusEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public bool $deleteWhenMissingModels = true;

    public function __construct(
        public readonly CustomerComplaint $customerComplaint,
        public readonly string $oldStatus,
        public readonly ?string $adminNotes = null,
        public readonly ?string $resolution = null,
    ) {}

    public function handle(): void
    {
        $complaint = $this->customerComplaint;
        $email = $complaint->email;

        if (!$email) {
            return;
        }

        $companyInfo = CompanyInfo::first();

        Mail::to($email)->send(new CustomerComplaintStatusUpdateMail(
            $complaint,
            $this->oldStatus,
            $this->adminNotes,
            $this->resolution,
            $companyInfo,
        ));

        Log::info('Customer complaint status email sent', [
            'complaint_id' => $complaint->id,
            'old_status' => $this->oldStatus,
            'new_status' => $complaint->status,
        ]);
    }

    public function backoff(): array
    {
        return [5, 30, 120];
    }

    public function failed(\Throwable $e): void
    {
        Log::error('SendCustomerComplaintStatusEmail failed', [
            'complaint_id' => $this->customerComplaint->id ?? null,
            'error' => $e->getMessage(),
        ]);
    }
}
