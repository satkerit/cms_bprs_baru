<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        $num1 = random_int(10, 99);
        $num2 = random_int(10, 99);
        $op = random_int(0, 2);
        $operator = match ($op) {
            0 => '+',
            1 => '-',
            2 => '×',
        };

        if ($operator === '-' && $num1 < $num2) {
            [$num1, $num2] = [$num2, $num1];
        }
        if ($operator === '×') {
            $num1 = random_int(10, 30);
            $num2 = random_int(2, 9);
        }

        $answer = match ($operator) {
            '+' => $num1 + $num2,
            '-' => $num1 - $num2,
            '×' => $num1 * $num2,
        };

        $expiresAt = now()->addMinutes(5)->timestamp;

        session([
            'login_captcha_answer' => $answer,
            'login_captcha_expires' => $expiresAt,
        ]);

        return view('auth.admin-login', [
            'captcha_question' => "$num1 $operator $num2 = ?",
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'captcha_answer' => 'required|numeric',
        ]);

        $captchaKey = 'captcha-attempt-' . ($request->ip() ?? '0.0.0.0');
        if (RateLimiter::tooManyAttempts($captchaKey, 5)) {
            throw ValidationException::withMessages([
                'captcha_answer' => ['Terlalu banyak percobaan. Silakan tunggu ' . RateLimiter::availableIn($captchaKey) . ' detik.'],
            ]);
        }

        $sessionAnswer = session('login_captcha_answer');
        $sessionExpires = session('login_captcha_expires');

        if ($sessionAnswer === null || $sessionExpires === null) {
            throw ValidationException::withMessages([
                'captcha_answer' => ['Sesi CAPTCHA tidak ditemukan. Silakan refresh halaman.'],
            ]);
        }

        if (now()->timestamp > $sessionExpires) {
            session()->forget(['login_captcha_answer', 'login_captcha_expires']);
            throw ValidationException::withMessages([
                'captcha_answer' => ['CAPTCHA telah kedaluwarsa. Silakan refresh halaman.'],
            ]);
        }

        if ((int)$request->captcha_answer !== (int)$sessionAnswer) {
            RateLimiter::hit($captchaKey, 60);
            session()->forget(['login_captcha_answer', 'login_captcha_expires']);
            throw ValidationException::withMessages([
                'captcha_answer' => ['Jawaban keamanan salah. Silakan refresh halaman dan coba lagi.'],
            ]);
        }

        RateLimiter::clear($captchaKey);

        $key = 'admin-login-' . ($request->ip() ?? '0.0.0.0');
        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages([
                'email' => ['Terlalu banyak percobaan login. Silakan coba lagi dalam ' . RateLimiter::availableIn($key) . ' detik.'],
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

            session()->forget(['login_captcha_answer', 'login_captcha_expires']);

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
