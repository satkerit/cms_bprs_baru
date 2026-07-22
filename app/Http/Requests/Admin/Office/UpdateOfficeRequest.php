<?php

namespace App\Http\Requests\Admin\Office;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOfficeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $imageMaxKb = get_upload_max_size('image');

        return [
            'name' => 'sometimes|string|max:255',
            'type' => 'sometimes|in:pusat,cabang,kas,kas_keliling',
            'address' => 'sometimes|string',
            'description' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'photo' => "nullable|image|mimes:jpeg,png,jpg,webp|max:{$imageMaxKb}|dimensions:min_width=400,min_height=300,max_width=7680,max_height=4320",
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'operational_hours' => 'nullable|array',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        $imageMaxMb = round(get_upload_max_size('image') / 1024);

        return [
            'name.max' => 'Nama kantor maksimal 255 karakter.',
            'type.in' => 'Tipe kantor tidak valid.',
            'email.email' => 'Format email tidak valid.',
            'photo.image' => 'Foto harus berupa gambar.',
            'photo.mimes' => 'Foto harus berformat JPEG, PNG, JPG, atau WebP.',
            'photo.max' => "Ukuran foto maksimal {$imageMaxMb}MB.",
            'photo.dimensions' => 'Foto kantor minimal 400×300px (4:3) dan maksimal 7680×4320px.',
            'latitude.between' => 'Latitude harus antara -90 dan 90.',
            'longitude.between' => 'Longitude harus antara -180 dan 180.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
