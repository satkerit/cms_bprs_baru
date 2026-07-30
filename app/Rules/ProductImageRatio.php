<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

class ProductImageRatio implements ValidationRule
{
    /**
     * @param float $targetRatio Target aspect ratio (width/height), default 4/3 = 1.333
     * @param float $tolerance   Acceptable deviation, default 0.05
     */
    public function __construct(
        private float $targetRatio = 4 / 3,
        private float $tolerance = 0.05,
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$value instanceof UploadedFile || !$value->isValid()) {
            return;
        }

        $dimensions = @getimagesize($value->getPathname());
        if (!$dimensions) {
            $fail('Tidak dapat membaca dimensi gambar.');
            return;
        }

        [$width, $height] = $dimensions;
        $ratio = $width / $height;
        $min = $this->targetRatio - $this->tolerance;
        $max = $this->targetRatio + $this->tolerance;

        if ($ratio < $min || $ratio > $max) {
            $fail("Rasio gambar harus {$this->formatRatio($this->targetRatio)} (mendekati). Rasio terupload: {$this->formatRatio($ratio)}.");
        }
    }

    private function formatRatio(float $ratio): string
    {
        // Try common ratios
        $common = [
            4 / 3 => '4:3',
            16 / 9 => '16:9',
            1 => '1:1',
            3 / 2 => '3:2',
            21 / 9 => '21:9',
        ];

        foreach ($common as $value => $label) {
            if (abs($ratio - $value) < 0.01) {
                return $label;
            }
        }

        return number_format($ratio, 2);
    }
}
