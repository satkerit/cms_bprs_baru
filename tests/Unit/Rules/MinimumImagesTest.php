<?php

namespace Tests\Unit\Rules;

use App\Rules\MinimumImages;
use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MinimumImagesTest extends TestCase
{
    #[Test]
    public function passes_when_array_has_enough_items(): void
    {
        $rule = new MinimumImages(3);

        $failed = false;
        $rule->validate('images', [
            UploadedFile::fake()->image('img1.jpg'),
            UploadedFile::fake()->image('img2.jpg'),
            UploadedFile::fake()->image('img3.jpg'),
        ], function () use (&$failed) {
            $failed = true;
        });

        $this->assertFalse($failed);
    }

    #[Test]
    public function fails_when_array_has_too_few_items(): void
    {
        $rule = new MinimumImages(3);

        $failed = false;
        $rule->validate('images', [
            UploadedFile::fake()->image('img1.jpg'),
            UploadedFile::fake()->image('img2.jpg'),
        ], function () use (&$failed) {
            $failed = true;
        });

        $this->assertTrue($failed);
    }

    #[Test]
    public function fails_when_value_is_not_an_array(): void
    {
        $rule = new MinimumImages(1);

        $failed = false;
        $rule->validate('images', 'not_an_array', function () use (&$failed) {
            $failed = true;
        });

        $this->assertTrue($failed);
    }

    #[Test]
    public function fails_on_empty_array(): void
    {
        $rule = new MinimumImages(1);

        $failed = false;
        $rule->validate('images', [], function () use (&$failed) {
            $failed = true;
        });

        $this->assertTrue($failed);
    }

    #[Test]
    public function uses_default_minimum_of_3(): void
    {
        $rule = new MinimumImages();

        $reflection = new \ReflectionProperty(MinimumImages::class, 'minimum');
        $reflection->setAccessible(true);

        $this->assertEquals(3, $reflection->getValue($rule));
    }

    #[Test]
    public function passes_with_exact_minimum(): void
    {
        $rule = new MinimumImages(2);

        $failed = false;
        $rule->validate('images', [
            UploadedFile::fake()->image('a.jpg'),
            UploadedFile::fake()->image('b.jpg'),
        ], function () use (&$failed) {
            $failed = true;
        });

        $this->assertFalse($failed);
    }
}
