<?php

namespace App\Http\Controllers;

use App\Mail\JobApplicationMail;
use App\Models\Career;
use App\Models\EmailSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
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

        return view('frontend.pages.careers.show', compact('career', 'relatedCareers'));
    }

    public function apply(Request $request, Career $career)
    {
        if (!$career->is_active || $career->isExpired()) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'cover_letter' => ['nullable', 'string', 'max:5000'],
            'cv' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        $file = $request->file('cv');
        $validated['cv_name'] = $file->getClientOriginalName();

        // Simpan CV ke disk privat (tidak terserve publik)
        $cvPath = $file->store('job-applications', 'local');
        if (!$cvPath) {
            return back()->with('error', 'Gagal menyimpan berkas lamaran. Silakan coba lagi.');
        }

        try {
            // Penerima: prioritas EmailSetting (admin), fallback ke .env (JOB_APPLICATION_EMAIL), lalu default
            $recipient = optional(EmailSetting::getSettings())->career_recipient_email
                ?: config('services.hr.email', 'personalia.bsbb@gmail.com');

            Mail::to($recipient)
                ->send(new JobApplicationMail($career, $validated, $cvPath));
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim lamaran pekerjaan: ' . $e->getMessage(), [
                'career_id' => $career->id,
                'name' => $validated['name'],
            ]);
            Storage::disk('local')->delete($cvPath);

            return back()->with('error', 'Gagal mengirim lamaran. Silakan coba lagi atau kirim melalui email langsung.');
        }

        return back()->with('success', 'Lamaran Anda berhasil dikirim. Tim Personalia akan segera meninjau lamaran Anda.');
    }
}
