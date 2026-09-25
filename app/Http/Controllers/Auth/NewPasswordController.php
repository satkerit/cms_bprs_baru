<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', new \App\Rules\StrongPassword()],
        ]);

        // Kebijakan anti-reuse: tolak bila password baru sama dengan 5 password terakhir user.
        // Dicek lebih dulu (sebelum Password::reset) agar token tidak terpakai sia-sia
        // saat password ditolak.
        $user = User::where('email', $request->email)->first();
        if ($user && $user->hasUsedPassword($request->password)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'password' => 'Password ini sudah pernah digunakan. Silakan gunakan password yang berbeda.',
                ]);
        }

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user) use ($request) {
                // Simpan password baru ke riwayat (setelah lolos cek anti-reuse di atas)
                \App\Models\PasswordHistory::savePassword($user->id, $request->password);

                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));

                // Log password reset
                \Log::info('Password reset completed', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'ip' => $request->ip() ?? '0.0.0.0',
                ]);
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('admin.login')->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}
