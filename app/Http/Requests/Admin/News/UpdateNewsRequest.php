<?php

namespace App\Http\Requests\Admin\News;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'is_published' => $this->has('is_published') ? 1 : 0,
        ]);
    }

    public function rules(): array
    {
        $imageMaxKb = get_upload_max_size('image');
        $newsId     = $this->route('news') ? $this->route('news')->id : null;

        return [
            'title'            => 'required|string|max:255',
            'slug'             => [
                'nullable', 'string', 'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('news')->ignore($newsId),
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

    public function messages(): array
    {
        return [
            'title.required'    => 'Judul berita wajib diisi.',
            'content.required'  => 'Konten berita wajib diisi.',
            'category.required' => 'Kategori berita wajib dipilih.',
            'category.in'       => 'Kategori yang dipilih tidak valid.',
            'slug.unique'       => 'Slug URL sudah digunakan.',
            'slug.regex'        => 'Slug URL hanya boleh mengandung huruf kecil, angka, dan tanda hubung.',
        ];
    }
}
