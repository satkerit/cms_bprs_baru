<?php

namespace App\Http\Requests\Admin\CompanyInfo;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyInfoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $imageMaxKb = get_upload_max_size('image');

        return [
            // Basic Information
            'name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'established_year' => 'nullable|integer|min:1900|max:' . date('Y'),

            // Contact Information
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'fax' => 'nullable|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'email_contact' => 'nullable|email|max:255',
            'email_complaint' => 'nullable|email|max:255',
            'email_whistleblowing' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',

            // Visual Assets
            'logo' => "nullable|image|mimes:jpeg,png,jpg,webp,svg|max:{$imageMaxKb}",
            'logo_footer' => "nullable|image|mimes:jpeg,png,jpg,webp,svg|max:{$imageMaxKb}",
            'logo_footer_remove_bg' => 'nullable|boolean',
            'logo_footer_opacity' => 'nullable|integer|min:0|max:100',
            'favicon' => 'nullable|file|mimes:ico,png,jpg,jpeg|max:512',
            'profile_image' => "nullable|image|mimes:jpeg,png,jpg,webp|max:{$imageMaxKb}",
            'organization_structure' => "nullable|image|mimes:jpeg,png,jpg,webp|max:{$imageMaxKb}",

            // Company Profile
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'history' => 'nullable|string',

            // Statistics
            'stat_years_experience' => 'nullable|integer|min:0',
            'stat_branch_offices' => 'nullable|integer|min:0',
            'stat_total_assets' => 'nullable|string|max:100',
            'stat_cash_offices' => 'nullable|integer|min:0',
            'stat_mobile_cash_offices' => 'nullable|integer|min:0',
            'legacy_visitor_count' => 'nullable|integer|min:0',

            // Social Media
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'tiktok' => 'nullable|url|max:255',

            // Regulatory Information
            'ojk_license' => 'nullable|string|max:255',
            'ojk_tagline' => 'nullable|string',
            'lps_tagline' => 'nullable|string',
            'lps_guarantee_amount' => 'nullable|string|max:100',

            // SEO & Footer
            'footer_description' => 'nullable|string|max:500',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:500',

            // Operational Hours
            'operational_hours' => 'nullable|array',
            'operational_hours.*.active' => 'nullable|boolean',
            'operational_hours.*.open' => 'nullable|string',
            'operational_hours.*.close' => 'nullable|string',
            'operational_hours.*.has_break' => 'nullable|boolean',
            'operational_hours.*.break_start' => 'nullable|string',
            'operational_hours.*.break_end' => 'nullable|string',
            'operational_hours.notes' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama perusahaan wajib diisi.',
            'name.max' => 'Nama perusahaan maksimal 255 karakter.',
            'established_year.min' => 'Tahun berdiri minimal 1900.',
            'established_year.max' => 'Tahun berdiri tidak boleh melebihi tahun sekarang.',
            'email.email' => 'Format email utama tidak valid.',
            'email_contact.email' => 'Format email kontak tidak valid.',
            'email_complaint.email' => 'Format email pengaduan tidak valid.',
            'email_whistleblowing.email' => 'Format email whistleblowing tidak valid.',
            'website.url' => 'Format alamat website tidak valid.',
        ];
    }
}
