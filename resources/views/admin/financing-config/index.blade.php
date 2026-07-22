@extends('layouts.admin')

@section('title', 'Konfigurasi Simulasi Pembiayaan')

@section('content')
<x-admin.page-header title="Konfigurasi Simulasi Pembiayaan" subtitle="Kelola parameter perhitungan simulasi pembiayaan">
 <x-slot:actions>
 <a href="{{ route('admin.financing-config.create') }}" class="inline-flex items-center px-4 py-2.5 text-[13px] font-semibold text-white bg-gradient-to-r from-emerald-600 to-emerald-500 rounded-xl shadow-emerald-600/30">
 <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
 </svg>
 Tambah Pembiayaan
 </a>
 </x-slot:actions>
</x-admin.page-header>

{{-- Info Card --}}
<div class="mb-6 p-4 bg-sky-100 border border-sky-200 rounded-xl">
 <div class="flex items-start gap-3">
 <div class="shrink-0">
 <svg class="w-5 h-5 text-sky-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
 </svg>
 </div>
 <div class="text-[13px] text-sky-700">
 <p class="font-medium mb-1">Tentang Simulasi Pembiayaan</p>
 <p class="text-sky-700">Konfigurasi ini digunakan untuk menghitung estimasi angsuran pada halaman simulasi pembiayaan. Formula yang digunakan adalah flat rate: <code class="bg-sky-100 px-1.5 py-0.5 rounded text-[11px]">(Pokok + (Pokok × Margin × Tenor/12)) / Tenor</code></p>
 </div>
 </div>
</div>

