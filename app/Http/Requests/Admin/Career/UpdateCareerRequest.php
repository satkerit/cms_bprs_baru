<?php

namespace App\Http\Requests\Admin\Career;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCareerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'department' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:100',
            'employment_type' => 'sometimes|in:full_time,part_time,contract,internship',
            'description' => 'sometimes|string',
            'requirements' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'benefits' => 'nullable|string',
            'salary_range' => 'nullable|string|max:100',
            'deadline' => 'nullable|date',
            'is_active' => 'boolean',
            'order_position' => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul karir wajib diisi.',
            'title.max' => 'Judul karir maksimal 255 karakter.',
            'employment_type.in' => 'Tipe pekerjaan tidak valid.',
            'deadline.date' => 'Format tanggal deadline tidak valid.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
