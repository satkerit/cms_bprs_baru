<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReportCategory;
use App\Traits\AuthorizesAdminActions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ReportCategoryController extends Controller
{
    use AuthorizesAdminActions;

    public function index()
    {
        $this->authorizeAny(['settings.site']);
        $categories = ReportCategory::ordered()->get();
        return view('admin.report-categories.index', compact('categories'));
    }

    public function edit(ReportCategory $reportCategory)
    {
        $this->authorizeAny(['settings.site']);
        return view('admin.report-categories.edit', compact('reportCategory'));
    }

    public function update(Request $request, ReportCategory $reportCategory)
    {
        $this->authorizeAny(['settings.site']);

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ], [
            'title.max' => 'Judul maksimal 255 karakter',
            'subtitle.max' => 'Subjudul maksimal 255 karakter',
        ]);

        $reportCategory->update($validated);
        Cache::forget('report_categories_all');

        return redirect()->route('admin.report-categories.index')
            ->with('success', 'Deskripsi laporan berhasil diperbarui.');
    }
}
