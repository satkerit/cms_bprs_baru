<?php

namespace App\Http\Requests\Admin\HeroSlide;

use Illuminate\Foundation\Http\FormRequest;

class StoreHeroSlideRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $heroMaxKb = get_upload_max_size('hero_image');

        return [
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'image' => "required|image|mimes:jpeg,png,jpg,webp|max:{$heroMaxKb}|dimensions:min_width=1920,min_height=800,max_width=7680,max_height=4320",
            'link_url' => 'nullable|string|max:255',
            'link_text' => 'nullable|string|max:100',
            'is_active' => 'boolean',
            'order_position' => 'nullable|integer|min:0',
            'transition_type' => 'nullable|string|max:50',
            'transition_duration' => 'nullable|integer|min:100|max:10000',
            'show_title' => 'boolean',
            'show_subtitle' => 'boolean',
            'show_button' => 'boolean',
        ];
    }

    public function messages(): array
    {
        $heroMaxMb = round(get_upload_max_size('hero_image') / 1024);

        return [
            'image.max' => "Ukuran gambar slider maksimal {$heroMaxMb}MB.",
            'image.dimensions' => 'Gambar slider minimal 1920x800px (2.4:1) dan maksimal 7680x4320px.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
            'show_title' => $this->boolean('show_title'),
            'show_subtitle' => $this->boolean('show_subtitle'),
            'show_button' => $this->boolean('show_button'),
        ]);
    }
}
