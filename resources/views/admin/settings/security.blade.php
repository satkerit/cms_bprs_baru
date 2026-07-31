@extends('layouts.admin')

@section('title', 'Pengaturan Keamanan')

@section('content')
<x-admin.page-header title="Pengaturan Keamanan" subtitle="Kelola pengaturan keamanan website">
 <x-slot:actions>
 <x-admin.button href="{{ route('admin.settings.blocked-ips') }}" variant="secondary">
 <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
 </svg>
 Kelola IP Terblokir
 </x-admin.button>
 </x-slot:actions>
</x-admin.page-header>

@if(session('success'))  <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg">
 {{ session('success') }}
</div>
@endif

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
 <div class="bg-white rounded-xl border dark:border-slate-700 border-zinc-200 p-6 shadow-sm">
 <div class="flex items-center justify-between">
 <div>
 <p class="text-[11px] dark:text-slate-400 text-zinc-500 mb-1">Total IP Terblokir</p>
 <p class="text-3xl font-bold dark:text-slate-100 text-zinc-900">{{ $blockedIpsCount }}</p>
 </div>
 <span class="inline-flex items-center justify-center rounded-xl w-12 h-12 bg-red-100">
 <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
 </svg>
 </span>
 </div>
 </div>

 <div class="bg-white rounded-xl border dark:border-slate-700 border-zinc-200 p-6 shadow-sm">
 <div class="flex items-center justify-between">
 <div>
 <p class="text-[11px] dark:text-slate-400 text-zinc-500 mb-1">Blokir Permanen</p>
 <p class="text-3xl font-bold dark:text-slate-100 text-zinc-900">{{ $permanentBlocksCount }}</p>
 </div>
 <span class="inline-flex items-center justify-center rounded-xl w-12 h-12 bg-emerald-100">
        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
 </svg>
 </span>
 </div>
 </div>

 <div class="bg-white rounded-xl border dark:border-slate-700 border-zinc-200 p-6 shadow-sm">
 <div class="flex items-center justify-between">
 <div>
 <p class="text-[11px] dark:text-slate-400 text-zinc-500 mb-1">Blokir Sementara</p>
 <p class="text-3xl font-bold dark:text-slate-100 text-zinc-900">{{ $temporaryBlocksCount }}</p>
 </div>
 <span class="inline-flex items-center justify-center rounded-xl w-12 h-12 bg-blue-100">
 <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
 </svg>
 </span>
 </div>
 </div>
</div>

