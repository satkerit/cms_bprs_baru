<?php

namespace App\Http\Requests\Admin\Brochure;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrochureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:pdf|mimetypes:application/pdf|max:' . get_upload_max_size('document'),
        ];
    }

    public function messages(): array
    {
        $maxMb = round(get_upload_max_size('document') / 1024);

        return [
            'file.required' => 'File brosur wajib diunggah.',
            'file.file' => 'File brosur harus berupa file.',
            'file.mimes' => 'File brosur harus berformat PDF.',
            'file.mimetypes' => 'File brosur harus berformat PDF (validasi MIME).',
            'file.max' => "Ukuran file brosur maksimal {$maxMb}MB.",
        ];
    }
}
