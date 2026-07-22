<?php

namespace App\Http\Requests\Admin\WhyChooseUs;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWhyChooseUsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'icon' => 'nullable|image|max:2048|mimes:png,jpg,jpeg,svg,webp',
            'color_theme' => 'sometimes|string|in:primary,emerald,blue,amber,rose,purple,teal,cyan,indigo',
            'sort_order' => 'sometimes|integer|min:0',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'title.max' => 'Judul maksimal 255 karakter.',
            'color_theme.in' => 'Tema warna tidak valid.',
            'icon.image' => 'Ikon harus berupa gambar.',
            'icon.max' => 'Ukuran ikon maksimal 2MB.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
