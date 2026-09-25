<?php

namespace App\Http\Requests\Admin\CustomerComplaint;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerComplaintStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'required|in:pending,in_progress,resolved,closed',
            'priority' => 'required|in:low,medium,high',
            'resolution' => 'nullable|string',
            'admin_notes' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Status pengaduan wajib dipilih.',
            'status.in' => 'Status pengaduan tidak valid.',
            'priority.required' => 'Prioritas pengaduan wajib dipilih.',
            'priority.in' => 'Prioritas pengaduan tidak valid.',
        ];
    }
}
