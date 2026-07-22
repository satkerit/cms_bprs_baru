@extends('layouts.admin')

@section('title', 'Kelola Karir')

@section('content')
<x-admin.page-header title="Kelola Karir" subtitle="Kelola lowongan pekerjaan">
 <x-slot:actions>
 <x-admin.button href="{{ route('admin.careers.create') }}" icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>'>
 Tambah Lowongan
 </x-admin.button>
 </x-slot:actions>
</x-admin.page-header>

<x-admin.card :noPadding="true">
 <div class="p-4 border-b border-zinc-200">
 <form method="GET" class="flex flex-col sm:flex-row gap-3">
 <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari lowongan..."
 class="w-full sm:flex-1 sm:min-w-[200px] rounded-xl border-zinc-300 text-[11px]">
 <div class="flex flex-wrap gap-3">
 <select name="type" class="flex-1 sm:flex-none rounded-xl border-zinc-300 text-[11px]">
 <option value="">Semua Tipe</option>
 <option value="full_time" {{ request('type') == 'full_time' ? 'selected' : '' }}>Full Time</option>
 <option value="part_time" {{ request('type') == 'part_time' ? 'selected' : '' }}>Part Time</option>
 <option value="contract" {{ request('type') == 'contract' ? 'selected' : '' }}>Kontrak</option>
 <option value="internship" {{ request('type') == 'internship' ? 'selected' : '' }}>Magang</option>
 </select>
 <select name="status" class="flex-1 sm:flex-none rounded-xl border-zinc-300 text-[11px]">
 <option value="">Semua Status</option>
 <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
 <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
 <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Kadaluarsa</option>
 </select>
 <x-admin.button type="submit" variant="secondary">Filter</x-admin.button>
 @if(request('search') || request('type') || request('status'))
 <a href="{{ route('admin.careers.index') }}" class="inline-flex items-center px-4 py-2 text-[11px] font-medium text-zinc-700 bg-white rounded-xl">
 Reset
 </a>
 @endif
 </div>
 </form>
 </div>

 {{-- Mobile Card View --}}
 <div class="block md:hidden p-4 space-y-4">
 @forelse($careers as $career)
 <div class="bg-white border border-zinc-200 rounded-xl p-4">
 <div class="mb-3">
 <p class="font-semibold text-zinc-900">{{ $career->title }}</p>
 <p class="text-[13px] text-zinc-500">{{ $career->department ?? '-' }} • {{ $career->location ?? '-' }}</p>
 </div>
 <div class="flex flex-wrap items-center gap-2 mb-3">
 <x-admin.badge variant="info">{{ $career->employment_type_label }}</x-admin.badge>
 @if($career->is_active && !$career->isExpired())
 <x-admin.badge variant="success">Aktif</x-admin.badge>
 @elseif($career->isExpired())
 <x-admin.badge variant="danger">Kadaluarsa</x-admin.badge>
 @else
 <x-admin.badge variant="warning">Nonaktif</x-admin.badge>
 @endif
 @if($career->deadline)
 <span class="text-[13px] text-zinc-500">Deadline: {{ $career->deadline->format('d M Y') }}</span>
 @endif
 </div>
 <div class="flex items-center gap-2 pt-3 border-t border-zinc-200">
 <a href="{{ route('admin.careers.edit', $career) }}" class="flex-1 text-center py-2 text-[11px] font-medium text-sky-600 rounded-xl">
 Edit
 </a>
 <button type="button" data-open-modal="deleteCareer{{ $career->id }}" class="flex-1 py-2 text-[11px] font-medium text-red-600 rounded-xl">
 Hapus
 </button>
 </div>
 </div>
 @empty
 <div class="text-center py-8 text-zinc-500">Belum ada lowongan karir.</div>
 @endforelse
 </div>

 {{-- Desktop Table View --}}
 <div class="hidden md:block">
 <x-admin.table :headers="['Posisi', 'Tipe', 'Lokasi', 'Deadline', 'Status', 'Aksi']">
 @forelse($careers as $career)
 <tr>
 <td class="px-4 py-3">
 <div class="min-w-0">
 <p class="font-medium text-zinc-900">{{ $career->title }}</p>
 <p class="text-[13px] text-zinc-500">{{ $career->department ?? '-' }}</p>
 </div>
 </td>
 <td class="px-4 py-3">
 <x-admin.badge variant="info">{{ $career->employment_type_label }}</x-admin.badge>
 </td>
 <td class="px-4 py-3 text-[13px] text-zinc-500">
 {{ $career->location ?? '-' }}
 </td>
 <td class="px-4 py-3 text-[13px] text-zinc-500">
 {{ $career->deadline?->format('d M Y') ?? '-' }}
 </td>
 <td class="px-4 py-3">
 @if($career->is_active && !$career->isExpired())
 <x-admin.badge variant="success">Aktif</x-admin.badge>
 @elseif($career->isExpired())
 <x-admin.badge variant="danger">Kadaluarsa</x-admin.badge>
 @else
 <x-admin.badge variant="warning">Nonaktif</x-admin.badge>
 @endif
 </td>
 <td class="px-4 py-3">
 <div class="flex items-center gap-1">
 <a href="{{ route('admin.careers.edit', $career) }}" class="p-1.5 text-zinc-500 rounded-xl">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
 </svg>
 </a>
 <button type="button" data-open-modal="deleteCareer{{ $career->id }}" class="p-1.5 text-zinc-500 rounded-xl hover:text-red-600">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
 </svg>
 </button>
 </div>
 </td>
 </tr>
 @empty
 <tr>
 <td colspan="6" class="px-4 py-8 text-center text-zinc-500">Belum ada lowongan karir.</td>
 </tr>
 @endforelse
 </x-admin.table>
 </div>

 @if($careers->hasPages())
 <div class="p-5 border-t border-slate-200/60 bg-slate-50/30">
 {{ $careers->links() }}
 </div>
 @endif
</x-admin.card>

{{-- Delete Modals --}}
@if($careers->count())
 @foreach($careers as $career)
 <x-admin.delete-modal
 id="deleteCareer{{ $career->id }}"
 title="Hapus Lowongan"
 :message="'Apakah Anda yakin ingin menghapus lowongan ' . json_encode($career->title) . '? Tindakan ini tidak dapat dibatalkan.'"
 action="{{ route('admin.careers.destroy', $career) }}"
 />
 @endforeach
@endif
@endsection