<form action="{{ route('admin.settings.security.update') }}" method="POST">
 @csrf
 @method('PUT')

 <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
 <!-- Rate Limiting Settings -->
 <x-admin.card>
 <div class="mb-6">
 <h3 class="text-lg font-bold dark:text-slate-100 text-zinc-900 mb-2">Rate Limiting</h3>
 <p class="text-[11px] dark:text-slate-400 text-zinc-500">Batasi jumlah request untuk mencegah abuse</p>
 </div>

 <div class="space-y-4">
 <div>
 <label class="block mb-2 text-[11px] font-semibold text-zinc-600">
 Web (requests/minute)
 </label>
 <input type="number" name="rate_limit_web" value="{{ old('rate_limit_web', $settings->rate_limit_web) }}"
 min="10" max="1000" required
 class="w-full rounded-xl border border-zinc-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
 <p class="text-[11px] dark:text-slate-400 text-zinc-500 mt-1">Jumlah maksimal request per menit untuk halaman publik</p>
 @error('rate_limit_web')
 <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p>
 @enderror
 </div>

 <div>
 <label class="block mb-2 text-[11px] font-semibold text-zinc-600">
 Admin (requests/minute)
 </label>
 <input type="number" name="rate_limit_admin" value="{{ old('rate_limit_admin', $settings->rate_limit_admin) }}"
 min="10" max="500" required
 class="w-full rounded-xl border border-zinc-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
 <p class="text-[11px] dark:text-slate-400 text-zinc-500 mt-1">Jumlah maksimal request per menit untuk halaman admin</p>
 @error('rate_limit_admin')
 <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p>
 @enderror
 </div>

 <div>
 <label class="block mb-2 text-[11px] font-semibold text-zinc-600">
 Login (attempts/minute)
 </label>
 <input type="number" name="rate_limit_login" value="{{ old('rate_limit_login', $settings->rate_limit_login) }}"
 min="1" max="20" required
 class="w-full rounded-xl border border-zinc-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
 <p class="text-[11px] dark:text-slate-400 text-zinc-500 mt-1">Jumlah maksimal percobaan login per menit</p>
 @error('rate_limit_login')
 <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p>
 @enderror
 </div>

 <div>
 <label class="block mb-2 text-[11px] font-semibold text-zinc-600">
 Password Reset (attempts/minute)
 </label>
 <input type="number" name="rate_limit_password_reset" value="{{ old('rate_limit_password_reset', $settings->rate_limit_password_reset) }}"
 min="1" max="10" required
 class="w-full rounded-xl border border-zinc-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
 <p class="text-[11px] dark:text-slate-400 text-zinc-500 mt-1">Jumlah maksimal request reset password per menit</p>
 @error('rate_limit_password_reset')
 <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p>
 @enderror
 </div>

 <div>
 <label class="block mb-2 text-[11px] font-semibold text-zinc-600">
 Download (requests/minute)
 </label>
 <input type="number" name="rate_limit_download" value="{{ old('rate_limit_download', $settings->rate_limit_download) }}"
 min="5" max="100" required
 class="w-full rounded-xl border border-zinc-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
 <p class="text-[11px] dark:text-slate-400 text-zinc-500 mt-1">Jumlah maksimal download per menit</p>
 @error('rate_limit_download')
 <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p>
 @enderror
 </div>
 </div>
 </x-admin.card>

 <!-- IP Blocking Settings -->
 <x-admin.card>
 <div class="mb-6">
 <h3 class="text-lg font-bold dark:text-slate-100 text-zinc-900 mb-2">IP Blocking</h3>
 <p class="text-[11px] dark:text-slate-400 text-zinc-500">Kelola pemblokiran IP otomatis</p>
 </div>

 <div class="space-y-4">
 <div>
 <label class="block mb-2 text-[11px] font-semibold text-zinc-600">
 Block Threshold (failed attempts)
 </label>
 <input type="number" name="block_threshold" value="{{ old('block_threshold', $settings->block_threshold) }}"
 min="3" max="50" required
 class="w-full rounded-xl border border-zinc-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
 <p class="text-[11px] dark:text-slate-400 text-zinc-500 mt-1">Jumlah percobaan gagal sebelum IP diblokir</p>
 @error('block_threshold')
 <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p>
 @enderror
 </div>

 <div>
 <label class="block mb-2 text-[11px] font-semibold text-zinc-600">
 Block Duration (hours)
 </label>
 <input type="number" name="block_duration_hours" value="{{ old('block_duration_hours', $settings->block_duration_hours) }}"
 min="1" max="168" required
 class="w-full rounded-xl border border-zinc-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
 <p class="text-[11px] dark:text-slate-400 text-zinc-500 mt-1">Durasi pemblokiran otomatis (1-168 jam / 1-7 hari)</p>
 @error('block_duration_hours')
 <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p>
 @enderror
 </div>

 <div>
 <label class="block mb-2 text-[11px] font-semibold text-zinc-600">
 IP Whitelist
 </label>
 <textarea name="ip_whitelist" rows="5"
 class="w-full rounded-xl border border-zinc-300 px-4 py-3 font-mono text-[11px] focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
 placeholder="Satu IP per baris&#10;192.168.1.1&#10;10.0.0.1">{{ old('ip_whitelist', $settings->ip_whitelist) }}</textarea>
 <p class="text-[11px] dark:text-slate-400 text-zinc-500 mt-1">IP yang tidak akan pernah diblokir (satu per baris)</p>
 @error('ip_whitelist')
 <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p>
 @enderror
 </div>

 <div>
 <label class="block mb-2 text-[11px] font-semibold text-zinc-600">
 IP Blacklist
 </label>
 <textarea name="ip_blacklist" rows="5"
 class="w-full rounded-xl border border-zinc-300 px-4 py-3 font-mono text-[11px] focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
 placeholder="Satu IP per baris&#10;192.168.1.100&#10;10.0.0.100">{{ old('ip_blacklist', $settings->ip_blacklist) }}</textarea>
 <p class="text-[11px] dark:text-slate-400 text-zinc-500 mt-1">IP yang selalu diblokir (satu per baris)</p>
 @error('ip_blacklist')
 <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p>
 @enderror
 </div>
 </div>
 </x-admin.card>
 </div>

 <!-- Security Features -->
 <x-admin.card class="mt-6">
 <div class="mb-6">
 <h3 class="text-lg font-bold dark:text-slate-100 text-zinc-900 mb-2">Fitur Keamanan</h3>
 <p class="text-[11px] dark:text-slate-400 text-zinc-500">Aktifkan atau nonaktifkan fitur keamanan</p>
 </div>

 <div class="space-y-4">
 <div class="flex items-start">
 <div class="flex items-center h-5">
 <input type="checkbox" name="enable_suspicious_blocking" id="enable_suspicious_blocking" value="1"
 {{ old('enable_suspicious_blocking', $settings->enable_suspicious_blocking) ? 'checked' : '' }}
 class="rounded border-zinc-300 text-emerald-600 focus:ring-emerald-500">
 </div>
 <div class="ml-3">
 <label for="enable_suspicious_blocking" class="font-medium dark:text-slate-100 text-zinc-900">
 Enable Suspicious Request Blocking
 </label>
 <p class="text-[11px] dark:text-slate-400 text-zinc-500">Blokir otomatis request yang mencurigakan (SQL injection, XSS, dll)</p>
 </div>
 </div>

 <div class="flex items-start">
 <div class="flex items-center h-5">
 <input type="checkbox" name="enable_rate_limiting" id="enable_rate_limiting" value="1"
 {{ old('enable_rate_limiting', $settings->enable_rate_limiting) ? 'checked' : '' }}
 class="rounded border-zinc-300 text-emerald-600 focus:ring-emerald-500">
 </div>
 <div class="ml-3">
 <label for="enable_rate_limiting" class="font-medium dark:text-slate-100 text-zinc-900">
 Enable Rate Limiting
 </label>
 <p class="text-[11px] dark:text-slate-400 text-zinc-500">Aktifkan pembatasan jumlah request</p>
 </div>
 </div>

 <div class="flex items-start">
 <div class="flex items-center h-5">
 <input type="checkbox" name="log_security_events" id="log_security_events" value="1"
 {{ old('log_security_events', $settings->log_security_events) ? 'checked' : '' }}
 class="rounded border-zinc-300 text-emerald-600 focus:ring-emerald-500">
 </div>
 <div class="ml-3">
 <label for="log_security_events" class="font-medium dark:text-slate-100 text-zinc-900">
 Log Security Events
 </label>
 <p class="text-[11px] dark:text-slate-400 text-zinc-500">Catat semua event keamanan ke log file</p>
 </div>
 </div>
 </div>
 </x-admin.card>

 <!-- Session Management Settings -->
 <x-admin.card class="mt-6">
 <div class="mb-6">
 <h3 class="text-lg font-bold dark:text-slate-100 text-zinc-900 mb-2">Manajemen Sesi Admin</h3>
 <p class="text-[11px] dark:text-slate-400 text-zinc-500">Atur pengaturan sesi dan idle timeout untuk admin</p>
 </div>

 <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
 <div>
 <label class="block mb-2 text-[11px] font-semibold text-zinc-600">
 Session Lifetime (menit)
 </label>
 <input type="number" name="session_lifetime" value="{{ old('session_lifetime', $settings->session_lifetime) }}"
 min="30" max="1440" required
 class="w-full rounded-xl border border-zinc-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
 <p class="text-[11px] dark:text-slate-400 text-zinc-500 mt-1">Durasi maksimal sesi (30-1440 menit / 0.5-24 jam)</p>
 @error('session_lifetime')
 <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p>
 @enderror
 </div>

 <div>
 <label class="block mb-2 text-[11px] font-semibold text-zinc-600">
 Idle Timeout (menit)
 </label>
 <input type="number" name="idle_timeout" value="{{ old('idle_timeout', $settings->idle_timeout) }}"
 min="5" max="480" required
 class="w-full rounded-xl border border-zinc-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
 <p class="text-[11px] dark:text-slate-400 text-zinc-500 mt-1">Waktu idle sebelum auto logout (5-480 menit / 5 menit - 8 jam)</p>
 @error('idle_timeout')
 <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p>
 @enderror
 </div>

 <div>
 <label class="block mb-2 text-[11px] font-semibold text-zinc-600">
 Idle Warning (menit)
 </label>
 <input type="number" name="idle_warning" value="{{ old('idle_warning', $settings->idle_warning) }}"
 min="1" max="60" required
 class="w-full rounded-xl border border-zinc-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
 <p class="text-[11px] dark:text-slate-400 text-zinc-500 mt-1">Waktu warning sebelum idle timeout (harus lebih kecil dari idle timeout)</p>
 @error('idle_warning')
 <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p>
 @enderror
 </div>
 </div>

 <div class="flex items-center pt-6">
 <div class="flex items-center h-5">
 <input type="checkbox" name="auto_extend_session" id="auto_extend_session" value="1"
 {{ old('auto_extend_session', $settings->auto_extend_session) ? 'checked' : '' }}
 class="rounded border-zinc-300 text-emerald-600 focus:ring-emerald-500">
 </div>
 <div class="ml-3">
 <label for="auto_extend_session" class="font-medium dark:text-slate-100 text-zinc-900">
 Auto Extend Session
 </label>
 <p class="text-[11px] dark:text-slate-400 text-zinc-500">Perpanjang sesi otomatis saat ada aktivitas user</p>
 </div>
 </div>

 <div class="flex items-start mt-6">
 <div class="flex items-center h-5">
 <input type="checkbox" name="enable_session_tracking" id="enable_session_tracking" value="1"
 {{ old('enable_session_tracking', $settings->enable_session_tracking) ? 'checked' : '' }}
 class="rounded border-zinc-300 text-emerald-600 focus:ring-emerald-500">
 </div>
 <div class="ml-3">
 <label for="enable_session_tracking" class="font-medium dark:text-slate-100 text-zinc-900">
 Enable Session Tracking
 </label>
 <p class="text-[11px] dark:text-slate-400 text-zinc-500">Aktifkan pelacakan aktivitas sesi untuk keamanan</p>
 </div>
 </div>
 </x-admin.card>

 <!-- Submit Button -->
 <div class="mt-6 flex gap-3">
 <x-admin.button type="submit">
 Simpan Pengaturan
 </x-admin.button>
 <x-admin.button href="{{ route('admin.dashboard') }}" variant="secondary">
 Batal
 </x-admin.button>
 </div>
