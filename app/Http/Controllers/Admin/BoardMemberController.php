<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BoardMember\StoreBoardMemberRequest;
use App\Http\Requests\Admin\BoardMember\UpdateBoardMemberRequest;
use App\Models\BoardMember;
use App\Services\BoardMemberService;
use App\Traits\AuthorizesAdminActions;
use App\Traits\HandlesImageUpload;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class BoardMemberController extends Controller
{
    use HandlesImageUpload, AuthorizesAdminActions;

    public function __construct(
        private readonly BoardMemberService $boardMemberService,
    ) {}

    public function index(Request $request)
    {
        $this->authorizeView('board.view');

        $members = $this->boardMemberService->list(
            search: $request->input('search'),
            type: $request->input('type'),
        );

        return view('admin.board-members.index', compact('members'));
    }

    public function create()
    {
        $this->authorizeCreate('board.manage');

        return view('admin.board-members.form');
    }

    public function store(StoreBoardMemberRequest $request)
    {
        $this->authorizeCreate('board.manage');

        $validated = $request->validated();
        $photoPath = $this->handleImageUpload($request, 'photo', 'board-members');

        $result = $this->boardMemberService->create(
            data: $validated,
            photoPath: $photoPath,
        );

        if ($result['success']) {
            return redirect()->route('admin.board-members.index')
                ->with('success', 'Anggota dewan berhasil ditambahkan.');
        }

        return back()->withInput()
            ->with('error', 'Gagal menambahkan anggota: ' . ($result['error'] ?? ''));
    }

    public function edit(BoardMember $boardMember)
    {
        $this->authorizeEdit('board.manage');

        return view('admin.board-members.form', compact('boardMember'));
    }

    public function update(UpdateBoardMemberRequest $request, BoardMember $boardMember)
    {
        $this->authorizeEdit('board.manage');

        $validated = $request->validated();
        $photoPath = $this->handleImageUpload($request, 'photo', 'board-members', $boardMember->photo);

        $result = $this->boardMemberService->update(
            member: $boardMember,
            data: $validated,
            photoPath: $photoPath,
        );

        if ($result['success']) {
            return redirect()->route('admin.board-members.index')
                ->with('success', 'Anggota dewan berhasil diperbarui.');
        }

        return back()->withInput()
            ->with('error', 'Gagal memperbarui anggota: ' . ($result['error'] ?? ''));
    }

    public function destroy(BoardMember $boardMember)
    {
        $this->authorizeDelete('board.manage');

        $result = $this->boardMemberService->delete($boardMember);

        if ($result['success']) {
            return redirect()->route('admin.board-members.index')
                ->with('success', 'Anggota dewan berhasil dihapus.');
        }

        return redirect()->route('admin.board-members.index')
            ->with('error', 'Gagal menghapus anggota: ' . ($result['error'] ?? ''));
    }
}
