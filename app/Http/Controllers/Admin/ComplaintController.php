<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendComplaintStatusEmail;
use App\Models\Complaint;
use App\Traits\AuthorizesAdminActions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ComplaintController extends Controller
{
    use AuthorizesAdminActions;

    public function index(Request $request)
    {
        $this->authorizeView('complaints.view');

        $query = Complaint::latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('ticket_number', 'like', '%' . $request->search . '%')
                    ->orWhere('name', 'like', '%' . $request->search . '%')
                    ->orWhere('subject', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $complaints = $query->paginate(15)->withQueryString();

        return view('admin.complaints.index', compact('complaints'));
    }

    public function show(Complaint $complaint)
    {
        $this->authorizeView('complaints.view');

        return view('admin.complaints.show', compact('complaint'));
    }

    public function update(Request $request, Complaint $complaint)
    {
        $this->authorizeEdit('complaints.manage');
        $validated = $request->validate([
            'status' => 'required|in:pending,in_review,investigating,resolved,closed',
            'admin_notes' => 'nullable|string',
        ]);

        try {
            $oldStatus = $complaint->status;

            if ($validated['status'] === 'resolved' && $complaint->status !== 'resolved') {
                $validated['resolved_at'] = now();
            }

            $complaint->update($validated);

            if (
                $oldStatus !== $validated['status'] &&
                $complaint->email &&
                $complaint->email !== 'anonymous@whistleblowing.local'
            ) {
                try {
                    SendComplaintStatusEmail::dispatch(
                        complaint: $complaint,
                        oldStatus: $oldStatus,
                        adminNotes: $validated['admin_notes'] ?? null,
                    );
                } catch (\Exception $e) {
                    Log::error('Failed to dispatch complaint status email job: ' . $e->getMessage());
                }
            }

            return redirect()->route('admin.complaints.show', $complaint)->with('success', 'Status pengaduan berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui pengaduan: ' . $e->getMessage());
        }
    }

    public function destroy(Complaint $complaint)
    {
        $this->authorizeDelete('complaints.manage');

        try {
            $complaint->delete();
            return redirect()->route('admin.complaints.index')->with('success', 'Pengaduan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.complaints.index')->with('error', 'Gagal menghapus pengaduan: ' . $e->getMessage());
        }
    }
}
