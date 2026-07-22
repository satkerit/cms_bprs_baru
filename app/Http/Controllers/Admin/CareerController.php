<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Career\StoreCareerRequest;
use App\Http\Requests\Admin\Career\UpdateCareerRequest;
use App\Models\Career;
use App\Traits\AuthorizesAdminActions;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    use AuthorizesAdminActions;

    public function index(Request $request)
    {
        $this->authorizeView('careers.view');

        $query = Career::latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('department', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true)->where(function ($q) {
                    $q->whereNull('deadline')->orWhere('deadline', '>=', now()->toDateString());
                });
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            } elseif ($request->status === 'expired') {
                $query->where('deadline', '<', now()->toDateString());
            }
        }

        if ($request->filled('type')) {
            $query->where('employment_type', $request->type);
        }

        $careers = $query->paginate(15)->withQueryString();

        return view('admin.careers.index', compact('careers'));
    }

    public function create()
    {
        $this->authorizeCreate('careers.create');

        return view('admin.careers.form');
    }

    public function store(StoreCareerRequest $request)
    {
        $this->authorizeCreate('careers.create');
        $validated = $request->validated();

        try {
            $validated['is_active'] = $request->boolean('is_active');
            $validated['order_position'] = $request->order_position ?? 0;

            Career::create($validated);

            return redirect()->route('admin.careers.index')->with('success', 'Lowongan karir berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menyimpan lowongan: ' . $e->getMessage());
        }
    }

    public function show(Career $career)
    {
        $this->authorizeView('careers.view');

        return redirect()->route('admin.careers.edit', $career);
    }

    public function edit(Career $career)
    {
        $this->authorizeEdit('careers.edit');

        return view('admin.careers.form', compact('career'));
    }

    public function update(UpdateCareerRequest $request, Career $career)
    {
        $this->authorizeEdit('careers.edit');
        $validated = $request->validated();

        try {
            $validated['is_active'] = $request->boolean('is_active');

            $career->update($validated);

            return redirect()->route('admin.careers.index')->with('success', 'Lowongan karir berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal memperbarui lowongan: ' . $e->getMessage());
        }
    }

    public function destroy(Career $career)
    {
        $this->authorizeDelete('careers.delete');

        try {
            $career->delete();
            return redirect()->route('admin.careers.index')->with('success', 'Lowongan karir berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.careers.index')->with('error', 'Gagal menghapus lowongan: ' . $e->getMessage());
        }
    }
}
