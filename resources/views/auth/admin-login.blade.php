<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk | BPRS Bangka Belitung</title>
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/js/admin.js', 'resources/css/app.css'])
    @php $nonce = request()->attributes->get('csp_nonce'); @endphp
    <style nonce="{{ $nonce }}">
        /* ═══════════════════════════════════════════════
         * ISLAMIC GEOMETRIC BACKGROUND
         * ═══════════════════════════════════════════════ */
        .login-grid {
            background-image:
                radial-gradient(at 15% 25%, rgba(5,150,105,0.06) 0px, transparent 55%),
                radial-gradient(at 85% 75%, rgba(5,150,105,0.05) 0px, transparent 55%),
                radial-gradient(at 50% 50%, rgba(5,150,105,0.03) 0px, transparent 50%);
        }
        .login-geometric-pattern {
            position: fixed; inset: 0; pointer-events: none; z-index: 0; overflow: hidden;
        }
        /* SVG-based 8-pointed star repeating pattern */
        .login-geometric-pattern::before {
            content: ''; position: absolute; inset: -50%;
            background-image: url("data:image/svg+xml,%3Csvg width='120' height='120' viewBox='0 0 120 120' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M60 10L67 30L60 50L53 30Z M60 70L67 90L60 110L53 90Z M10 60L30 53L50 60L30 67Z M70 60L90 53L110 60L90 67Z M26 26L40 34L34 40Z M26 94L40 86L34 80Z M94 26L80 34L86 40Z M94 94L80 86L86 80Z' fill='none' stroke='rgba(5,150,105,0.04)' stroke-width='2'/%3E%3C/svg%3E");
            background-size: 240px 240px;
            animation: patternShift 120s linear infinite;
            will-change: transform;
        }
        @keyframes patternShift {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(120px, 120px) rotate(15deg); }
        }

        /* ═══════════════════════════════════════════════
         * DECORATIVE FLOATING ELEMENTS (CSS-only, GPU)
         * ═══════════════════════════════════════════════ */
        .orbit-container {
            position: fixed; inset: 0; pointer-events: none; z-index: 0; overflow: hidden;
        }
        .orbit-dot {
            position: absolute; border-radius: 50%; will-change: transform;
            background: radial-gradient(circle at 30% 30%, rgba(5,150,105,0.15), transparent);
        }
        .orbit-dot:nth-child(1) {
            width: 180px; height: 180px; top: 8%; left: 6%;
            animation: orbitFloat1 18s ease-in-out infinite;
        }
        .orbit-dot:nth-child(2) {
            width: 120px; height: 120px; bottom: 12%; right: 8%;
            animation: orbitFloat2 22s ease-in-out infinite;
            animation-delay: -5s;
        }
        .orbit-dot:nth-child(3) {
            width: 80px; height: 80px; top: 40%; right: 15%;
            animation: orbitFloat3 14s ease-in-out infinite;
            animation-delay: -10s;
            background: radial-gradient(circle at 30% 30%, rgba(251,191,36,0.12), transparent);
        }
        .orbit-dot:nth-child(4) {
            width: 60px; height: 60px; bottom: 30%; left: 10%;
            animation: orbitFloat4 20s ease-in-out infinite;
            animation-delay: -3s;
            background: radial-gradient(circle at 30% 30%, rgba(5,150,105,0.1), transparent);
        }
        .orbit-dot:nth-child(5) {
            width: 100px; height: 100px; top: 60%; left: 50%;
            animation: orbitFloat5 16s ease-in-out infinite;
            animation-delay: -8s;
            background: radial-gradient(circle at 30% 30%, rgba(251,191,36,0.08), transparent);
        }
        @keyframes orbitFloat1 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(40px, -60px) scale(1.05); }
            66% { transform: translate(-20px, 30px) scale(0.95); }
        }
        @keyframes orbitFloat2 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(-50px, 40px) scale(1.06); }
            66% { transform: translate(30px, -20px) scale(0.94); }
        }
        @keyframes orbitFloat3 {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(30px, -40px); }
        }
        @keyframes orbitFloat4 {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(-25px, 35px); }
        }
        @keyframes orbitFloat5 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(35px, 20px) scale(1.08); }
        }

        /* ═══════════════════════════════════════════════
         * CARD ENTRANCE & ANIMATIONS
         * ═══════════════════════════════════════════════ */
        .login-card {
            animation: cardEntrance 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            will-change: transform, opacity;
        }
        @keyframes cardEntrance {
            0% { opacity: 0; transform: translateY(40px) scale(0.97); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* Top accent bar shimmer */
        .accent-bar {
            background: linear-gradient(90deg,
                #059669 0%, #10b981 25%, #059669 50%, #10b981 75%, #059669 100%);
            background-size: 200% 100%;
            animation: accentShimmer 4s linear infinite;
        }
        @keyframes accentShimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* Form field entrance — staggered via Alpine */
        .form-field {
            will-change: transform, opacity;
        }

        /* Input micro-interactions */
        .input-field {
            transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
            will-change: transform;
        }
        .input-field:focus {
            transform: scale(1.01);
        }

        /* Submit button glow */
        .btn-login {
            transition: all 0.3s ease;
            will-change: transform;
        }
        .btn-login:not(:disabled):hover {
            transform: translateY(-1px);
        }
        .btn-login:not(:disabled):active {
            transform: translateY(0);
        }
        .btn-login-glow {
            position: relative;
        }
        .btn-login-glow::before {
            content: ''; position: absolute; inset: -4px;
            border-radius: inherit;
            background: linear-gradient(135deg, rgba(5,150,105,0.3), rgba(16,185,129,0.1));
            filter: blur(12px);
            opacity: 0;
            transition: opacity 0.5s ease;
            z-index: -1;
        }
        .btn-login-glow:hover::before {
            opacity: 1;
        }

        /* Logo pulse */
        .logo-icon {
            animation: logoPulse 3s ease-in-out infinite;
            will-change: transform;
        }
        @keyframes logoPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.03); }
        }

        /* Crescent accent — subtle gold arc */
        .crescent-accent {
            position: absolute;
            top: -20px; right: -20px;
            width: 80px; height: 80px;
            border-radius: 50%;
            box-shadow: 12px -8px 0 0 rgba(251, 191, 36, 0.08);
            pointer-events: none;
        }

        /* Success/error alert animation */
        .alert-slide {
            animation: alertSlideIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            will-change: transform, opacity;
        }
        @keyframes alertSlideIn {
            0% { opacity: 0; transform: translateY(-12px) scale(0.96); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* Spinner */
        .spinner { animation: spin 0.8s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* Float (existing card float) */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }

        /* Captcha box entrance */
        .captcha-box {
            animation: captchaFade 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            will-change: transform, opacity;
        }
        @keyframes captchaFade {
            0% { opacity: 0; transform: translateY(8px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* Input cleanup */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
        input[type="number"] { -moz-appearance: textfield; }
    </style>
</head>
<body class="font-sans antialiased min-h-screen flex items-center justify-center bg-gradient-to-br from-emerald-50 via-white to-emerald-50/50 login-grid relative overflow-hidden">

    <!-- Geometric Pattern Background -->
    <div class="login-geometric-pattern" aria-hidden="true"></div>

    <!-- Floating Ornamental Dots -->
    <div class="orbit-container" aria-hidden="true">
        <div class="orbit-dot"></div>
        <div class="orbit-dot"></div>
        <div class="orbit-dot"></div>
        <div class="orbit-dot"></div>
        <div class="orbit-dot"></div>
    </div>

    <!-- Main card -->
    <div class="relative z-10 w-full max-w-[420px] mx-6 login-card"
         x-data="loginForm()"
         x-init="init()">
        <div class="bg-white rounded-2xl shadow-xl shadow-black/5 border border-gray-100 overflow-hidden relative">

            <!-- Crescent motif -->
            <div class="crescent-accent" aria-hidden="true"></div>

            <!-- Shimmer accent bar -->
            <div class="h-1.5 w-full accent-bar"></div>

            <div class="p-8 sm:p-10">
                <!-- Logo section -->
                <div class="text-center mb-8">
                    <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-emerald-600 to-emerald-700 flex items-center justify-center shadow-lg shadow-emerald-500/25 logo-icon">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-gray-900 tracking-tight">BPRS Bangka Belitung</h1>
                    <p class="text-sm text-gray-500 mt-1 font-medium">Portal Administrator</p>
                </div>

                <!-- Error alert -->
                @if(session('error'))
                <div class="alert-slide flex items-start gap-2.5 p-3.5 mb-6 bg-red-50 border border-red-100 text-red-700 rounded-xl text-sm font-medium">
                    <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
                @endif

                <!-- Success alert -->
                @if(session('success'))
                <div class="alert-slide flex items-start gap-2.5 p-3.5 mb-6 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-xl text-sm font-medium">
                    <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('admin.login') }}"
                      x-data="{ showPassword: false, isLoading: false }"
                      @submit="isLoading = true">
                    @csrf

                    <!-- Email -->
                    <div class="mb-5 form-field" x-show="fields.email" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               required autocomplete="email" placeholder="nama@bank.com"
                               class="input-field w-full rounded-xl border border-gray-200 px-4 py-3 text-sm text-gray-900 placeholder-gray-400
                                      focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-500/20
                                      @error('email') border-red-300 bg-red-50/50 focus:border-red-400 focus:ring-red-500/20 @enderror">
                        @error('email')
                        <p class="flex items-center gap-1 text-xs text-red-600 mt-1.5">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-5 form-field" x-show="fields.password" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4">
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="text-sm font-semibold text-gray-700">Kata Sandi</label>
                            @if(Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">
                                Lupa?
                            </a>
                            @endif
                        </div>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" id="password" name="password"
                                   required autocomplete="current-password" placeholder="&bullet;&bullet;&bullet;&bullet;&bullet;&bullet;&bullet;&bullet;"
                                   class="input-field w-full rounded-xl border border-gray-200 px-4 py-3 pr-11 text-sm text-gray-900 placeholder-gray-300
                                          focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-500/20
                                          @error('password') border-red-300 bg-red-50/50 focus:border-red-400 focus:ring-red-500/20 @enderror">
                            <button type="button"
                                    @click="showPassword = !showPassword"
                                    :aria-label="showPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
                                    tabindex="-1"
                                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-gray-600 transition-colors">
                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                        <p class="flex items-center gap-1 text-xs text-red-600 mt-1.5">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Captcha -->
                    @if(isset($captcha_question))
                    <div class="mb-5 form-field captcha-box" x-show="fields.captcha" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4">
                        <label class="text-sm font-semibold text-gray-700 mb-1.5 block">Verifikasi Keamanan</label>
                        <div class="flex items-center justify-between gap-4 bg-gradient-to-br from-gray-50 to-white border border-gray-200 rounded-xl px-4 py-3">
                            <div>
                                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-0.5">Hitung</p>
                                <p class="text-lg font-bold text-gray-900">{{ $captcha_question }}</p>
                            </div>
                            <input type="number" name="captcha_answer" required placeholder="?"
                                   aria-label="Jawaban captcha"
                                   class="w-16 text-center rounded-lg border border-gray-200 px-2 py-2 text-lg font-bold text-gray-900
                                          focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-500/20
                                          @error('captcha_answer') border-red-300 bg-red-50/50 @enderror">
                        </div>
                        @error('captcha_answer')
                        <p class="flex items-center gap-1 text-xs text-red-600 mt-1.5">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                    @endif

                    <!-- Remember me -->
                    <div class="mb-6 form-field" x-show="fields.remember" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4">
                        <label class="inline-flex items-center gap-2.5 cursor-pointer select-none group">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                                   class="rounded-md border-gray-300 text-emerald-600 focus:ring-emerald-500 focus:ring-offset-0 cursor-pointer transition-all duration-200">
                            <span class="text-sm text-gray-600 font-medium group-hover:text-gray-900 transition-colors">Tetap masuk</span>
                        </label>
                    </div>

                    <!-- Submit -->
                    <div class="form-field" x-show="fields.submit" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4">
                        <button type="submit" :disabled="isLoading"
                                class="btn-login btn-login-glow w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-bold text-sm rounded-xl
                                       shadow-lg shadow-emerald-500/20 hover:shadow-xl hover:shadow-emerald-500/25 hover:from-emerald-700 hover:to-emerald-800
                                       focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2
                                       disabled:opacity-60 disabled:cursor-not-allowed transition-all duration-200">
                            <svg x-show="isLoading" class="spinner -ml-1" width="16" height="16" viewBox="0 0 24 24" fill="none" x-cloak>
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                            </svg>
                            <span x-text="isLoading ? 'Memproses...' : 'Masuk'">Masuk</span>
                        </button>
                    </div>
                </form>

                <!-- Footer -->
                <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-100">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-400 hover:text-emerald-600 transition-colors group">
                        <svg class="w-3.5 h-3.5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Beranda
                    </a>
                    <span class="text-[11px] text-gray-300">&copy; {{ date('Y') }} BPRS Bangka Belitung</span>
                </div>
            </div>
        </div>
    </div>

    <x-device-fingerprint />

    <script nonce="{{ $nonce }}">
        document.addEventListener('alpine:init', () => {
            Alpine.data('loginForm', () => ({
                fields: { email: false, password: false, captcha: false, remember: false, submit: false },
                init() {
                    // Stagger entrance: reveal fields one by one
                    const timings = { email: 0, password: 150, captcha: 300, remember: 400, submit: 500 };
                    Object.entries(timings).forEach(([key, delay]) => {
                        setTimeout(() => { this.fields[key] = true; }, delay);
                    });
                }
            }));
        });
    </script>
</body>
</html>