</form>

<!-- Recent Blocked IPs -->
@if($recentBlocks->count() > 0)
<x-admin.card class="mt-6">
 <div class="mb-6">
 <h3 class="text-lg font-bold dark:text-slate-100 text-zinc-900 mb-2">IP Terblokir Terbaru</h3>
 <p class="text-[11px] dark:text-slate-400 text-zinc-500">10 IP yang baru saja diblokir</p>
 </div>

 <div class="overflow-x-auto">
 <table class="w-full border-collapse">
 <thead>
 <tr class="border-b dark:border-slate-700 border-zinc-200/70 dark:bg-slate-800/50 bg-zinc-50/80">
 <th class="pl-5 pr-4 py-3.5 text-left text-[11px] font-semibold dark:text-slate-400 text-zinc-500 uppercase tracking-[0.05em]">IP Address</th>
 <th class="px-5 py-3.5 text-left text-[11px] font-semibold dark:text-slate-400 text-zinc-500 uppercase tracking-[0.05em]">Reason</th>
 <th class="px-5 py-3.5 text-left text-[11px] font-semibold dark:text-slate-400 text-zinc-500 uppercase tracking-[0.05em]">Attempts</th>
 <th class="px-5 py-3.5 text-left text-[11px] font-semibold dark:text-slate-400 text-zinc-500 uppercase tracking-[0.05em]">Blocked Until</th>
 <th class="pl-4 pr-5 py-3.5 text-left text-[11px] font-semibold dark:text-slate-400 text-zinc-500 uppercase tracking-[0.05em]">Type</th>
 </tr>
 </thead>
 <tbody class="divide-y divide-zinc-100/80">
 @foreach($recentBlocks as $block)
 <tr class="table-row-hover">
 <td class="pl-5 pr-4 py-3.5">
 <span class="table-cell-mono">{{ $block->ip_address }}</span>
 </td>
 <td class="px-5 py-3.5 table-cell-secondary">
 {{ $block->reason ?? '-' }}
 </td>
 <td class="px-5 py-3.5">
 <span class="table-cell-text">{{ $block->attempts }}</span>
 </td>
 <td class="px-5 py-3.5">
 @if($block->is_permanent)
 <span class="text-[12px] font-semibold text-red-600">Permanent</span>
 @else
 <span class="table-cell-secondary">{{ $block->blocked_until ? $block->blocked_until->format('d M Y H:i') : '-' }}</span>
 @endif
 </td>
 <td class="pl-4 pr-5 py-3.5">
 @if($block->is_permanent)
 <x-admin.badge variant="destructive">Permanent</x-admin.badge>
 @else
 <x-admin.badge variant="warning">Temporary</x-admin.badge>
 @endif
 </td>
 </tr>
 @endforeach
 </tbody>
 </table>
 </div>

 <div class="mt-4">
 <a href="{{ route('admin.settings.blocked-ips') }}" class="text-[11px] text-blue-600 font-medium hover:text-blue-700">
 Lihat Semua IP Terblokir â†’
 </a>
 </div>
</x-admin.card>
@endif
@endsection
