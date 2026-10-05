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
     * Batas minimum (detik) antara form dirender dan form dikirim.
     * Manusia butuh waktu mengetik email & kata sandi; bot mengirim hampir instan.
     */
    private const MIN_FORM_SECONDS = 2;

    public function showLoginForm()
    {
        // Verifikasi senyap: cukup catat waktu form dibuat.
        // Pengguna tidak perlu menjawab apa pun — bot akan tertangkap
        // oleh honeypot, cek waktu, dan rate limiter di method login().
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

        // 2) Cek waktu: bot mengirim form seketika setelah halaman dimuat,
        //    sedangkan manusia butuh waktu untuk mengisi email dan kata sandi.
        //    Kolom hilang berarti form tidak pernah dibuka (POST langsung).
        $issuedAt = session('login_form_issued_at');
        if ($issuedAt === null || (now()->timestamp - (int)$issuedAt) < self::MIN_FORM_SECONDS) {
            RateLimiter::hit($key, 60);

            throw ValidationException::withMessages([
                'email' => ['Sesi login tidak valid. Silakan muat ulang halaman dan coba lagi.'],
            ]);
        }

        if (Auth::guard('web')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

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
