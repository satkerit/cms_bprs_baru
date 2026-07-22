<?php

namespace Tests\Integration;

use App\Models\Complaint;
use App\Models\ComplaintSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ComplaintFlowTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = $this->createSuperAdmin();
    }

    #[Test]
    public function anonymous_complaint_submission_flow(): void
    {
        $response = $this->withoutSecurityMiddleware()
            ->from(route('whistleblowing'))
            ->post(route('whistleblowing.store'), [
                'type' => 'fraud',
                'subject' => 'Test Anonymous Report',
                'description' => 'Detailed description of the issue',
                'is_anonymous' => true,
                'reported_person' => 'John Doe',
                'reported_department' => 'Finance',
                'incident_date' => now()->subDays(5)->format('Y-m-d'),
                'incident_location' => 'Main Office',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('complaints', [
            'subject' => 'Test Anonymous Report',
            'is_anonymous' => true,
            'status' => 'pending',
        ]);

        $complaint = Complaint::where('subject', 'Test Anonymous Report')->first();
        $this->assertNull($complaint->name);
        $this->assertNull($complaint->email);
        $this->assertMatchesRegularExpression('/^WBS-\d{8}-[A-Z0-9]{6}$/', $complaint->ticket_number);
    }

    #[Test]
    public function identified_complaint_submission_flow(): void
    {
        $response = $this->withoutSecurityMiddleware()
            ->from(route('whistleblowing'))
            ->post(route('whistleblowing.store'), [
                'name' => 'Reporting User',
                'email' => 'reporter@example.com',
                'phone' => '08123456789',
                'type' => 'violation',
                'subject' => 'Policy Violation Report',
                'description' => 'Details of the violation',
                'is_anonymous' => false,
                'reported_person' => 'Jane Doe',
                'incident_date' => now()->subDays(3)->format('Y-m-d'),
                'incident_location' => 'Branch Office',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('complaints', [
            'email' => 'reporter@example.com',
            'status' => 'pending',
        ]);
    }

    #[Test]
    public function complaint_xss_prevention_in_subject_and_description(): void
    {
        $response = $this->withoutSecurityMiddleware()
            ->from(route('whistleblowing'))
            ->post(route('whistleblowing.store'), [
                'type' => 'ethics',
                'subject' => '<script>alert("xss")</script>Real Issue',
                'description' => '<img onerror=alert(1) src=x>Description here',
                'is_anonymous' => true,
                'incident_date' => now()->format('Y-m-d'),
                'incident_location' => 'Office',
            ]);

        $response->assertRedirect();

        $complaint = Complaint::where('subject', 'LIKE', '%Real Issue%')->first();
        if ($complaint) {
            $this->assertStringNotContainsString('<script>', $complaint->subject);
            $this->assertStringNotContainsString('onerror', $complaint->description);
        }
    }

    #[Test]
    public function admin_complaint_management_flow(): void
    {
        $complaint = Complaint::factory()->create([
            'status' => 'pending',
        ]);

        $this->actingAs($this->admin);

        $listResponse = $this->withoutSecurityMiddleware()
            ->get(route('admin.complaints.index'));
        $listResponse->assertStatus(200);
        $listResponse->assertSee($complaint->ticket_number);

        $detailResponse = $this->withoutSecurityMiddleware()
            ->get(route('admin.complaints.show', $complaint));
        $detailResponse->assertStatus(200);

        $updateResponse = $this->withoutSecurityMiddleware()
            ->from(route('admin.complaints.show', $complaint))
            ->put(route('admin.complaints.update', $complaint), [
                'status' => 'investigating',
                'admin_notes' => 'Starting investigation',
            ]);

        $updateResponse->assertRedirect(route('admin.complaints.index'));

        $this->assertDatabaseHas('complaints', [
            'id' => $complaint->id,
            'status' => 'investigating',
            'admin_notes' => 'Starting investigation',
        ]);
    }

    #[Test]
    public function complaint_resolution_flow(): void
    {
        $complaint = Complaint::factory()->create([
            'status' => 'investigating',
        ]);

        $this->actingAs($this->admin);

        $response = $this->withoutSecurityMiddleware()
            ->from(route('admin.complaints.show', $complaint))
            ->put(route('admin.complaints.update', $complaint), [
                'status' => 'resolved',
                'admin_notes' => 'Issue resolved after investigation',
            ]);

        $response->assertRedirect();

        $complaint->refresh();
        $this->assertEquals('resolved', $complaint->status);
        $this->assertNotNull($complaint->resolved_at);
    }

    #[Test]
    public function complaint_ticket_number_format_is_valid(): void
    {
        $complaint = Complaint::factory()->create();

        $this->assertMatchesRegularExpression(
            '/^WBS-\d{8}-[A-Z0-9]{6}$/',
            $complaint->ticket_number
        );
    }

    #[Test]
    public function complaint_ticket_numbers_are_unique(): void
    {
        $numbers = [];
        for ($i = 0; $i < 50; $i++) {
            $numbers[] = Complaint::generateTicketNumber();
        }

        $this->assertCount(50, array_unique($numbers));
    }
}
