<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $imageMaxKb = get_upload_max_size('product_image');
        $documentMaxKb = get_upload_max_size('document');

        return [
            'name' => 'sometimes|string|max:255',
            'type' => 'sometimes|in:simpanan_syariah,pembiayaan_syariah,deposito_syariah',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'interest_rate' => 'nullable|string|max:100',
            'features' => 'nullable|array',
            'requirements' => 'nullable|array',
            'benefits' => 'nullable|array',
            'image' => "nullable|image|mimes:jpeg,png,jpg,webp|max:{$imageMaxKb}|dimensions:min_width=600,min_height=338,max_width=7680,max_height=4320",
            'image_alt' => 'nullable|string|max:255',
            'brochure' => "nullable|file|mimes:pdf|max:{$documentMaxKb}",
            'brochure_id' => 'nullable|exists:brochures,id',
            'is_active' => 'boolean',
            'order_position' => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        $imageMaxMb = round(get_upload_max_size('product_image') / 1024);
        $documentMaxMb = round(get_upload_max_size('document') / 1024);

        return [
            'image.max' => "Ukuran gambar produk maksimal {$imageMaxMb}MB.",
            'image.dimensions' => 'Gambar produk minimal 600×338px (16:9) dan maksimal 7680×4320px.',
            'brochure.max' => "Ukuran brosur maksimal {$documentMaxMb}MB.",
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
