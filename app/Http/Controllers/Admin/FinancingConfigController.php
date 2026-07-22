<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FinancingConfig\StoreFinancingConfigRequest;
use App\Http\Requests\Admin\FinancingConfig\UpdateFinancingConfigRequest;
use App\Models\FinancingConfig;
use App\Traits\AuthorizesAdminActions;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FinancingConfigController extends Controller
{
    use AuthorizesAdminActions;

    /**
     * Display a listing of financing configs.
     */
    public function index()
    {
        $this->authorizeAny(['settings.financing']);

        $configs = FinancingConfig::orderBy('name')->get();

        return view('admin.financing-config.index', compact('configs'));
    }

    /**
     * Show the form for creating a new financing config.
     */
    public function create()
    {
        $this->authorizeAny(['settings.financing']);

        return view('admin.financing-config.form', [
            'config' => null,
        ]);
    }

    /**
     * Store a newly created financing config in storage.
     */
    public function store(StoreFinancingConfigRequest $request)
    {
        $this->authorizeAny(['settings.financing']);

        $validated = $request->validated();

        // Generate type from name
        $validated['type'] = Str::slug($validated['name'], '_');

        try {
            FinancingConfig::create($validated);

            return redirect()
                ->route('admin.financing-config.index')
                ->with('success', 'Konfigurasi pembiayaan berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan konfigurasi: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show the form for editing the specified financing config.
     */
    public function edit(FinancingConfig $financingConfig)
    {
        $this->authorizeAny(['settings.financing']);

        return view('admin.financing-config.form', [
            'config' => $financingConfig,
        ]);
    }

    /**
     * Update the specified financing config in storage.
     */
    public function update(UpdateFinancingConfigRequest $request, FinancingConfig $financingConfig)
    {
        $this->authorizeAny(['settings.financing']);

        $validated = $this->transformConfigData($request);

        try {
            $financingConfig->update($validated);

            return redirect()
                ->route('admin.financing-config.index')
                ->with('success', 'Konfigurasi pembiayaan berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui konfigurasi: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified financing config from storage.
     */
    public function destroy(FinancingConfig $financingConfig)
    {
        $this->authorizeAny(['settings.financing']);

        try {
            $financingConfig->delete();

            return redirect()
                ->route('admin.financing-config.index')
                ->with('success', 'Konfigurasi pembiayaan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.financing-config.index')
                ->with('error', 'Gagal menghapus konfigurasi: ' . $e->getMessage());
        }
    }

    /**
     * Transform validated config data (normalize margin_rate, tenors, DP).
     */
    protected function transformConfigData($request): array
    {
        $validated = $request->validated();

        $validated['is_active'] = $request->boolean('is_active');
        $validated['dp_enabled'] = $request->boolean('dp_enabled');

        // Konversi margin rate dari persen ke desimal (16% -> 0.16)
        $validated['margin_rate'] = $validated['margin_rate'] / 100;

        // Set DP values to null if DP is disabled
        if (!$validated['dp_enabled']) {
            $validated['dp_min_percentage'] = null;
            $validated['dp_max_percentage'] = null;
        }

        // Sort tenors and remove duplicates
        $tenors = array_unique(array_map('intval', $validated['available_tenors']));
        sort($tenors);
        $validated['available_tenors'] = array_values($tenors);

        return $validated;
    }
}
