<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\SecureSessionMiddleware;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Models\User;
use App\Models\Role;
use App\Traits\AuthorizesAdminActions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use AuthorizesAdminActions;

    public function index(Request $request)
    {
        $this->authorizeView('users.view');

        $query = User::with('roleModel')->latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role_id')) {
            $query->where('role_id', $request->role_id);
        }

        $users = $query->paginate(15)->withQueryString();
        $roles = Role::getActiveRoles();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $this->authorizeCreate('users.create');

        $roles = Role::getActiveRoles();
        return view('admin.users.form', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $this->authorizeCreate('users.create');

        $validated = $request->validated();

        // Prevent non-super-admin from creating super admins
        /** @var \App\Models\User $currentUser */
        $currentUser = auth()->user();
        if (!$currentUser->isSuperAdmin()) {
            $newRole = Role::find($validated['role_id']);
            if ($newRole && $newRole->name === User::ROLE_SUPER_ADMIN) {
                return back()->with('error', 'Hanya Super Admin yang dapat membuat akun Super Admin baru.');
            }
        }

        try {
            $user = new User();
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->password = Hash::make($validated['password']);
            $user->role_id = $validated['role_id'];
            $user->is_active = $request->boolean('is_active');
            $user->save();

            return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan pengguna: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(User $user)
    {
        $this->authorizeEdit('users.edit');

        $roles = Role::getActiveRoles();
        return view('admin.users.form', compact('user', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorizeEdit('users.edit');

        $validated = $request->validated();

        // Prevent non-super-admin from elevating roles or changing super admin data
        /** @var \App\Models\User $currentUser */
        $currentUser = auth()->user();
        if (!$currentUser->isSuperAdmin()) {
            $newRole = Role::find($validated['role_id']);
            if ($newRole && $newRole->name === User::ROLE_SUPER_ADMIN) {
                return back()->with('error', 'Hanya Super Admin yang dapat memberikan hak akses Super Admin.');
            }

            if ($user->isSuperAdmin()) {
                return back()->with('error', 'Anda tidak memiliki wewenang untuk mengubah data Super Admin.');
            }
        }

        try {
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->role_id = $validated['role_id'];
            $user->is_active = $request->boolean('is_active');

            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }

            $user->save();

            // Clear cached role if the updated user is the current user (self-role-change)
            // or if the role_id changed
            if ((int) $user->id === (int) auth()->id()) {
                SecureSessionMiddleware::clearCachedRole();
            }

            return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui pengguna: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(User $user)
    {
        $this->authorizeDelete('users.delete');

        /** @var \App\Models\User $currentUser */
        $currentUser = auth()->user();
        if ($user->id === $currentUser->id) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        try {
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')->with('error', 'Gagal menghapus pengguna: ' . $e->getMessage());
        }
    }
}
