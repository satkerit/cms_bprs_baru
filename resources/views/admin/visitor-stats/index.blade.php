@extends('layouts.admin')

@section('title', 'Statistik Pengunjung')

@section('content')
<x-admin.page-header title="Statistik Pengunjung" subtitle="Analisis data pengunjung website">
 <x-slot:actions>
 <form method="GET" class="flex items-center gap-2" x-data="{ period: '{{ $period }}' }">
 <div class="flex items-center gap-2">
 <select name="period" x-model="period" @change="period !== 'custom' ? $el.form.submit() : null"
 class="rounded-xl border-0 py-2 px-4 text-gray-900 bg-white focus:ring-2 text-xs">
 <option value="today">Hari Ini</option>
 <option value="7days">7 Hari Terakhir</option>
 <option value="30days">30 Hari Terakhir</option>
 <option value="90days">90 Hari Terakhir</option>
 <option value="this_month">Bulan Ini</option>
 <option value="last_month">Bulan Lalu</option>
 <option value="custom">Pilih Tanggal</option>
 </select>
 </div>

 <div x-show="period === 'custom'" class="flex items-center gap-2" x-transition style="display: none;">
 <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}"
 class="rounded-xl border-0 py-2 px-4 text-gray-900 bg-white focus:ring-2 text-xs">
 <span class="text-gray-400">-</span>
 <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}"
 class="rounded-xl border-0 py-2 px-4 text-gray-900 bg-white focus:ring-2 text-xs">
 <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-xl text-xs font-medium">
 Filter
 </button>
 </div>
 </form>
 </x-slot:actions>
</x-admin.page-header>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
 <div class="bg-white rounded-2xl border border-slate-100 p-6">
 <div class="flex items-center justify-between">
 <div>
 <p class="text-xs font-medium text-gray-500">Total Kunjungan</p>
 <p class="text-4xl font-bold text-gray-900 mt-1">{{ number_format($stats['total_visits']) }}</p>
 </div>
 <div class="w-12 h-12 bg-sky-100 rounded-xl flex items-center justify-center">
 <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
 </svg>
 </div>
 </div>
 </div>

 <div class="bg-white rounded-2xl border border-slate-100 p-6">
 <div class="flex items-center justify-between">
 <div>
 <p class="text-xs font-medium text-gray-500">Pengunjung Unik</p>
 <p class="text-4xl font-bold text-gray-900 mt-1">{{ number_format($stats['unique_visitors']) }}</p>
 </div>
 <div class="w-12 h-12 bg-sky-100 rounded-xl flex items-center justify-center">
 <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
 </svg>
 </div>
 </div>
 </div>

 <div class="bg-white rounded-2xl border border-slate-100 p-6">
 <div class="flex items-center justify-between">
 <div>
 <p class="text-xs font-medium text-gray-500">Kunjungan Hari Ini</p>
 <p class="text-4xl font-bold text-gray-900 mt-1">{{ number_format($stats['today_visits']) }}</p>
 </div>
 <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
 <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
 </svg>
 </div>
 </div>
 </div>

 <div class="bg-white rounded-2xl border border-slate-100 p-6">
 <div class="flex items-center justify-between">
 <div>
 <p class="text-xs font-medium text-gray-500">Unik Hari Ini</p>
 <p class="text-4xl font-bold text-gray-900 mt-1">{{ number_format($stats['today_unique']) }}</p>
 </div>
 <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
 <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
 </svg>
 </div>
 </div>
 </div>
</div>

<!-- Chart -->
<x-admin.card title="Grafik Kunjungan" class="mb-6">
 <div class="h-80">
 <canvas id="visitsChart"></canvas>
 </div>
