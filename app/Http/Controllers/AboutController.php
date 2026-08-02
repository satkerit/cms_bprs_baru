<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Services\CacheService;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function company()
    {
        $companyInfo = app(CacheService::class)->getCompanyInfo();
        return view('frontend.pages.about.company', [
            'companyInfo' => $companyInfo,
            'metaDescription' => 'Profil perusahaan ' . ($companyInfo?->name ?? 'BPRS Bangka Belitung') . '. Visi, misi, sejarah, regulasi OJK & LPS, dan jam operasional bank syariah terpercaya di Kepulauan Bangka Belitung.',
        ]);
    }

    /**
     * Halaman Manajemen — menggabungkan Dewan Komisaris, Dewan Direksi,
     * dan Dewan Pengawas Syariah dalam satu tampilan struktur organisasi.
     */
    public function manajemen()
    {
        return view('frontend.pages.about.manajemen', [
            'komisaris' => app(CacheService::class)->getBoardMembers('komisaris'),
            'direksi' => app(CacheService::class)->getBoardMembers('direksi'),
            'pengawasSyariah' => app(CacheService::class)->getBoardMembers('pengawas_syariah'),
            'metaDescription' => 'Dewan Komisaris, Dewan Direksi, dan Dewan Pengawas Syariah BPRS Bangka Belitung. Kenali para pemimpin yang memastikan tata kelola bank berjalan transparan dan sesuai prinsip syariah.',
        ]);
    }

    public function struktur()
    {
        $companyInfo = app(CacheService::class)->getCompanyInfo();
        return view('frontend.pages.about.struktur', [
            'companyInfo' => $companyInfo,
            'metaDescription' => 'Struktur organisasi ' . ($companyInfo?->name ?? 'BPRS Bangka Belitung') . '. Gambaran tata kelola dan hierarki organisasi bank syariah yang transparan, akuntabel, dan sesuai prinsip syariah.',
        ]);
    }

    public function offices(Request $request)
    {
        try {
            $type = $request->query('type');

            \Log::info('AboutController::offices called', [
                'type' => $type,
                'request_type' => gettype($type)
            ]);

            $offices = app(CacheService::class)->getOffices($type);

            \Log::info('AboutController::offices - offices loaded', [
                'count' => $offices->count(),
                'type' => $type
            ]);

            return view('frontend.pages.about.offices', [
                'offices' => $offices,
                'metaDescription' => 'Daftar kantor cabang, kantor kas, dan kas keliling BPRS Bangka Belitung di seluruh Kepulauan Bangka Belitung. Temukan kantor terdekat untuk layanan perbankan syariah.',
            ]);
        } catch (\Exception $e) {
            \Log::error('AboutController::offices error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

    public function officeShow(Office $office)
    {
        abort_unless($office->is_active, 404);

        $otherOffices = Office::where('is_active', true)
            ->where('id', '!=', $office->id)
            ->orderBy('type')
            ->limit(5)
            ->get(['id', 'name', 'slug', 'type', 'photo']);

        return view('frontend.pages.about.office-show', compact('office', 'otherOffices'));
    }
}
