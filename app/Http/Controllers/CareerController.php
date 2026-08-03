<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\CompanyInfo;
use App\Models\EmailSetting;
use Illuminate\Http\Request;
use Spatie\ResponseCache\Attributes\NoCache;

class CareerController extends Controller
{
    public function index(Request $request)
    {
        $query = Career::available()->orderBy('order_position')->latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('department', 'like', '%' . $request->search . '%')
                    ->orWhere('location', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('type')) {
            $query->where('employment_type', $request->type);
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        $careers = $query->paginate(12)->withQueryString();

        // Get unique departments for filter
        $departments = Career::available()
            ->whereNotNull('department')
            ->distinct()
            ->pluck('department');

        return view('frontend.pages.careers.index', compact('careers', 'departments'));
    }

    #[NoCache]
    public function show(Career $career)
    {
        if (!$career->is_active) {
            abort(404);
        }

        $relatedCareers = Career::available()
            ->where('id', '!=', $career->id)
            ->where(function ($q) use ($career) {
                $q->where('department', $career->department)
                    ->orWhere('employment_type', $career->employment_type);
            })
            ->limit(3)
            ->get();

        // Alamat pengiriman lamaran: prioritas EmailSetting (admin), fallback ke .env / profil perusahaan
        $emailSetting = EmailSetting::getSettings();
        $company = CompanyInfo::getInfo();

        $applyEmail = $emailSetting?->career_recipient_email
            ?: config('services.hr.email', 'personalia.bsbb@gmail.com');
        $applyAddress = $emailSetting?->career_recipient_address
            ?: $company?->address;

        return view('frontend.pages.careers.show', compact('career', 'relatedCareers', 'applyEmail', 'applyAddress'));
    }
}