</x-admin.card>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
 <!-- Top Pages -->
 <x-admin.card title="Halaman Populer" :noPadding="true">
 <div class="divide-slate-100">
 @forelse($topPages as $index => $page)
 <div class="px-6 py-3 flex items-center justify-between">
 <div class="flex items-center gap-3 min-w-0">
 <span class="shrink-0 w-6 h-6 rounded-full bg-gray-50 text-gray-700 text-xs font-medium flex items-center justify-center">
 {{ $index + 1 }}
 </span>
 <span class="text-xs text-gray-700" title="{{ $page->url }}">
 {{ Str::limit(parse_url($page->url, PHP_URL_PATH) ?: '/', 40) }}
 </span>
 </div>
 <span class="text-xs font-semibold text-gray-900">{{ number_format($page->visits) }}</span>
 </div>
 @empty
 <div class="px-6 py-8 text-center text-gray-500">Belum ada data</div>
 @endforelse
 </div>
 </x-admin.card>

 <!-- Countries -->
 <x-admin.card title="Negara Pengunjung" :noPadding="true">
 <div class="divide-slate-100">
 @forelse($countries as $country)
 <div class="px-6 py-3 flex items-center justify-between">
 <div class="flex items-center gap-3">
 <span class="text-3xl">🌍</span>
 <span class="text-xs text-gray-700">{{ $country->country }}</span>
 </div>
 <span class="text-xs font-semibold text-gray-900">{{ number_format($country->total) }}</span>
 </div>
 @empty
 <div class="px-6 py-8 text-center text-gray-500">Belum ada data</div>
 @endforelse
 </div>
 </x-admin.card>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
 <!-- Browsers -->
 <x-admin.card title="Browser">
 <div class="space-y-3">
 @forelse($browsers as $browser)
 @php
 $percentage = $stats['total_visits'] > 0 ? ($browser->total / $stats['total_visits']) * 100 : 0;
 @endphp
 <div>
 <div class="flex justify-between text-xs mb-1">
 <span class="text-gray-700">{{ $browser->browser }}</span>
 <span class="text-gray-500">{{ number_format($percentage, 1) }}%</span>
 </div>
 <div class="w-full bg-gray-50 rounded-full h-2">
 <div class="bg-sky-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
 </div>
 </div>
 @empty
 <p class="text-center text-gray-500 py-4">Belum ada data</p>
 @endforelse
 </div>
 </x-admin.card>

 <!-- Devices -->
 <x-admin.card title="Perangkat">
 <div class="space-y-3">
 @forelse($devices as $device)
 @php
 $percentage = $stats['total_visits'] > 0 ? ($device->total / $stats['total_visits']) * 100 : 0;
 $icon = match($device->device_type) {
 'mobile' => '📱',
 'tablet' => '📲',
 default => '💻'
 };
 @endphp
 <div>
 <div class="flex justify-between text-xs mb-1">
 <span class="text-gray-700">{{ $icon }} {{ ucfirst($device->device_type) }}</span>
 <span class="text-gray-500">{{ number_format($percentage, 1) }}%</span>
 </div>
 <div class="w-full bg-gray-50 rounded-full h-2">
 <div class="bg-sky-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
 </div>
 </div>
 @empty
 <p class="text-center text-gray-500 py-4">Belum ada data</p>
 @endforelse
 </div>
 </x-admin.card>

 <!-- Platforms -->
 <x-admin.card title="Sistem Operasi">
 <div class="space-y-3">
 @forelse($platforms as $platform)
 @php
 $percentage = $stats['total_visits'] > 0 ? ($platform->total / $stats['total_visits']) * 100 : 0;
 @endphp
 <div>
 <div class="flex justify-between text-xs mb-1">
 <span class="text-gray-700">{{ $platform->platform }}</span>
 <span class="text-gray-500">{{ number_format($percentage, 1) }}%</span>
 </div>
 <div class="w-full bg-gray-50 rounded-full h-2">
 <div class="bg-sky-500-light0 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
 </div>
 </div>
 @empty
 <p class="text-center text-gray-500 py-4">Belum ada data</p>
 @endforelse
 </div>
 </x-admin.card>
</div>

