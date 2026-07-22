<?php

namespace App\Http\Requests\Admin\KasKeliling;

use Illuminate\Foundation\Http\FormRequest;

class StoreKasKelilingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'schedule_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'required|string|max:255',
            'facility' => 'nullable|string|max:1000',
            'pic_name' => 'nullable|string|max:255',
            'pic_phone' => 'nullable|string|max:20|regex:/^[0-9+\-\s()]+$/',
            'notes' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'schedule_date.required' => 'Tanggal jadwal wajib diisi.',
            'schedule_date.after_or_equal' => 'Tanggal jadwal tidak boleh sebelum hari ini.',
            'start_time.required' => 'Jam mulai wajib diisi.',
            'start_time.date_format' => 'Format jam mulai tidak valid (HH:MM).',
            'end_time.required' => 'Jam selesai wajib diisi.',
            'end_time.date_format' => 'Format jam selesai tidak valid (HH:MM).',
            'end_time.after' => 'Jam selesai harus setelah jam mulai.',
            'location.required' => 'Lokasi wajib diisi.',
            'location.max' => 'Lokasi maksimal 255 karakter.',
            'pic_phone.regex' => 'Format nomor telepon PIC tidak valid.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
