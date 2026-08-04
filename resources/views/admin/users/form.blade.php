@extends('layouts.admin')

@section('title', isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna')

@section('content')
@php
    $isEdit = isset($user);
    $selectedRoleId = old('role_id', $user->role_id ?? null);
    $selectedRole = $selectedRoleId ? $roles->firstWhere('id', (int) $selectedRoleId) : null;
    $isActive = old('is_active') !== null ? (bool) old('is_active') : ($user->is_active ?? true);
    $rolesMap = $roles->mapWithKeys(fn($r) => [
        (string) $r->id => [
            'display_name' => $r->display_name,
            'description' => $r->description,
            'is_system' => (bool) $r->is_system,
        ],
    ]);
@endphp

<x-admin.page-header
    :title="$isEdit ? 'Edit Pengguna' : 'Tambah Pengguna'"
    :subtitle="$isEdit ? 'Perbarui identitas, role, dan status akun.' : 'Buat akun baru dengan role dan status yang tepat.'"
    :badge="$isEdit ? ($isActive ? 'Aktif' : 'Nonaktif') : 'Baru'"
>
    <x-slot:actions>
        <x-admin.button href="{{ route('admin.users.index') }}" variant="secondary">Kembali</x-admin.button>
    </x-slot:actions>
</x-admin.page-header>

@if($errors->any())
    <x-admin.alert type="error" title="Periksa kembali input Anda" class="mb-6">
        Ada {{ $errors->count() }} isian yang perlu diperbaiki. Silakan cek pesan error pada masing-masing field.
    </x-admin.alert>
@endif

<div class="max-w-6xl">
    <form action="{{ $isEdit ? route('admin.users.update', $user) : route('admin.users.store') }}" method="POST"
        class="grid grid-cols-1 lg:grid-cols-3 gap-6"
        x-data="{ roleId: '{{ $selectedRoleId }}', roles: @js($rolesMap) }"
    >
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div class="lg:col-span-2 space-y-6">
            <x-admin.card title="Profil" subtitle="Identitas dasar untuk login dan tampilan sistem" accent="emerald">
                <div class="space-y-5">
                    <x-admin.input
                        name="name"
                        label="Nama Lengkap"
                        :value="old('name', $user->name ?? '')"
                        placeholder="Contoh: Ahmad Hidayat"
                        required
                        :error="$errors->first('name')"
                        autocomplete="name"
                    />

                    <x-admin.input
                        type="email"
                        name="email"
                        label="Email"
                        :value="old('email', $user->email ?? '')"
                        placeholder="nama@email.com"
                        required
                        :error="$errors->first('email')"
                        autocomplete="email"
                        helper="Email digunakan sebagai username untuk login."
                    />
                </div>
            </x-admin.card>

            <x-admin.card title="Akses & Keamanan" subtitle="Role, status akun, dan pengaturan password" accent="violet">
                <div class="space-y-5">
                    <div>
                        <label class="block text-[13px] font-medium text-slate-700 mb-1.5">
                            Role <span class="text-red-500">*</span>
                        </label>
                        <x-admin.select name="role_id" required @change="roleId = $event.target.value">
                            <option value="">Pilih Role</option>
                            @foreach($roles as $roleModel)
                                <option value="{{ $roleModel->id }}" {{ (string) $selectedRoleId === (string) $roleModel->id ? 'selected' : '' }}>
                                    {{ $roleModel->display_name }}
                                </option>
                            @endforeach
                        </x-admin.select>
                        @error('role_id')<p class="mt-1 text-[12px] text-red-600">{{ $message }}</p>@enderror

                        <div class="mt-2 text-[13px] text-slate-600 dark:text-slate-400 leading-relaxed"
                            x-show="roleId && roles[roleId] && roles[roleId].description"
                            x-text="roles[roleId]?.description"
                            x-cloak
                        ></div>

                        <div class="mt-2 text-[12px] text-slate-500 dark:text-slate-400 flex items-center gap-2"
                            x-show="roleId && roles[roleId] && roles[roleId].is_system"
                            x-cloak
                        >
                            <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200/70 dark:border-slate-700/70">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                Role sistem
                            </span>
                            <span>Perubahan akses dibatasi untuk alasan keamanan.</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 p-4 rounded-xl border border-slate-200/70 dark:border-slate-800/70 bg-slate-50/70 dark:bg-slate-800/30">
                        <div class="mt-0.5">
                            <input
                                type="checkbox"
                                name="is_active"
                                id="is_active"
                                value="1"
                                {{ $isActive ? 'checked' : '' }}
                                class="rounded border-slate-300 dark:border-slate-700 text-emerald-600 focus:ring-emerald-500"
                            >
                        </div>
                        <div class="min-w-0">
                            <label for="is_active" class="text-sm font-semibold text-slate-800 dark:text-slate-200">Akun Aktif</label>
                            <p class="mt-0.5 text-[13px] text-slate-500 dark:text-slate-400 leading-relaxed">
                                Jika nonaktif, pengguna tidak dapat login sampai diaktifkan kembali.
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-admin.input
                            type="password"
                            name="password"
                            label="Password"
                            :required="!$isEdit"
                            :error="$errors->first('password')"
                            :helper="$isEdit ? 'Kosongkan jika tidak ingin mengubah password.' : 'Min. 8 karakter. Gunakan kombinasi huruf, angka, dan simbol.'"
                            autocomplete="{{ $isEdit ? 'new-password' : 'new-password' }}"
                        />

                        <x-admin.input
                            type="password"
                            name="password_confirmation"
                            label="Konfirmasi Password"
                            :required="!$isEdit"
                            autocomplete="new-password"
                        />
                    </div>
                </div>
            </x-admin.card>

            <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                <x-admin.button type="submit" variant="primary" class="sm:w-auto w-full justify-center">
                    {{ $isEdit ? 'Simpan Perubahan' : 'Tambah Pengguna' }}
                </x-admin.button>
                <x-admin.button href="{{ route('admin.users.index') }}" variant="secondary" class="sm:w-auto w-full justify-center">
                    Batal
                </x-admin.button>
            </div>
        </div>

        <div class="space-y-6">
            <x-admin.card title="Ringkasan" subtitle="Gambaran singkat konfigurasi akun" accent="sky">
                <div class="space-y-4">
                    <div class="flex items-center justify-between gap-3">
                        <div class="text-[13px] text-slate-500 dark:text-slate-400">Status</div>
                        <x-admin.badge :variant="$isActive ? 'success' : 'secondary'">
                            {{ $isActive ? 'Aktif' : 'Nonaktif' }}
                        </x-admin.badge>
                    </div>

                    <div class="flex items-center justify-between gap-3">
                        <div class="text-[13px] text-slate-500 dark:text-slate-400">Role</div>
                        <div class="text-[13px] font-semibold text-slate-800 dark:text-slate-200 text-right"
                            x-text="roles[roleId]?.display_name || '{{ $selectedRole?->display_name ?? '-' }}'"
                        ></div>
                    </div>

                    @if($isEdit)
                        <div class="pt-4 border-t border-slate-100/80 dark:border-slate-800/80 space-y-2">
                            <div class="flex items-center justify-between gap-3">
                                <div class="text-[13px] text-slate-500 dark:text-slate-400">Dibuat</div>
                                <div class="text-[13px] font-medium text-slate-700 dark:text-slate-300">
                                    {{ $user->created_at?->locale('id')->translatedFormat('d M Y H:i') ?? '-' }}
                                </div>
                            </div>
                            <div class="flex items-center justify-between gap-3">
                                <div class="text-[13px] text-slate-500 dark:text-slate-400">Diperbarui</div>
                                <div class="text-[13px] font-medium text-slate-700 dark:text-slate-300">
                                    {{ $user->updated_at?->locale('id')->translatedFormat('d M Y H:i') ?? '-' }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </x-admin.card>

            <x-admin.card title="Catatan" subtitle="Praktik terbaik untuk keamanan akun" accent="gold">
                <div class="space-y-3 text-[13px] text-slate-600 dark:text-slate-400 leading-relaxed">
                    <div class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 3h.01M12 21a9 9 0 100-18 9 9 0 000 18z"/>
                        </svg>
                        <span>Gunakan email yang valid karena dipakai untuk login dan notifikasi.</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <span>Berikan role minimum yang dibutuhkan. Akses lebih tinggi meningkatkan risiko.</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 01.88 7.903A5 5 0 1115 10a4 4 0 011 7.903M12 11v6m0 0l-3-3m3 3l3-3"/>
                        </svg>
                        <span>Nonaktifkan akun jika akses tidak lagi diperlukan.</span>
                    </div>
                </div>
            </x-admin.card>
        </div>
    </form>
</div>
@endsection
