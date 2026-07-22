<?php

namespace App\Http\Requests\Admin\BoardMember;

use Illuminate\Foundation\Http\FormRequest;

class StoreBoardMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $imageMaxKb = get_upload_max_size('image');

        return [
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'type' => 'required|in:komisaris,direksi,pengawas_syariah',
            'photo' => "nullable|image|mimes:jpeg,png,jpg,webp|max:{$imageMaxKb}|dimensions:min_width=400,min_height=500,max_width=3000,max_height=4000",
            'biography' => 'nullable|string|max:5000',
            'education' => 'nullable|array',
            'education.*' => 'nullable|string|max:500',
            'experience' => 'nullable|array',
            'experience.*' => 'nullable|string|max:500',
            'order_position' => 'nullable|integer|min:0|max:999',
        ];
    }

    public function messages(): array
    {
        $imageMaxMb = round(get_upload_max_size('image') / 1024);

        return [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max' => 'Nama lengkap maksimal 255 karakter.',
            'position.required' => 'Jabatan wajib diisi.',
            'position.max' => 'Jabatan maksimal 255 karakter.',
            'type.required' => 'Tipe anggota wajib dipilih.',
            'type.in' => 'Tipe anggota yang dipilih tidak valid.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.mimes' => 'Gambar harus berformat JPEG, PNG, JPG, atau WebP.',
            'photo.max' => "Ukuran gambar maksimal {$imageMaxMb}MB.",
            'photo.dimensions' => 'Gambar minimal 400×500px dan maksimal 3000×4000px.',
            'biography.max' => 'Biografi maksimal 5000 karakter.',
            'education.*.max' => 'Pendidikan maksimal 500 karakter.',
            'experience.*.max' => 'Pengalaman maksimal 500 karakter.',
            'order_position.integer' => 'Urutan harus berupa angka.',
            'order_position.min' => 'Urutan minimal 0.',
            'order_position.max' => 'Urutan maksimal 999.',
        ];
    }
}
