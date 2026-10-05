<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AdminLoginController extends Controller
{
    /**
     * Maksimal waktu session form login (120 menit).
     * Selaras dengan SESSION_LIFETIME agar tidak memblokir user yang wajar.
     * Hanya untuk mencegah token form yang menggantung terlalu lama.
     */
    private const MAX_FORM_SECONDS = 7200;

    public function showLoginForm()
    {
        // Catat waktu form dibuat. Hanya dipakai sebagai batas atas (MAX_FORM_SECONDS)
        // untuk mencegah form menggantung terlalu lama — BUKAN untuk memblokir
        // submit cepat, karena autofill browser & password manager sah-sah saja
        // mengisi form seketika. Deteksi bot mengandalkan honeypot + rate limiter.
        session(['login_form_issued_at' => now()->timestamp]);

        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $key = 'admin-login-' . ($request->ip() ?? '0.0.0.0');
        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages([
                'email' => ['Terlalu banyak percobaan login. Silakan coba lagi dalam ' . RateLimiter::availableIn($key) . ' detik.'],
            ]);
        }

        // --- Verifikasi senyap (tanpa tantangan yang terlihat oleh pengguna) ---

        // 1) Honeypot: kolom tersembunyi yang tidak akan pernah diisi manusia.
        //    Bot otomatis mengisi semua kolom yang ia temukan di HTML.
        if ($request->filled('website')) {
            RateLimiter::hit($key, 60);

            // Pesan generik agar bot tidak mengetahui bahwa honeypot terdeteksi.
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        // 2) Batas atas usia form: mencegah form yang menggantung terlalu lama
        //    (mis. halaman login dibiarkan terbuka berhari-hari lalu disubmit).
        //    Tidak ada batas bawah — autofill browser/password manager sah,
        //    sehingga submit cepat TIDAK boleh diblokir. Deteksi bot mengandalkan
        //    honeypot (langkah 1) dan rate limiter.
        $issuedAt = session('login_form_issued_at');

        if ($issuedAt !== null && (now()->timestamp - (int) $issuedAt) > self::MAX_FORM_SECONDS) {
            throw ValidationException::withMessages([
                'email' => ['Sesi login telah kedaluwarsa. Silakan muat ulang halaman dan login kembali.'],
            ]);
        }

        if (Auth::guard('web')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user()->load('roleModel.permissions');

            if (!$user->is_active) {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                throw ValidationException::withMessages([
                    'email' => ['Akun Anda tidak aktif. Silakan hubungi administrator.'],
                ]);
            }

            if (!$user->hasRole('super_admin') && !$user->hasRole('admin')) {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                RateLimiter::hit($key, 60);

                throw ValidationException::withMessages([
                    'email' => ['Anda tidak memiliki akses ke halaman admin.'],
                ]);
            }

            RateLimiter::clear($key);

            session()->forget('login_form_issued_at');

            session()->put('cached_role', [
                'name' => $user->roleModel?->name,
                'display_name' => $user->roleModel?->display_name,
                'permissions' => $user->roleModel?->permissions?->pluck('name')->toArray() ?? [],
            ]);
            session()->put('cached_role_at', now()->timestamp);

            \App\Models\AuditTrail::log('login', 'Admin login: ' . $user->name);

            return redirect()->intended(route('admin.dashboard'));
        }

        RateLimiter::hit($key, 60);

        throw ValidationException::withMessages([
            'email' => ['Email atau password salah.'],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Anda telah berhasil keluar.');
    }
}
