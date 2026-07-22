<?php

namespace App\Http\Requests\Admin\FinancingConfig;

use Illuminate\Foundation\Http\FormRequest;

class StoreFinancingConfigRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'calculation_type' => 'required|in:margin,profit_sharing',
            'description' => 'nullable|string|max:1000',
            'margin_rate' => 'required|numeric|min:0.01|max:100',
            'min_principal' => 'required|integer|min:1',
            'max_principal' => 'required|integer|gt:min_principal',
            'available_tenors' => 'required|array|min:1',
            'available_tenors.*' => 'required|integer|min:1|max:360',
            'dp_enabled' => 'boolean',
            'dp_min_percentage' => 'nullable|numeric|min:0|max:100',
            'dp_max_percentage' => 'nullable|numeric|min:0|max:100|gte:dp_min_percentage',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama konfigurasi wajib diisi.',
            'name.max' => 'Nama konfigurasi maksimal 255 karakter.',
            'calculation_type.required' => 'Tipe perhitungan wajib dipilih.',
            'calculation_type.in' => 'Tipe perhitungan tidak valid.',
            'margin_rate.required' => 'Rate margin/nisbah wajib diisi.',
            'margin_rate.numeric' => 'Rate margin/nisbah harus berupa angka.',
            'margin_rate.min' => 'Rate margin/nisbah minimal 0.01%.',
            'margin_rate.max' => 'Rate margin/nisbah maksimal 100%.',
            'min_principal.required' => 'Minimum pokok wajib diisi.',
            'min_principal.integer' => 'Minimum pokok harus berupa bilangan bulat.',
            'max_principal.required' => 'Maksimum pokok wajib diisi.',
            'max_principal.gt' => 'Maksimum pokok harus lebih besar dari minimum pokok.',
            'available_tenors.required' => 'Pilih setidaknya satu tenor.',
            'available_tenors.min' => 'Pilih setidaknya satu tenor.',
            'available_tenors.*.min' => 'Tenor minimal 1 bulan.',
            'available_tenors.*.max' => 'Tenor maksimal 360 bulan.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
            'dp_enabled' => $this->boolean('dp_enabled'),
        ]);
    }
}
