@extends('layouts.admin')

@section('title', 'Pengaturan Email / SMTP')

@section('content')
<x-admin.page-header title="Pengaturan Email / SMTP" subtitle="Konfigurasi pengiriman email untuk sistem"/>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
 {{-- Main Settings Form --}}
 <div class="lg:col-span-2 col-span-1">
 <form action="{{ route('admin.settings.email.update') }}" method="POST">
 @csrf
 @method('PUT')

 <div class="space-y-6">
 {{-- Mail Driver --}}
 <x-admin.card title="Driver Email">
 <div class="space-y-4">
 <div>
 <label class="block text-xs font-medium text-gray-700 mb-1">Mail Driver <span class="text-red-600">*</span></label>
 <select name="mailer" id="mailer" class="block w-full rounded-xl border-0 py-2.5 px-4 text-gray-900 bg-gray-50">
 @foreach($mailers as $value => $label)
 <option value="{{ $value }}" {{ old('mailer', $settings->mailer ?? 'smtp') == $value ? 'selected' : '' }}>{{ $label }}</option>
 @endforeach
 </select>
 <p class="mt-1 text-xs text-gray-500">Pilih metode pengiriman email</p>
 </div>
 </div>
 </x-admin.card>

 {{-- SMTP Settings --}}
 <x-admin.card title="Konfigurasi SMTP" id="smtp-settings">
 <div class="space-y-4">
 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
 <x-admin.input name="host" label="SMTP Host" :value="old('host', $settings->host ?? '')" placeholder="smtp.gmail.com" hint="Alamat server SMTP"/>
 <x-admin.input type="number" name="port" label="Port" :value="old('port', $settings->port ?? 587)" placeholder="587" hint="Port SMTP (587 untuk TLS, 465 untuk SSL)"/>
 </div>

 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
 <x-admin.input name="username" label="Username" :value="old('username', $settings->username ?? '')" placeholder="email@domain.com" hint="Username untuk autentikasi SMTP" autocomplete="username"/>
 <div>
 <label class="block text-xs font-medium text-gray-700 mb-1">Password</label>
 <input type="password"
 name="password"
 autocomplete="current-password"
 class="block w-full rounded-xl border-0 py-2.5 px-4 text-gray-900 bg-gray-50"
 placeholder="{{ $settings && $settings->hasPassword() ? '••••••••' : 'Masukkan password' }}">
 <p class="mt-1 text-xs text-gray-500">
 @if($settings && $settings->hasPassword())
 Kosongkan jika tidak ingin mengubah password
 @else
 Password untuk autentikasi SMTP
 @endif
 </p>
 </div>
 </div>

 <div>
 <label class="block text-xs font-medium text-gray-700 mb-1">Enkripsi</label>
 <select name="encryption" class="block w-full rounded-xl border-0 py-2.5 px-4 text-gray-900 bg-gray-50">
 @foreach($encryptions as $value => $label)
 <option value="{{ $value }}" {{ old('encryption', $settings->encryption ?? 'tls') == $value ? 'selected' : '' }}>{{ $label }}</option>
 @endforeach
 </select>
 <p class="mt-1 text-xs text-gray-500">TLS direkomendasikan untuk keamanan</p>
 </div>
 </div>
 </x-admin.card>

 {{-- From Settings --}}
 <x-admin.card title="Pengirim Email">
 <div class="space-y-4">
 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
 <x-admin.input type="email" name="from_address" label="Email Pengirim" :value="old('from_address', $settings->from_address ?? '')" placeholder="noreply@domain.com" required hint="Alamat email yang akan muncul sebagai pengirim"/>
 <x-admin.input name="from_name" label="Nama Pengirim" :value="old('from_name', $settings->from_name ?? config('app.name'))" placeholder="Nama Perusahaan" required hint="Nama yang akan muncul sebagai pengirim"/>
 </div>

 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
 <x-admin.input type="email" name="reply_to_address" label="Reply-To Email" :value="old('reply_to_address', $settings->reply_to_address ?? '')" placeholder="support@domain.com" hint="Email untuk balasan (opsional)"/>
 <x-admin.input name="reply_to_name" label="Reply-To Name" :value="old('reply_to_name', $settings->reply_to_name ?? '')" placeholder="Customer Support" hint="Nama untuk balasan (opsional)"/>
 </div>
 </div>
 </x-admin.card>

 {{-- Career Application Address --}}
 <x-admin.card title="Pengiriman Lamaran Karier">
 <div class="space-y-4">
 <p class="text-xs text-gray-500">Alamat yang ditampilkan di halaman detail lowongan karier sebagai tujuan pengiriman lamaran (fisik & email).</p>
 <x-admin.input type="email" name="career_recipient_email" label="Email Pengiriman Lamaran" :value="old('career_recipient_email', $settings->career_recipient_email ?? '')" placeholder="personalia@domain.com" hint="Alamat email tujuan kirim lamaran (opsional, default: personalia.bsbb@gmail.com)"/>
 <div>
 <label class="block text-xs font-medium text-gray-700 mb-1">Alamat Fisik Pengiriman Lamaran</label>
 <textarea name="career_recipient_address" rows="3" class="block w-full rounded-xl border-0 py-2.5 px-4 text-gray-900 bg-gray-50" placeholder="Contoh: TJ TOWER, Jl. Kampung Melayu, Bukit Merapin, Pangkalpinang">{{ old('career_recipient_address', $settings->career_recipient_address ?? '') }}</textarea>
 <p class="mt-1 text-xs text-gray-500">Alamat kantor untuk pengiriman lamaran fisik (opsional, default: alamat perusahaan di Profil Perusahaan)</p>
 </div>
 </div>
 </x-admin.card>

 <div class="flex justify-end">
 <x-admin.button type="submit">
 <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
 </svg>
 Simpan Pengaturan
 </x-admin.button>
 </div>
 </div>
 </form>
 </div>

 {{-- Sidebar --}}
 <div class="space-y-6">
 {{-- Test Email --}}
 <x-admin.card title="Test Email">
 <form action="{{ route('admin.settings.email.test') }}" method="POST">
 @csrf
 <div class="space-y-4">
 <p class="text-xs text-gray-700">Kirim email test untuk memastikan konfigurasi sudah benar.</p>

 <x-admin.input type="email" name="test_email" label="Email Tujuan" :value="auth()->user()->email" placeholder="test@example.com" required/>

 <x-admin.button type="submit" variant="secondary" class="w-full">
 <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
 </svg>
 Kirim Test Email
 </x-admin.button>
 </div>
 </form>
 </x-admin.card>

 {{-- Quick Guide --}}
 <x-admin.card title="Panduan Konfigurasi">
 <div class="space-y-4 text-xs">
 <div class="p-3 bg-sky-100 rounded-lg">
 <p class="font-medium text-sky-700 mb-1">Gmail SMTP</p>
 <ul class="text-sky-700 text-xs space-y-1">
 <li>Host: smtp.gmail.com</li>
 <li>Port: 587 (TLS) atau 465 (SSL)</li>
 <li>Username: email@gmail.com</li>
 <li>Password: App Password</li>
 </ul>
 </div>

 <div class="p-3 bg-sky-100 rounded-lg">
 <p class="font-medium text-sky-700 mb-1">Yahoo SMTP</p>
 <ul class="text-sky-700 text-xs space-y-1">
 <li>Host: smtp.mail.yahoo.com</li>
 <li>Port: 587 (TLS) atau 465 (SSL)</li>
 <li>Username: email@yahoo.com</li>
 <li>Password: App Password</li>
 </ul>
 </div>

 <div class="p-3 bg-amber-100 rounded-lg">
 <p class="font-medium text-amber-700 mb-1">Outlook/Office 365</p>
 <ul class="text-amber-700 text-xs space-y-1">
 <li>Host: smtp.office365.com</li>
 <li>Port: 587</li>
 <li>Encryption: TLS</li>
 </ul>
 </div>

 <div class="p-3 bg-gray-50 rounded-lg">
 <p class="font-medium text-gray-900 mb-1">Tips</p>
 <ul class="text-gray-700 text-xs space-y-1">
 <li>• Gunakan App Password untuk Gmail</li>
 <li>• Pastikan 2FA aktif di akun email</li>
 <li>• Port 587 + TLS paling umum</li>
 </ul>
 </div>
 </div>
 </x-admin.card>

 {{-- Current Status --}}
 <x-admin.card title="Status Konfigurasi">
 <div class="space-y-3">
 @if($settings && $settings->host)
 <div class="flex items-center gap-2 text-xs">
 <div class="w-2 h-2 rounded-full bg-sky-500"></div>
 <span class="text-gray-700">SMTP dikonfigurasi</span>
 </div>
 <div class="text-xs text-gray-500 space-y-1">
 <p>Driver: {{ $settings->mailer }}</p>
 <p>Host: {{ $settings->host }}:{{ $settings->port }}</p>
 <p>From: {{ $settings->from_address }}</p>
 </div>
 @else
 <div class="flex items-center gap-2 text-xs">
 <div class="w-2 h-2 rounded-full bg-amber-1000"></div>
 <span class="text-gray-700">Belum dikonfigurasi</span>
 </div>
 <p class="text-xs text-gray-500">Silakan isi konfigurasi SMTP untuk mengaktifkan pengiriman email.</p>
 @endif
 </div>
 </x-admin.card>
 </div>
</div>
@endsection
