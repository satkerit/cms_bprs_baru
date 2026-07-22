<?php

namespace Tests\Unit\Rules;

use App\Rules\StrongPassword;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class StrongPasswordTest extends TestCase
{
    private StrongPassword $rule;

    protected function setUp(): void
    {
        parent::setUp();
        $this->rule = new StrongPassword();
    }

    #[Test]
    #[DataProvider('validPasswordsProvider')]
    public function valid_passwords_pass_validation(string $password): void
    {
        $failed = false;
        $this->rule->validate('password', $password, function () use (&$failed) {
            $failed = true;
        });

        $this->assertFalse($failed, "Password '{$password}' should be valid");
    }

    #[Test]
    #[DataProvider('invalidPasswordsProvider')]
    public function invalid_passwords_fail_validation(string $password, string $reason): void
    {
        $failed = false;
        $failMessage = '';
        $this->rule->validate('password', $password, function (string $message) use (&$failed, &$failMessage) {
            $failed = true;
            $failMessage = $message;
        });

        $this->assertTrue($failed, "Password '{$password}' should fail: {$reason}");
        $this->assertNotEmpty($failMessage);
    }

    public static function validPasswordsProvider(): array
    {
        return [
            'standard complex' => ['Kuat!2024Babel'],
            'with all char types' => ['P4ssw0rd!Strong'],
            'maximum length' => ['A1!b2@c3#d4%De5&f6*G7'],
            'with underscores' => ['Strong_P@ssw0rd_2024'],
            'mix of cases' => ['BabelBank#Syariah2024'],
            'special chars everywhere' => ['M0n!keyBang12'],
        ];
    }

    public static function invalidPasswordsProvider(): array
    {
        return [
            'too short' => ['Abc1!def', 'min 12 chars'],
            'no uppercase' => ['abcdef123!@#', 'missing uppercase'],
            'no lowercase' => ['ABCDEF123!@#', 'missing lowercase'],
            'no number' => ['Abcdefgh!@#', 'missing number'],
            'no special char' => ['Abcdef12345678', 'missing special char'],
            'common password' => ['password123!@', 'common password blocked'],
            'common password 2' => ['12345678!Abcd', 'common password blocked'],
            'sequential ascending' => ['Abcd1234!wxyz', 'sequential chars detected'],
            'sequential descending' => ['Xyza4321!Mnop', 'sequential reversed chars'],
            'sequential keyboard' => ['Qwerty123!Abc', 'keyboard sequence detected'],
            'repeated chars' => ['Abbbb!2024Xyz', 'repeated chars (>3 in row)'],
            'null value' => ['', 'empty password'],
        ];
    }

    #[Test]
    public function custom_min_length_is_respected(): void
    {
        $rule = (new StrongPassword())->minLength(16);

        $failed = false;
        $rule->validate('password', 'Short1!Abcdef', function () use (&$failed) {
            $failed = true;
        });

        $this->assertTrue($failed, 'Should fail with custom min length of 16');
    }

    #[Test]
    public function without_uppercase_disables_uppercase_check(): void
    {
        $rule = (new StrongPassword())->withoutUppercase();

        $failed = false;
        $rule->validate('password', 'lowercase123!@#', function () use (&$failed) {
            $failed = true;
        });

        $this->assertFalse($failed, 'Should pass without uppercase requirement');
    }

    #[Test]
    public function without_lowercase_disables_lowercase_check(): void
    {
        $rule = (new StrongPassword())->withoutLowercase();

        $failed = false;
        $rule->validate('password', 'UPPERCASE123!@#', function () use (&$failed) {
            $failed = true;
        });

        $this->assertFalse($failed, 'Should pass without lowercase requirement');
    }

    #[Test]
    public function without_numbers_disables_number_check(): void
    {
        $rule = (new StrongPassword())->withoutNumbers();

        $failed = false;
        $rule->validate('password', 'MyP!@#aWordXy', function () use (&$failed) {
            $failed = true;
        });

        $this->assertFalse($failed, 'Should pass without number requirement');
    }

    #[Test]
    public function without_special_chars_disables_special_char_check(): void
    {
        $rule = (new StrongPassword())->withoutSpecialChars();

        $failed = false;
        $rule->validate('password', 'MyPassW16253478', function () use (&$failed) {
            $failed = true;
        });

        $this->assertFalse($failed, 'Should pass without special char requirement');
    }
}
