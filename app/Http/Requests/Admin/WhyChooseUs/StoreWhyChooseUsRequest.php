<?php

namespace App\Http\Requests\Admin\WhyChooseUs;

use Illuminate\Foundation\Http\FormRequest;

class StoreWhyChooseUsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $imageMaxKb = get_upload_max_size('image');

        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => "nullable|image|max:{$imageMaxKb}|mimes:png,jpg,jpeg,svg,webp",
            'color_theme' => 'required|string|in:primary,emerald,blue,amber,rose,purple,teal,cyan,indigo',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        $imageMaxMb = round(get_upload_max_size('image') / 1024);

        return [
            'title.required' => 'Judul wajib diisi.',
            'title.max' => 'Judul maksimal 255 karakter.',
            'description.required' => 'Deskripsi wajib diisi.',
            'color_theme.required' => 'Tema warna wajib dipilih.',
            'color_theme.in' => 'Tema warna tidak valid.',
            'icon.image' => 'Ikon harus berupa gambar.',
            'icon.max' => "Ukuran ikon maksimal {$imageMaxMb}MB.",
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