<x-admin.card :noPadding="true">
 {{-- Desktop Table View --}}
 <div >
 <x-admin.table :headers="['Jenis Pembiayaan', 'Margin Rate', 'Plafon', 'DP', 'Status', 'Aksi']">
 @forelse($configs as $config)
 <tr >
 <td class="px-6 py-4">
 <div>
 <p class="font-semibold text-zinc-900">{{ $config->name }}</p>
 <p class="text-[11px] text-zinc-500">{{ $config->type }}</p>
 </div>
 </td>
 <td class="px-6 py-4">
 <span class="font-semibold text-sky-600">{{ number_format($config->margin_rate * 100, 2) }}%</span>
 <p class="text-[11px] text-zinc-500">per tahun</p>
 </td>
 <td class="px-6 py-4">
 <div class="text-[11px]">
 <p class="text-zinc-700">Min: <span class="font-medium text-zinc-900">Rp {{ number_format($config->min_principal, 0, ',', '.') }}</span></p>
 <p class="text-zinc-700">Max: <span class="font-medium text-zinc-900">Rp {{ number_format($config->max_principal, 0, ',', '.') }}</span></p>
 </div>
 </td>
 <td class="px-6 py-4">
 @if($config->dp_enabled)
 <x-admin.badge variant="info">Aktif</x-admin.badge>
 <p class="text-[11px] text-zinc-500 mt-1">
 {{ $config->dp_min_percentage ?? 0 }}% - {{ $config->dp_max_percentage ?? 100 }}%
 </p>
 @else
 <span class="text-zinc-400 text-[11px]">-</span>
 @endif
 </td>
 <td class="px-6 py-4">
 @if($config->is_active)
 <x-admin.badge variant="success">Aktif</x-admin.badge>
 @else
 <x-admin.badge variant="danger">Nonaktif</x-admin.badge>
 @endif
 </td>
 <td class="px-6 py-4">
 <div class="flex items-center gap-1">
 <a href="{{ route('admin.financing-config.edit', $config) }}" class="p-2 text-zinc-400 rounded-xl inline-flex" title="Edit">
 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
 </svg>
 </a>
 <button type="button" data-open-modal="deleteConfig{{ $config->id }}" class="p-2 text-zinc-400 rounded-xl inline-flex hover:text-red-600" title="Hapus">
 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
 </svg>
 </button>
 </div>
 </td>
 </tr>
 @empty
 <tr>
 <td colspan="6" class="px-6 py-12 text-center">
 <div class="w-16 h-16 bg-sky-100 rounded-full flex items-center justify-center mb-3">
 <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
 </svg>
 </div>
 <p class="text-zinc-500 font-medium">Belum ada konfigurasi pembiayaan</p>
 <p class="text-[11px] text-zinc-400 mt-1">Jalankan seeder untuk menambahkan konfigurasi default</p>
 </td>
 </tr>
 @endforelse
 </x-admin.table>
 </div>

 {{-- Mobile Card View --}}
 <div class="p-4 space-y-4">
 @forelse($configs as $config)
 <div class="bg-white border border-zinc-200 rounded-xl">
 <div class="p-4">
 <div class="flex items-start justify-between mb-3">
 <div>
 <h3 class="font-bold text-zinc-900">{{ $config->name }}</h3>
 <p class="text-[11px] text-zinc-500">{{ $config->type }}</p>
 </div>
 @if($config->is_active)
 <x-admin.badge variant="success">Aktif</x-admin.badge>
 @else
 <x-admin.badge variant="danger">Nonaktif</x-admin.badge>
 @endif
 </div>

 <div class="space-y-2 mb-4 text-[11px]">
 <div class="flex items-center justify-between">
 <span class="text-zinc-500">Margin Rate:</span>
 <span class="font-semibold text-sky-600">{{ number_format($config->margin_rate * 100, 2) }}% / tahun</span>
 </div>
 <div class="flex items-center justify-between">
 <span class="text-zinc-500">Plafon Min:</span>
 <span class="font-medium text-zinc-900">Rp {{ number_format($config->min_principal, 0, ',', '.') }}</span>
 </div>
 <div class="flex items-center justify-between">
 <span class="text-zinc-500">Plafon Max:</span>
 <span class="font-medium text-zinc-900">Rp {{ number_format($config->max_principal, 0, ',', '.') }}</span>
 </div>
 <div class="flex items-center justify-between">
 <span class="text-zinc-500">Down Payment:</span>
 @if($config->dp_enabled)
 <span class="font-medium text-sky-600">{{ $config->dp_min_percentage ?? 0 }}% - {{ $config->dp_max_percentage ?? 100 }}%</span>
 @else
 <span class="text-zinc-400">Tidak aktif</span>
 @endif
 </div>
 </div>

 <div class="mb-4">
 <p class="text-[11px] text-zinc-500 mb-2">Tenor Tersedia:</p>
 <div class="flex flex-wrap gap-1">
 @foreach($config->available_tenors as $tenor)
 <span class="inline-flex px-2 py-0.5 bg-zinc-50 text-zinc-700 text-[11px] font-medium rounded-xl">
 {{ $tenor }} bln
 </span>
 @endforeach
 </div>
 </div>

 <a href="{{ route('admin.financing-config.edit', $config) }}" class="flex items-center justify-center gap-2 py-2.5 text-[13px] font-semibold text-sky-600 bg-sky-50 hover:bg-sky-100 rounded-xl w-full mb-2 transition-colors">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
 </svg>
 Edit Konfigurasi
 </a>
 <button type="button" data-open-modal="deleteConfig{{ $config->id }}" class="flex items-center justify-center gap-2 py-2.5 text-[13px] font-semibold text-red-600 bg-red-100 hover:bg-rose-200 rounded-xl w-full transition-colors">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
 </svg>
 Hapus
 </button>
 </div>
 </div>
 @empty
 <div class="text-center py-12">
 <div class="w-20 h-20 bg-sky-100 rounded-full flex items-center justify-center mb-4">
 <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
 </svg>
 </div>
 <h3 class="text-3xl font-semibold text-zinc-900 mb-1">Belum Ada Konfigurasi</h3>
 <p class="text-zinc-500">Jalankan seeder untuk menambahkan konfigurasi default</p>
 </div>
 @endforelse
 </div>
</x-admin.card>

{{-- Delete Modals --}}
@if($configs->count())
 @foreach($configs as $config)
 <x-admin.delete-modal
 id="deleteConfig{{ $config->id }}"
 title="Hapus Konfigurasi"
 message="Apakah Anda yakin ingin menghapus konfigurasi pembiayaan \"{{ $config->name }}\"? Tindakan ini tidak dapat dibatalkan."
 action="{{ route('admin.financing-config.destroy', $config) }}"
 />
 @endforeach
@endif
@endsection
