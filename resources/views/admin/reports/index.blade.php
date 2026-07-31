@extends('layouts.admin')

@section('title', 'Kelola Laporan')

@section('content')
<x-admin.page-header title="Kelola Laporan" subtitle="Kelola laporan keuangan dan publikasi">
 <x-slot:actions>
 <x-admin.button href="{{ route('admin.reports.create') }}" icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>'>
 Tambah Laporan
 </x-admin.button>
 </x-slot:actions>
</x-admin.page-header>

<x-admin.card :noPadding="true">
 <div class="p-4 border-b dark:border-slate-700 border-zinc-200">
 <form method="GET" class="flex flex-col sm:flex-row gap-3">
 <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari laporan..."
 class="w-full sm:flex-1 sm:min-w-[200px] rounded-xl border-zinc-300 text-[13px]">
 <div class="flex flex-wrap gap-3">
 <select name="type" class="flex-1 sm:flex-none rounded-xl border-zinc-300 text-[13px]">
 <option value="">Semua Tipe</option>
 <option value="keuangan_publikasi" {{ request('type') == 'keuangan_publikasi' ? 'selected' : '' }}>Keuangan Publikasi</option>
 <option value="tata_kelola" {{ request('type') == 'tata_kelola' ? 'selected' : '' }}>Tata Kelola</option>
 <option value="tahunan" {{ request('type') == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
 <option value="tahunan_berkelanjutan" {{ request('type') == 'tahunan_berkelanjutan' ? 'selected' : '' }}>Tahunan Berkelanjutan</option>
 </select>
 <select name="year" class="flex-1 sm:flex-none rounded-xl border-zinc-300 text-[13px]">
 <option value="">Semua Tahun</option>
 @foreach($years as $year)
 <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
 @endforeach
 </select>
 <x-admin.button type="submit" variant="secondary">Filter</x-admin.button>
 @if(request('search') || request('type') || request('year'))
 <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center px-4 py-2 text-[13px] font-medium dark:text-slate-300 dark:text-slate-300 text-zinc-700 bg-white rounded-xl">
 Reset
 </a>
 @endif
 </div>
 </form>
 </div>

 {{-- Mobile Card View --}}
 <div class="block md:hidden p-4 space-y-4">
 @php
 $typeLabels = [
 'keuangan_publikasi' => 'Keuangan Publikasi',
 'tata_kelola' => 'Tata Kelola',
 'tahunan' => 'Tahunan',
 'tahunan_berkelanjutan' => 'Tahunan Berkelanjutan',
 ];
 @endphp
 @forelse($reports as $report)
 <div class="bg-white border dark:border-slate-700 border-zinc-200 rounded-xl p-4">
 <div class="mb-3">
 <p class="font-semibold dark:text-slate-100 dark:text-slate-100 text-zinc-900 line-clamp-2">{{ $report->title }}</p>
 <p class="text-[13px] dark:text-slate-400 dark:text-slate-400 text-zinc-500 mt-1">{{ $report->file_size ? number_format($report->file_size / 1024 / 1024, 2) . ' MB' : '-' }}</p>
 </div>
 <div class="flex flex-wrap items-center gap-2 mb-3">
 <x-admin.badge variant="info">{{ $typeLabels[$report->type] ?? $report->type }}</x-admin.badge>
 @if($report->posting_status === 'scheduled')
 <x-admin.badge variant="info">Terjadwal</x-admin.badge>
 @elseif($report->is_published)
 <x-admin.badge variant="success">Dipublikasi</x-admin.badge>
 @else
 <x-admin.badge variant="warning">Draft</x-admin.badge>
 @endif
 </div>
 <div class="flex items-center justify-between text-xs dark:text-slate-400 dark:text-slate-400 text-zinc-500 mb-3">
 <span>{{ $report->year }}{{ $report->quarter ? ' Q' . $report->quarter : '' }}</span>
 <span>{{ number_format($report->download_count ?? 0) }}x download</span>
 </div>
 <div class="flex items-center gap-2 pt-3 border-t dark:border-slate-700 border-zinc-200">
 @if($report->file_path)
 <a href="{{ \App\Helpers\StorageHelper::url($report->file_path) }}" target="_blank" class="flex-1 text-center py-2 text-[13px] font-medium text-sky-600 hover:bg-sky-100 rounded-xl">
 Lihat
 </a>
 @endif
 <a href="{{ route('admin.reports.edit', $report) }}" class="flex-1 text-center py-2 text-[13px] font-medium text-sky-600 rounded-xl">
 Edit
 </a>
 <button type="button" data-open-modal="deleteReport{{ $report->id }}" class="flex-1 py-2 text-[13px] font-medium text-red-600 rounded-xl">
 Hapus
 </button>
 </div>
 </div>
 @empty
 <div class="text-center py-8 dark:text-slate-400 dark:text-slate-400 text-zinc-500">Belum ada laporan.</div>
 @endforelse
 </div>

 {{-- Desktop Table View --}}
 <div class="hidden md:block">
 @php
 $typeLabels = [
 'keuangan_publikasi' => 'Keuangan Publikasi',
 'tata_kelola' => 'Tata Kelola',
 'tahunan' => 'Tahunan',
 'tahunan_berkelanjutan' => 'Tahunan Berkelanjutan',
 ];
 @endphp
 <x-admin.table :headers="['Laporan', 'Tipe', 'Tahun', 'Status', 'Download', 'Aksi']">
 @forelse($reports as $report)
 <tr>
 <td class="px-4 py-3">
 <div class="min-w-0">
 <p class="font-medium text-gray-900 max-w-[200px]">{{ $report->title }}</p>
 <p class="text-xs dark:text-slate-400 dark:text-slate-400 text-zinc-500">{{ $report->file_size ? number_format($report->file_size / 1024 / 1024, 2) . ' MB' : '-' }}</p>
 </div>
 </td>
 <td class="px-4 py-3">
 <x-admin.badge variant="info">{{ $typeLabels[$report->type] ?? $report->type }}</x-admin.badge>
 </td>
 <td class="px-4 py-3 text-xs text-gray-900">
 {{ $report->year }}{{ $report->quarter ? ' Q' . $report->quarter : '' }}
 </td>
 <td class="px-4 py-3">
 @if($report->posting_status === 'scheduled')
 <x-admin.badge variant="info">Terjadwal</x-admin.badge>
 @elseif($report->is_published)
 <x-admin.badge variant="success">Dipublikasi</x-admin.badge>
 @else
 <x-admin.badge variant="warning">Draft</x-admin.badge>
 @endif
 </td>
 <td class="px-4 py-3 text-[13px] dark:text-slate-400 dark:text-slate-400 text-zinc-500">{{ number_format($report->download_count ?? 0) }}x</td>
 <td class="px-4 py-3">
 <div class="flex items-center gap-1">
 @if($report->file_path)
 <a href="{{ \App\Helpers\StorageHelper::url($report->file_path) }}" target="_blank" class="p-1.5 dark:text-slate-400 dark:text-slate-400 text-zinc-500 hover:bg-sky-100 rounded-xl">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
 </svg>
 </a>
 @endif
 <a href="{{ route('admin.reports.edit', $report) }}" class="p-1.5 dark:text-slate-400 dark:text-slate-400 text-zinc-500 rounded-xl">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
 </svg>
 </a>
 <button type="button" data-open-modal="deleteReport{{ $report->id }}" class="p-1.5 dark:text-slate-400 dark:text-slate-400 text-zinc-500 rounded-xl hover:text-red-600">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
 </svg>
 </button>
 </div>
 </td>
 </tr>
 @empty
 <tr><td colspan="6" class="px-4 py-8 text-center dark:text-slate-400 dark:text-slate-400 text-zinc-500">Belum ada laporan.</td></tr>
 @endforelse
 </x-admin.table>
 </div>

 @if($reports->hasPages())
 <div class="p-5 border-t border-slate-200/60 bg-slate-50/30">{{ $reports->links() }}</div>
 @endif
</x-admin.card>

{{-- Delete Modals --}}
@if($reports->count())
 @foreach($reports as $report)
 <x-admin.delete-modal
 id="deleteReport{{ $report->id }}"
 title="Hapus Laporan"
 :message="'Apakah Anda yakin ingin menghapus laporan ' . json_encode($report->title) . '? Tindakan ini tidak dapat dibatalkan.'"
 action="{{ route('admin.reports.destroy', $report) }}"
 />
 @endforeach
@endif
@endsection
