<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Atur Ulang Password - {{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/js/app.js', 'resources/css/app.css'])

    @php $nonce = request()->attributes->get('csp_nonce'); @endphp

    <style nonce="{{ $nonce }}">
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            background-image: radial-gradient(#cbd5e1 0.5px, transparent 0.5px);
            background-size: 24px 24px;
        }

        .login-card {
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            background-color: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(209, 213, 219, 0.3);
        }

        .input-focus-ring:focus {
            --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
            --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(3px + var(--tw-ring-offset-width)) rgba(5, 150, 105, 0.15);
            box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
            border-color: #059669;
        }

        .btn-primary {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #047857 0%, #065f46 100%);
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(5, 150, 105, 0.3);
        }

        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="has-text-dark" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    @php
        $companyInfo = \App\Models\CompanyInfo::getInfo();
    @endphp

    <div class="hero is-fullheight">
        <div class="hero-body" style="padding: 1rem;">
            <div class="container" style="max-width: 440px;">
                <!-- Logo & Header -->
                <div class="has-text-centered mb-8">
                    <div class="is-inline-flex is-align-items-center is-justify-content-center mb-4" style="width: 64px; height: 64px; background: white; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(5, 150, 105, 0.1); padding: 0.5rem;">
                        @if($companyInfo && $companyInfo->logo)
                            <img src="{{ Storage::url($companyInfo->logo) }}" alt="Logo" class="is-fullwidth is-fullheight" style="object-fit: contain;">
                        @else
                            <svg class="w-10 h-10 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        @endif
                    </div>
                    <h1 class="title is-4 has-text-dark">Atur Ulang Password</h1>
                    <p class="has-text-grey has-text-weight-medium">Buat password baru yang aman untuk akun Anda</p>
                </div>

                <!-- Card -->
                <div class="login-card box" style="padding: 2.5rem;">
                    <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <!-- Email Field -->
                        <div class="field">
                            <label for="email" class="label">Alamat Email</label>
                            <div class="control has-icons-left">
                                <span class="icon is-left has-text-grey-light">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                    </svg>
                                </span>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email', $request->email) }}"
                                    required
                                    readonly
                                    class="input has-text-grey-light" style="background: #f1f5f9; border-color: #e2e8f0; cursor: not-allowed;"
                                >
                            </div>
                            @error('email')
                                <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="field">
                            <label for="password" class="label">Password Baru</label>
                            <div class="control has-icons-left">
                                <span class="icon is-left has-text-grey-light">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </span>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    required
                                    autofocus
                                    class="input input-focus-ring"
                                    placeholder="Minimal 8 karakter"
                                >
                            </div>
                            @error('password')
                                <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="field">
                            <label for="password_confirmation" class="label">Konfirmasi Password</label>
                            <div class="control has-icons-left">
                                <span class="icon is-left has-text-grey-light">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </span>
                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    required
                                    class="input input-focus-ring"
                                    placeholder="Ulangi password baru"
                                >
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="field">
                            <div class="control">
                                <button type="submit" class="button is-fullwidth btn-primary has-text-white has-text-weight-bold is-medium is-flex is-align-items-center is-justify-content-center" style="border: none; gap: 0.75rem; box-shadow: 0 10px 15px -3px rgba(5, 150, 105, 0.2);">
                                    <span>Simpan Password</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Animations -->
    <style nonce="{{ $nonce }}">
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fadeIn 0.8s ease-out forwards; }
        .animate-slide-up { animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    </style>
</body>
</html>
