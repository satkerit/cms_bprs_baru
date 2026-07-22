<?php

namespace Tests\Unit\Models;

use App\Models\PasswordHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PasswordHistoryTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    #[Test]
    public function save_password_creates_history_entry(): void
    {
        PasswordHistory::create([
            'user_id' => $this->user->id,
            'password' => bcrypt('Kuat!2024Babel'),
        ]);

        $this->assertDatabaseHas('password_histories', [
            'user_id' => $this->user->id,
        ]);
    }

    #[Test]
    public function is_password_reused_returns_true_for_matching_password(): void
    {
        PasswordHistory::create([
            'user_id' => $this->user->id,
            'password' => bcrypt('Kuat!2024Babel'),
        ]);

        $this->assertTrue(
            PasswordHistory::isPasswordReused($this->user->id, 'Kuat!2024Babel')
        );
    }

    #[Test]
    public function is_password_reused_returns_false_for_new_password(): void
    {
        PasswordHistory::create([
            'user_id' => $this->user->id,
            'password' => bcrypt('Previous!Pass1'),
        ]);

        $this->assertFalse(
            PasswordHistory::isPasswordReused($this->user->id, 'NewKuat!2024')
        );
    }

    #[Test]
    public function history_is_limited_to_5_entries(): void
    {
        PasswordHistory::where('user_id', $this->user->id)->delete();
        for ($i = 1; $i <= 7; $i++) {
            PasswordHistory::create([
                'user_id' => $this->user->id,
                'password' => bcrypt("UniquePass{$i}!Ab1"),
            ]);
        }

        PasswordHistory::where('user_id', $this->user->id)
            ->orderBy('created_at', 'desc')
            ->skip(5)
            ->delete();

        $count = PasswordHistory::where('user_id', $this->user->id)->count();
        $this->assertLessThanOrEqual(5, $count);
    }

    #[Test]
    public function is_password_reused_checks_only_last_5(): void
    {
        PasswordHistory::where('user_id', $this->user->id)->delete();
        for ($i = 1; $i <= 5; $i++) {
            PasswordHistory::create([
                'user_id' => $this->user->id,
                'password' => bcrypt("OldPass{$i}!Xy1"),
            ]);
        }

        $this->assertFalse(
            PasswordHistory::isPasswordReused($this->user->id, 'NewPass!2024')
        );
    }
}
