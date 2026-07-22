@extends('layouts.admin')

@section('title', 'Profil Saya')

@section('content')
<div class="space-y-6 max-w-7xl">

    <x-admin.page-header
        title="Profil Saya"
        subtitle="Kelola informasi profil dan keamanan akun Anda"
        accent="gold"
    />

    {{-- ═══ PROFILE IDENTITY BAR ═══ --}}
    <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm p-5 sm:p-6">
        <div class="flex items-center gap-5">
            {{-- Avatar Initials --}}
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-600/20 shrink-0 ring-4 ring-emerald-50">
                <span class="text-2xl font-bold text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2.5 flex-wrap">
                    <h2 class="text-lg font-semibold text-slate-900">{{ $user->name }}</h2>
                    <span class="admin-badge-emerald text-[10px]">{{ $user->roleModel?->display_name ?? 'N/A' }}</span>
                </div>
                <p class="text-[13px] text-slate-500 mt-0.5">{{ $user->email }}</p>
                @if($user->created_at)
                    <p class="text-[11px] text-slate-400 mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                        </svg>
                        Member sejak {{ $user->created_at->format('F Y') }}
                    </p>
                @endif
            </div>
        </div>
    </div>

    {{-- ═══ MAIN GRID ═══ --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Profile Information --}}
        <x-admin.card title="Informasi Profil" subtitle="Perbarui informasi profil dan email Anda" accent="emerald">
            <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <x-admin.input
                    name="name"
                    label="Nama"
                    :value="old('name', $user->name)"
                    :error="$errors->first('name')"
                    placeholder="Masukkan nama lengkap"
                    required
                />

                <x-admin.input
                    type="email"
                    name="email"
                    label="Email"
                    :value="old('email', $user->email)"
                    :error="$errors->first('email')"
                    placeholder="nama@email.com"
                    required
                />

                <div>
                    <label class="block text-[13px] font-medium text-slate-700 mb-1.5">Role</label>
                    <div class="flex items-center gap-2.5 px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-500">
                        <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                        </svg>
                        {{ $user->roleModel?->display_name ?? 'N/A' }}
                    </div>
                </div>

                <div class="pt-2">
                    <x-admin.button type="submit" variant="primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Simpan Profil
                    </x-admin.button>
                </div>
            </form>
        </x-admin.card>

        {{-- Change Password --}}
        <x-admin.card title="Ubah Password" subtitle="Pastikan menggunakan password yang kuat dan unik" accent="gold">
            <form action="{{ route('admin.profile.password') }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <x-admin.input
                    type="password"
                    name="current_password"
                    label="Password Saat Ini"
                    :error="$errors->first('current_password')"
                    placeholder="Masukkan password saat ini"
                    autocomplete="current-password"
                />

                <x-admin.input
                    type="password"
                    name="password"
                    label="Password Baru"
                    :error="$errors->first('password')"
                    placeholder="Min. 8 karakter"
                    autocomplete="new-password"
                    helper="Gunakan kombinasi huruf, angka, dan simbol untuk password yang kuat"
                />

                <x-admin.input
                    type="password"
                    name="password_confirmation"
                    label="Konfirmasi Password Baru"
                    placeholder="Ulangi password baru"
                    autocomplete="new-password"
                />

                <div class="pt-2">
                    <x-admin.button type="submit" variant="gold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                        </svg>
                        Ubah Password
                    </x-admin.button>
                </div>
            </form>
        </x-admin.card>

    </div>
</div>
@endsection
