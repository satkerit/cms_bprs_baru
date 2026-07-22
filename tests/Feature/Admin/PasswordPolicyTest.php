<?php

namespace Tests\Feature\Admin;

use App\Models\PasswordHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PasswordPolicyTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'password' => bcrypt('Current!Pass123'),
        ]);
    }

    #[Test]
    public function password_history_blocks_password_reuse(): void
    {
        $oldPassword = 'OldPass!123';
        PasswordHistory::create([
            'user_id' => $this->user->id,
            'password' => bcrypt($oldPassword),
        ]);

        $this->assertTrue(
            PasswordHistory::isPasswordReused($this->user->id, $oldPassword)
        );
    }

    #[Test]
    public function password_history_allows_new_password(): void
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
    public function password_history_saves_entries(): void
    {
        PasswordHistory::create([
            'user_id' => $this->user->id,
            'password' => bcrypt('UniquePass1!Ab1'),
        ]);

        $this->assertDatabaseHas('password_histories', [
            'user_id' => $this->user->id,
        ]);
    }

    #[Test]
    public function password_history_checks_last_5_passwords(): void
    {
        $passwords = [];
        for ($i = 1; $i <= 5; $i++) {
            $pass = "History{$i}!Pass12";
            PasswordHistory::create([
                'user_id' => $this->user->id,
                'password' => bcrypt($pass),
            ]);
            $passwords[] = $pass;
        }

        foreach ($passwords as $pass) {
            $this->assertTrue(
                PasswordHistory::isPasswordReused($this->user->id, $pass),
                "Should detect reuse of: {$pass}"
            );
        }
    }

    #[Test]
    public function login_with_inactive_user_is_rejected(): void
    {
        $inactiveUser = User::factory()->create([
            'email' => 'inactive@example.com',
            'password' => bcrypt('Kuat!2024Babel'),
            'is_active' => false,
        ]);

        $response = $this->withHeaders(['Accept' => 'application/json'])
            ->post(route('admin.login'), [
                'email' => 'inactive@example.com',
                'password' => 'Kuat!2024Babel',
            ]);

        $this->assertGuest();
    }
}
