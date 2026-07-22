<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Office\StoreOfficeRequest;
use App\Http\Requests\Admin\Office\UpdateOfficeRequest;
use App\Models\Office;
use App\Traits\AuthorizesAdminActions;
use App\Traits\HandlesImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OfficeController extends Controller
{
    use AuthorizesAdminActions, HandlesImageUpload;

    public function index(Request $request)
    {
        $this->authorizeView('offices.view');
        $query = Office::orderBy('type')->orderBy('name');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $offices = $query->paginate(15)->withQueryString();

        return view('admin.offices.index', compact('offices'));
    }

    public function create()
    {
        $this->authorizeCreate('offices.create');

        return view('admin.offices.form');
    }

    public function store(StoreOfficeRequest $request)
    {
        $this->authorizeCreate('offices.create');

        $validated = $request->validated();

        $validated['is_active'] = $request->boolean('is_active');

        $validated['photo'] = $this->handleImageUpload($request, 'photo', 'offices');

        try {
            Office::create($validated);
            return redirect()->route('admin.offices.index')->with('success', 'Kantor berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan kantor: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Office $office)
    {
        $this->authorizeEdit('offices.edit');

        return view('admin.offices.form', compact('office'));
    }

    public function update(UpdateOfficeRequest $request, Office $office)
    {
        $this->authorizeEdit('offices.edit');

        $validated = $request->validated();

        $validated['is_active'] = $request->boolean('is_active');

        $validated['photo'] = $this->handleImageUpload($request, 'photo', 'offices', $office->photo);

        try {
            $office->update($validated);
            return redirect()->route('admin.offices.index')->with('success', 'Kantor berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui kantor: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Office $office)
    {
        $this->authorizeDelete('offices.delete');

        if ($office->photo) {
            Storage::disk('public')->delete($office->photo);
        }

        try {
            $office->delete();
            return redirect()->route('admin.offices.index')->with('success', 'Kantor berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.offices.index')->with('error', 'Gagal menghapus kantor: ' . $e->getMessage());
        }
    }
}
