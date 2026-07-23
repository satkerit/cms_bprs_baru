<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verifikasi Email - {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="has-background-light" style="font-family: 'Inter', sans-serif;">
    <div class="hero is-fullheight">
        <div class="hero-body">
            <div class="container" style="max-width: 28rem;">
                <div class="has-text-centered mb-8">
                    <a href="{{ route('home') }}" class="is-inline-block">
                        <h1 class="title is-3 has-text-success">BPRS Bangka Belitung</h1>
                    </a>
                    <h2 class="title is-4 has-text-dark mt-4">Verifikasi Email</h2>
                </div>

                <div class="box">
                    <p class="has-text-grey mb-4">
                        Terima kasih telah mendaftar! Sebelum memulai, silakan verifikasi alamat email Anda dengan mengklik link yang baru saja kami kirimkan ke email Anda.
                    </p>

                    @if(session('status') == 'verification-link-sent')
                    <div class="notification is-success is-light mb-4">
                        Link verifikasi baru telah dikirim ke alamat email Anda.
                    </div>
                    @endif

                    <div class="is-flex is-align-items-center is-justify-content-space-between mt-6">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="button is-success has-text-weight-semibold">
                                Kirim Ulang Email Verifikasi
                            </button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="button is-ghost has-text-grey hover:has-text-grey-dark">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
