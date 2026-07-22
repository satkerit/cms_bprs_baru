<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|in:simpanan_syariah,pembiayaan_syariah,deposito_syariah',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'interest_rate' => 'nullable|string|max:100',
            'features' => 'nullable|array',
            'requirements' => 'nullable|array',
            'benefits' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120|dimensions:min_width=600,min_height=338,max_width=7680,max_height=4320',
            'image_alt' => 'nullable|string|max:255',
            'brochure' => 'nullable|file|mimes:pdf|max:10240',
            'brochure_id' => 'nullable|exists:brochures,id',
            'is_active' => 'boolean',
            'order_position' => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'image.dimensions' => 'Gambar produk minimal 600×338px (16:9) dan maksimal 7680×4320px.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
