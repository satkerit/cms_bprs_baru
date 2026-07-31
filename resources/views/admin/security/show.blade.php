@extends('admin.layouts.app')

@section('title', 'Detail Ancaman')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
 {{-- Header --}}
 <div class="flex items-center gap-4">
 <a href="{{ route('admin.security-monitor.index') }}"
 class="p-2 dark:text-slate-400 dark:text-slate-400 text-zinc-500 bg-white rounded-xl border">
 <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
 </svg>
 </a>
 <div>
 <h1 class="text-3xl font-bold dark:text-slate-100 dark:text-slate-100 text-zinc-900">Detail Ancaman #{{ $securityLog->id }}</h1>
 <p class="text-[13px] dark:text-slate-400 dark:text-slate-400 text-zinc-500">
 {{ $securityLog->created_at->format('d F Y, H:i:s') }}
 </p>
 </div>
 </div>

 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
 {{-- Main Info --}}
 <div class="lg:col-span-2 col-span-1 space-y-6">
 {{-- Threat Type Card --}}
 <div class="bg-white rounded-xl border p-6">
 <div class="flex items-start justify-between">
 <div>
 <span class="text-[11px] dark:text-slate-400 dark:text-slate-400 text-zinc-500">Tipe Ancaman</span>
 <h2 class="text-2xl font-bold dark:text-slate-100 dark:text-slate-100 text-zinc-900 mt-1">
 {{ $securityLog->getThreatInfo()['label'] }}
 </h2>
 </div>
 <span class="px-3 py-1 text-[11px] rounded-lg {{ $securityLog->getThreatBadgeClass() }}">
 {{ \App\Models\SecurityLog::THREAT_LEVELS[$securityLog->threat_level]['label'] ?? $securityLog->threat_level }}
 </span>
 </div>

 @if($securityLog->was_blocked)
 <div class="mt-4 p-3 bg-red-100 border border-red-200 rounded-xl">
 <div class="flex items-center gap-2 text-red-600">
 <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
 </svg>
 <span class="font-medium">IP ini telah diblokir</span>
 </div>
 </div>
 @endif
 </div>

 {{-- Request Details --}}
 <div class="bg-white rounded-xl border p-6">
 <h3 class="text-xl font-semibold dark:text-slate-100 dark:text-slate-100 text-zinc-900 mb-4">Detail Request</h3>
 <dl class="space-y-4">
 <div>
 <dt class="text-[11px] font-medium dark:text-slate-400 dark:text-slate-400 text-zinc-500">Method & URL</dt>
 <dd class="mt-1 text-[13px] dark:text-slate-100 dark:text-slate-100 text-zinc-900 font-mono dark:bg-slate-800/50 dark:bg-slate-800/50 bg-zinc-50 p-3 rounded-xl">
 <span class="inline-block px-2 py-0.5 bg-sky-100 text-sky-700 rounded mr-2">{{ $securityLog->request_method }}</span>
 {{ $securityLog->request_url }}
 </dd>
 </div>
 <div>
 <dt class="text-[11px] font-medium dark:text-slate-400 dark:text-slate-400 text-zinc-500">User Agent</dt>
 <dd class="mt-1 text-[13px] dark:text-slate-100 dark:text-slate-100 text-zinc-900 font-mono dark:bg-slate-800/50 dark:bg-slate-800/50 bg-zinc-50 p-3 rounded-xl">
 {{ $securityLog->user_agent ?? '-' }}
 </dd>
 </div>
 </dl>
 </div>

 {{-- Matched Pattern --}}
 @if($securityLog->matched_pattern)
 <div class="bg-white rounded-xl border p-6">
 <h3 class="text-xl font-semibold dark:text-slate-100 dark:text-slate-100 text-zinc-900 mb-4">Pola yang Terdeteksi</h3>
 <div class="bg-amber-100 border border-amber-200 rounded-xl p-4">
 <code class="text-[13px] text-yellow-800">{{ $securityLog->matched_pattern }}</code>
 </div>
 </div>
 @endif

 {{-- Raw Input --}}
 @if($securityLog->raw_input)
 <div class="bg-white rounded-xl border p-6">
 <h3 class="text-xl font-semibold dark:text-slate-100 dark:text-slate-100 text-zinc-900 mb-4">Input yang Mencurigakan</h3>
 <div class="bg-red-100 border border-red-200 rounded-xl p-4">
 <pre class="text-[13px] text-red-600">{{ $securityLog->raw_input }}</pre>
 </div>
 </div>
 @endif

 {{-- Payload --}}
 @if($securityLog->payload)
 <div class="bg-white rounded-xl border p-6">
 <h3 class="text-xl font-semibold dark:text-slate-100 dark:text-slate-100 text-zinc-900 mb-4">Request Payload</h3>
 <div class="dark:bg-slate-800/50 dark:bg-slate-800/50 bg-zinc-50 rounded-xl p-4">
 <pre class="text-[13px] dark:text-slate-100 dark:text-slate-100 text-zinc-900">{{ json_encode($securityLog->payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
 </div>
 </div>
 @endif
 </div>

 {{-- Sidebar --}}
 <div class="space-y-6">
 {{-- IP Info --}}
 <div class="bg-white rounded-xl border p-6">
 <h3 class="text-xl font-semibold dark:text-slate-100 dark:text-slate-100 text-zinc-900 mb-4">Informasi IP</h3>
 <dl class="space-y-3">
 <div>
 <dt class="text-[11px] font-medium dark:text-slate-400 dark:text-slate-400 text-zinc-500">IP Address</dt>
 <dd class="mt-1 font-mono dark:text-slate-100 dark:text-slate-100 text-zinc-900">{{ $securityLog->ip_address }}</dd>
 </div>
 @if($securityLog->country_code)
 <div>
 <dt class="text-[11px] font-medium dark:text-slate-400 dark:text-slate-400 text-zinc-500">Negara</dt>
 <dd class="mt-1 dark:text-slate-100 dark:text-slate-100 text-zinc-900">{{ $securityLog->country_code }}</dd>
 </div>
 @endif
 @if($securityLog->user)
 <div>
 <dt class="text-[11px] font-medium dark:text-slate-400 dark:text-slate-400 text-zinc-500">User</dt>
 <dd class="mt-1 dark:text-slate-100 dark:text-slate-100 text-zinc-900">{{ $securityLog->user->name }}</dd>
 </div>
 @endif
 </dl>

 <div class="mt-4 pt-4 border-t">
 @if(\App\Models\BlockedIp::isBlocked($securityLog->ip_address))
 <button data-action="unblock-ip" data-ip="{{ $securityLog->ip_address }}"
 class="w-full px-4 py-2 text-[11px] font-medium text-amber-700 bg-amber-50 rounded-xl">
 Buka Blokir IP
 </button>
 @else
 <button data-action="block-this-ip"
 class="w-full px-4 py-2 text-[11px] font-medium text-red-600 bg-red-100 rounded-xl">
 Blokir IP Ini
 </button>
 @endif
 </div>
 </div>

 {{-- Related Threats --}}
 @if($relatedThreats->count() > 0)
 <div class="bg-white rounded-xl border p-6">
 <h3 class="text-xl font-semibold dark:text-slate-100 dark:text-slate-100 text-zinc-900 mb-4">
 Ancaman Lain dari IP Ini
 <span class="text-[11px] font-normal dark:text-slate-400 dark:text-slate-400 text-zinc-500">({{ \Illuminate\Support\Facades\Cache::remember('sec_log_ip_' . $securityLog->ip_address, 300, fn() => \App\Models\SecurityLog::where('ip_address', $securityLog->ip_address)->count()) }} total)</span>
 </h3>
 <div class="space-y-2">
 @foreach($relatedThreats as $related)
 <a href="{{ route('admin.security-monitor.show', $related) }}"
 class="block p-3 dark:bg-slate-800/50 dark:bg-slate-800/50 bg-zinc-50 rounded-xl">
 <div class="flex items-center justify-between">
 <span class="text-[13px] dark:text-slate-100 dark:text-slate-100 text-zinc-900">{{ $related->getThreatInfo()['label'] }}</span>
 <span class="px-2 py-0.5 text-[11px] rounded-lg {{ $related->getThreatBadgeClass() }}">
 {{ \App\Models\SecurityLog::THREAT_LEVELS[$related->threat_level]['label'] ?? $related->threat_level }}
 </span>
 </div>
 <p class="text-[11px] dark:text-slate-400 dark:text-slate-400 text-zinc-500 mt-1">
 {{ $related->created_at->diffForHumans() }}
 </p>
 </a>
 @endforeach
 </div>
 </div>
 @endif
 </div>
 </div>
</div>

@push('scripts')
<script nonce="{{ $nonce }}">
document.addEventListener('DOMContentLoaded', function() {
 document.querySelectorAll('[data-action="block-this-ip"]').forEach(function(btn) {
 btn.addEventListener('click', async function() {
 const reason = prompt('Alasan pemblokiran (opsional):');
 try {
 const response = await fetch('{{ route("admin.security-monitor.block-ip") }}', {
 method: 'POST',
 headers: {
 'X-CSRF-TOKEN': '{{ csrf_token() }}',
 'Accept': 'application/json',
 'Content-Type': 'application/json',
 },
 body: JSON.stringify({
 ip_address: '{{ $securityLog->ip_address }}',
 reason: reason || 'Blocked from threat detail page',
 duration: 24,
 permanent: false,
 }),
 });
 const result = await response.json();
 if (result.success) {
 alert(result.message);
 location.reload();
 } else {
 alert(result.message || 'Gagal memblokir IP');
 }
 } catch (error) {
 alert('Terjadi kesalahan: ' + error.message);
 }
 });
 });

 document.querySelectorAll('[data-action="unblock-ip"]').forEach(function(btn) {
 btn.addEventListener('click', async function() {
 const ip = this.getAttribute('data-ip');
 if (!confirm('Yakin ingin membuka blokir IP ' + ip + '?')) return;
 try {
 const response = await fetch('{{ url("admin/security-monitor/unblock") }}/' + ip, {
 method: 'DELETE',
 headers: {
 'X-CSRF-TOKEN': '{{ csrf_token() }}',
 'Accept': 'application/json',
 },
 });
 const result = await response.json();
 if (result.success) {
 alert(result.message);
 location.reload();
 } else {
 alert(result.message || 'Gagal membuka blokir IP');
 }
 } catch (error) {
 alert('Terjadi kesalahan: ' + error.message);
 }
 });
 });
});
</script>
@endpush
@endsection