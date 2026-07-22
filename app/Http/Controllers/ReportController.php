<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportCategory;
use App\Services\CacheService;
use App\Services\Seo\SeoMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Display reports index page with category listing.
     */
    public function index()
    {
        SeoMeta::setTitle('Laporan & Publikasi')
            ->setDescription('Transparansi dan akuntabilitas BPRS Bangka Belitung. Akses laporan keuangan, tahunan, dan tata kelola perusahaan secara mudah.');

        $categories = ReportCategory::getAllActive();

        $icons = [
            'keuangan_publikasi' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>',
            'tahunan' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>',
            'tahunan_berkelanjutan' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>',
            'tata_kelola' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
        ];

        $colors = [
            'keuangan_publikasi' => 'emerald',
            'tahunan' => 'emerald',
            'tahunan_berkelanjutan' => 'emerald',
            'tata_kelola' => 'emerald',
        ];

        return view('frontend.pages.reports.index', compact('categories', 'icons', 'colors'));
    }

    private function getReports(Request $request, string $type, string $defaultTitle, string $defaultSubtitle)
    {
        $category = ReportCategory::getBySlug($type);

        $title = optional($category)->title ?? $defaultTitle;
        $subtitle = optional($category)->subtitle ?? $defaultSubtitle;
        $description = optional($category)->description ?? '';

        $year = $request->query('year');
        $page = $request->query('page', 1);
        $cacheKey = "reports_{$type}_{$year}_{$page}";

        $reports = \Illuminate\Support\Facades\Cache::remember($cacheKey, 3600, function () use ($type, $year) {
            $query = Report::where('type', $type)->published();
            if ($year) {
                $query->where('year', $year);
            }
            return $query->orderBy('year', 'desc')->orderBy('quarter', 'desc')->paginate(15);
        });

        $viewMap = [
            'keuangan_publikasi' => 'frontend.pages.reports.keuangan-publikasi',
            'tata_kelola' => 'frontend.pages.reports.tata-kelola',
            'tahunan' => 'frontend.pages.reports.tahunan',
            'tahunan_berkelanjutan' => 'frontend.pages.reports.tahunan-berkelanjutan',
        ];

        $colorKey = [
            'keuangan_publikasi' => 'emerald',
            'tahunan' => 'emerald',
            'tahunan_berkelanjutan' => 'emerald',
            'tata_kelola' => 'emerald',
        ];

        $color = $colorKey[$type] ?? 'emerald';

        $colorClasses = [
            'emerald' => ['bg' => 'from-emerald-50 to-emerald-100', 'text' => 'text-emerald-600', 'text_hover' => 'hover:text-emerald-700', 'btn' => 'bg-emerald-600 hover:bg-emerald-700', 'btn_outline' => 'border-emerald-200 text-emerald-700 hover:bg-emerald-50', 'ring' => 'ring-emerald-500/20'],
            'amber' => ['bg' => 'from-amber-50 to-amber-100', 'text' => 'text-amber-600', 'text_hover' => 'hover:text-amber-700', 'btn' => 'bg-amber-600 hover:bg-amber-700', 'btn_outline' => 'border-amber-200 text-amber-700 hover:bg-amber-50', 'ring' => 'ring-amber-500/20'],
            'blue' => ['bg' => 'from-blue-50 to-blue-100', 'text' => 'text-blue-600', 'text_hover' => 'hover:text-blue-700', 'btn' => 'bg-blue-600 hover:bg-blue-700', 'btn_outline' => 'border-blue-200 text-blue-700 hover:bg-blue-50', 'ring' => 'ring-blue-500/20'],
            'violet' => ['bg' => 'from-violet-50 to-violet-100', 'text' => 'text-violet-600', 'text_hover' => 'hover:text-violet-700', 'btn' => 'bg-violet-600 hover:bg-violet-700', 'btn_outline' => 'border-violet-200 text-violet-700 hover:bg-violet-50', 'ring' => 'ring-violet-500/20'],
        ];

        $c = $colorClasses[$color] ?? $colorClasses['emerald'];

        return view($viewMap[$type] ?? 'frontend.pages.reports.index', [
            'reports' => $reports->withQueryString(),
            'years' => app(CacheService::class)->getReportYears($type),
            'title' => $title,
            'subtitle' => $subtitle,
            'description' => $description,
            'type' => $type,
            'color' => $color,
            'c' => $c,
        ]);
    }

    public function keuanganPublikasi(Request $request)
    {
        return $this->getReports($request, 'keuangan_publikasi', 'Laporan Keuangan Publikasi', 'Laporan keuangan publikasi BPR Syariah');
    }

    public function tataKelola(Request $request)
    {
        return $this->getReports($request, 'tata_kelola', 'Laporan Tata Kelola', 'Laporan tata kelola perusahaan');
    }

    public function tahunan(Request $request)
    {
        return $this->getReports($request, 'tahunan', 'Laporan Tahunan', 'Laporan tahunan BPR Syariah');
    }

    public function tahunanBerkelanjutan(Request $request)
    {
        return $this->getReports($request, 'tahunan_berkelanjutan', 'Laporan Tahunan Berkelanjutan', 'Laporan tahunan berkelanjutan BPR Syariah');
    }

    public function preview(int $id)
    {
        $report = Report::published()->findOrFail($id);

        if (!$report->file_path || !Storage::disk('public')->exists($report->file_path)) {
            abort(404, 'File tidak ditemukan');
        }

        // Increment preview count and clear cache
        $report->increment('preview_count');
        app(CacheService::class)->clearReportCache();

        return response()->file(
            Storage::disk('public')->path($report->file_path),
            [
                'Content-Type' => 'application/pdf',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ]
        );
    }

    public function download(int $id)
    {
        $report = Report::published()->findOrFail($id);

        if (!$report->file_path || !Storage::disk('public')->exists($report->file_path)) {
            abort(404, 'File tidak ditemukan');
        }

        // Increment download count and clear cache
        $report->increment('download_count');
        app(CacheService::class)->clearReportCache();

        return Storage::disk('public')->download($report->file_path, $report->title . '.pdf');
    }

    /**
     * Get hit counts for a report (AJAX endpoint)
     */
    public function getHitCounts(int $id)
    {
        $report = Report::published()->findOrFail($id);

        return response()->json([
            'preview_count' => $report->preview_count,
            'download_count' => $report->download_count,
        ]);
    }
}
