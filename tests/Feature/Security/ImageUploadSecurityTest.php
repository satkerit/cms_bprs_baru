<?php

namespace Tests\Feature\Security;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ImageUploadSecurityTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = $this->createSuperAdmin();
    }

    #[Test]
    public function rejects_exe_file_upload_for_featured_image(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('malware.exe', 100);

        $response = $this->actingAs($this->admin)
            ->withoutSecurityMiddleware()
            ->from(route('admin.news.create'))
            ->post(route('admin.news.store'), [
                'title' => 'Test EXE Reject',
                'content' => 'Testing EXE file rejection',
                'category' => 'Berita',
                'featured_image' => $file,
                'is_published' => false,
            ]);

        $response->assertStatus(302);
        $this->assertDatabaseMissing('news', ['title' => 'Test EXE Reject']);
    }

    #[Test]
    public function accepts_valid_image_upload_for_featured_image(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('photo.jpg', 800, 600)->size(500);

        $response = $this->actingAs($this->admin)
            ->withoutSecurityMiddleware()
            ->from(route('admin.news.create'))
            ->post(route('admin.news.store'), [
                'title' => 'Test Valid Image',
                'content' => 'Content with valid image',
                'category' => 'Berita',
                'featured_image' => $file,
                'is_published' => false,
            ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('news', ['title' => 'Test Valid Image']);
    }

    #[Test]
    public function rejects_oversized_file(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('large.jpg', 1920, 1080)->size(12000);

        $response = $this->actingAs($this->admin)
            ->withoutSecurityMiddleware()
            ->from(route('admin.news.create'))
            ->post(route('admin.news.store'), [
                'title' => 'Test Large File',
                'content' => 'Content',
                'category' => 'Berita',
                'featured_image' => $file,
                'is_published' => false,
            ]);

        $response->assertStatus(302);
        $this->assertDatabaseMissing('news', ['title' => 'Test Large File']);
    }
}