<!-- Recent Visitors -->
<x-admin.card title="Pengunjung Terbaru" :noPadding="true">
 <div >    <table class="w-full border-collapse">
 <thead>
 <tr class="border-b dark:border-slate-700 border-zinc-200/70 dark:bg-slate-800/50 dark:bg-slate-800/50 bg-zinc-50/80">
 <th class="pl-5 pr-4 py-3.5 text-left text-[11px] font-semibold dark:text-slate-400 dark:text-slate-400 text-zinc-500 uppercase tracking-[0.05em]">Waktu</th>
 <th class="px-5 py-3.5 text-left text-[11px] font-semibold dark:text-slate-400 dark:text-slate-400 text-zinc-500 uppercase tracking-[0.05em]">IP</th>
 <th class="px-5 py-3.5 text-left text-[11px] font-semibold dark:text-slate-400 dark:text-slate-400 text-zinc-500 uppercase tracking-[0.05em]">Lokasi</th>
 <th class="px-5 py-3.5 text-left text-[11px] font-semibold dark:text-slate-400 dark:text-slate-400 text-zinc-500 uppercase tracking-[0.05em]">Perangkat</th>
 <th class="px-5 py-3.5 text-left text-[11px] font-semibold dark:text-slate-400 dark:text-slate-400 text-zinc-500 uppercase tracking-[0.05em]">Browser</th>
 <th class="pl-4 pr-5 py-3.5 text-left text-[11px] font-semibold dark:text-slate-400 dark:text-slate-400 text-zinc-500 uppercase tracking-[0.05em]">Halaman</th>
 </tr>
 </thead>
 <tbody class="divide-y divide-zinc-100/80">
 @forelse($recentVisitors as $visitor)
 <tr class="table-row-hover">
 <td class="pl-5 pr-4 py-3.5">
 <div class="table-cell-text">{{ $visitor->created_at->format('d/m/Y') }}</div>
 <div class="table-cell-secondary">{{ $visitor->created_at->format('H:i:s') }}</div>
 </td>
 <td class="px-5 py-3.5">
 <span class="table-cell-mono">{{ $visitor->ip_address }}</span>
 </td>
 <td class="px-5 py-3.5">
 <div class="table-cell-text">{{ $visitor->city ?? '-' }}</div>
 <div class="table-cell-secondary">{{ $visitor->country ?? '-' }}</div>
 </td>
 <td class="px-5 py-3.5">
 <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-medium {{ $visitor->device_type == 'mobile' ? 'bg-sky-100 text-sky-700' : ($visitor->device_type == 'tablet' ? 'bg-purple-100 text-purple-700' : 'dark:bg-slate-800 dark:bg-slate-800 bg-zinc-100 dark:text-slate-300 dark:text-slate-300 text-zinc-600') }}">
 {{ ucfirst($visitor->device_type ?? 'Unknown') }}
 </span>
 </td>
 <td class="px-5 py-3.5">
 <div class="table-cell-text">{{ $visitor->browser ?? '-' }}</div>
 <div class="table-cell-secondary">{{ $visitor->platform ?? '-' }}</div>
 </td>
 <td class="pl-4 pr-5 py-3.5">
 <span class="table-cell-text block truncate max-w-[200px]" title="{{ $visitor->url }}">
 {{ Str::limit(parse_url($visitor->url, PHP_URL_PATH) ?: '/', 30) }}
 </span>
 </td>
 </tr>
 @empty
 <tr>
 <td colspan="6" class="px-5 py-10 text-center">
 <span class="table-cell-secondary">Belum ada data pengunjung</span>
 </td>
 </tr>
 @endforelse
 </tbody>
 </table>
 </div>
</x-admin.card>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js" crossorigin="anonymous" referrerpolicy="no-referrer" nonce="{{ $nonce }}"></script>
<script nonce="{{ $nonce }}">
document.addEventListener('DOMContentLoaded', function() {
 const canvas = document.getElementById('visitsChart');
 if (!canvas) return;

 const ctx = canvas.getContext('2d');
 const data = @js($visitsPerDay);

 new Chart(ctx, {
 type: 'line',
 data: {
 labels: data.map(d => d.date),
 datasets: [{
 label: 'Total Kunjungan',
 data: data.map(d => d.total),
 borderColor: '#3b82f6',
 backgroundColor: 'rgba(59, 130, 246, 0.1)',
 fill: true,
 tension: 0.3
 }, {
 label: 'Pengunjung Unik',
 data: data.map(d => d.unique_visitors),
 borderColor: '#10b981',
 backgroundColor: 'rgba(16, 185, 129, 0.1)',
 fill: true,
 tension: 0.3
 }]
 },
 options: {
 responsive: true,
 maintainAspectRatio: false,
 plugins: {
 legend: {
 position: 'bottom'
 }
 },
 scales: {
 y: {
 beginAtZero: true,
 ticks: {
 precision: 0
 }
 }
 }
 }
 });
});
</script>
@endpush
