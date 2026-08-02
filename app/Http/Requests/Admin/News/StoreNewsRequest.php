<?php

namespace App\Http\Requests\Admin\News;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreNewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization is handled by middleware/policy
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function prepareForValidation(): void
    {
        $this->merge([
            'is_published' => $this->has('is_published') ? 1 : 0,
        ]);
    }

    public function rules(): array
    {
        $imageMaxKb = get_upload_max_size('image');

        return [
            'title'            => 'required|string|max:255',
            'slug'             => [
                'nullable', 'string', 'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('news'),
            ],
            'content'          => 'required|string',
            'excerpt'          => 'nullable|string|max:500',
            'category'         => 'required|in:Berita,Artikel,Pengumuman,Promo,Event',
            'author'           => 'nullable|string|max:100',
            'meta_description' => 'nullable|string|max:160',
            'tags'             => 'nullable|string|max:255',
            'published_at'     => 'nullable|date',
            'is_published'     => 'required|boolean',
            'featured_image'   => "nullable|image|mimes:jpeg,png,jpg,webp|max:{$imageMaxKb}",
            'slide_images.*'   => "nullable|image|mimes:jpeg,png,jpg,webp|max:{$imageMaxKb}",
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        $imageMaxKb = get_upload_max_size('image');
        $imageMaxMb = round($imageMaxKb / 1024);

        return [
            'title.required' => 'Judul berita wajib diisi.',
            'title.max' => 'Judul berita maksimal 255 karakter.',
            'slug.unique' => 'Slug URL sudah digunakan.',
            'slug.regex' => 'Slug URL hanya boleh mengandung huruf kecil, angka, dan tanda hubung.',
            'content.required' => 'Konten berita wajib diisi.',
            'category.required' => 'Kategori berita wajib dipilih.',
            'category.in' => 'Kategori yang dipilih tidak valid.',
            'excerpt.max' => 'Ringkasan maksimal 500 karakter.',
            'author.max' => 'Nama penulis maksimal 100 karakter.',
            'meta_description.max' => 'Meta description maksimal 160 karakter.',
            'tags.max' => 'Tags maksimal 255 karakter.',
            'featured_image.image' => 'File gambar utama harus berupa gambar.',
            'featured_image.mimes' => 'Gambar utama harus berformat JPEG, PNG, JPG, atau WebP.',
            'featured_image.max' => "Ukuran gambar utama maksimal {$imageMaxMb}MB.",
            'featured_image.dimensions' => 'Gambar utama minimal 800×450px (16:9) dan maksimal 7680×4320px.',
            'slide_images.*.image' => 'File galeri harus berupa gambar.',
            'slide_images.*.mimes' => 'Gambar galeri harus berformat JPEG, PNG, JPG, atau WebP.',
            'slide_images.*.max' => "Ukuran gambar galeri maksimal {$imageMaxMb}MB.",
            'slide_images.*.dimensions' => 'Gambar galeri minimal 400×225px dan maksimal 7680×4320px.'
        ];
    }
}
