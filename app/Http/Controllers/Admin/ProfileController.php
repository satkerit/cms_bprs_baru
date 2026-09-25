<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\UpdateProfilePasswordRequest;
use App\Http\Requests\Admin\Profile\UpdateProfileRequest;
use App\Models\PasswordHistory;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * Show the profile edit form.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $user = auth()->user();
        return view('admin.profile.edit', compact('user'));
    }

    /**
     * Update the user profile.
     *
     * @param  \App\Http\Requests\Admin\Profile\UpdateProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProfileRequest $request)
    {
        $user = auth()->user();

        $user->update($request->validated());

        return redirect()->route('admin.profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update the user password.
     *
     * @param  \App\Http\Requests\Admin\Profile\UpdateProfilePasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(UpdateProfilePasswordRequest $request)
    {
        $user = auth()->user();
        $validated = $request->validated();

        // Kebijakan anti-reuse: tolak bila sama dengan salah satu dari 5 password terakhir
        if ($user->hasUsedPassword($validated['password'])) {
            throw ValidationException::withMessages([
                'password' => 'Password ini sudah pernah digunakan. Silakan gunakan password yang berbeda.',
            ]);
        }

        // Simpan password baru ke riwayat agar cek reuse berlaku untuk update berikutnya
        PasswordHistory::savePassword($user->id, $validated['password']);

        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
        ]);

        // Log perubahan password untuk keperluan audit
        \Log::info('Password changed via admin profile', [
            'user_id' => $user->id,
            'ip' => $request->ip() ?? '0.0.0.0',
        ]);

        return redirect()->route('admin.profile.edit')
            ->with('success', 'Password berhasil diperbarui.');
    }
}
