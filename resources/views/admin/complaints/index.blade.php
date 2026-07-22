@extends('layouts.admin')

@section('title', 'Whistleblowing System')

@section('content')
<x-admin.page-header title="Whistleblowing System" subtitle="Kelola laporan pelanggaran dan whistleblowing"/>

<x-admin.card :noPadding="true">
 <div class="p-4 border-b border-zinc-200">
 <form method="GET" class="flex flex-col sm:flex-row gap-3">
 <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari tiket/nama/subjek..."
 class="w-full rounded-xl border-zinc-300 text-[13px]">
 <div class="flex flex-wrap gap-3">
 <select name="status" class="border-zinc-300 text-[13px]">
 <option value="">Semua Status</option>
 <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
 <option value="in_review" {{ request('status') == 'in_review' ? 'selected' : '' }}>Dalam Review</option>
 <option value="investigating" {{ request('status') == 'investigating' ? 'selected' : '' }}>Investigasi</option>
 <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Selesai</option>
 <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Ditutup</option>
 </select>
 <select name="type" class="border-zinc-300 text-[13px]">
 <option value="">Semua Tipe</option>
 <option value="fraud" {{ request('type') == 'fraud' ? 'selected' : '' }}>Kecurangan</option>
 <option value="violation" {{ request('type') == 'violation' ? 'selected' : '' }}>Pelanggaran</option>
 <option value="ethics" {{ request('type') == 'ethics' ? 'selected' : '' }}>Etika</option>
 <option value="abuse" {{ request('type') == 'abuse' ? 'selected' : '' }}>Penyalahgunaan</option>
 <option value="other" {{ request('type') == 'other' ? 'selected' : '' }}>Lainnya</option>
 </select>
 <x-admin.button type="submit" variant="secondary">Filter</x-admin.button>
 @if(request('search') || request('status') || request('type'))
 <a href="{{ route('admin.complaints.index') }}" class="inline-flex items-center px-4 py-2 text-[13px] font-medium text-zinc-700 bg-white rounded-xl hover:bg-zinc-50 transition-colors">
 Reset
 </a>
 @endif
 </div>
 </form>
 </div>

 {{-- Mobile Card View --}}
 <div class="block md:hidden p-4">
 @forelse($complaints as $complaint)
 <div class="bg-white border border-zinc-200 rounded-xl p-4">
 <div class="mb-3">
 <div class="flex items-start justify-between gap-2 mb-2">
 <div>
 <p class="font-semibold text-zinc-900">{{ $complaint->ticket_number }}</p>
 <p class="text-[13px] text-zinc-500 line-clamp-2">{{ $complaint->subject }}</p>
 </div>
 @switch($complaint->status)
 @case('pending')
 <x-admin.badge variant="warning">Menunggu</x-admin.badge>
 @break
 @case('in_review')
 <x-admin.badge variant="info">Review</x-admin.badge>
 @break
 @case('investigating')
 <x-admin.badge variant="primary">Investigasi</x-admin.badge>
 @break
 @case('resolved')
 <x-admin.badge variant="success">Selesai</x-admin.badge>
 @break
 @case('closed')
 <x-admin.badge>Ditutup</x-admin.badge>
 @break
 @endswitch
 </div>
 <div class="text-[11px]">
 @if($complaint->is_anonymous)
 <span class="text-zinc-400 italic">Pelapor: Anonim</span>
 @else
 <p class="text-zinc-900">{{ $complaint->name }}</p>
 <p class="text-[13px] text-zinc-500">{{ $complaint->email }}</p>
 @endif
 </div>
 </div>
 <div class="flex flex-wrap items-center gap-2 mb-3">
 <x-admin.badge>{{ $complaint->type_label }}</x-admin.badge>
 <span class="text-[13px] text-zinc-500">{{ $complaint->created_at->format('d M Y') }}</span>
 </div>
 <div class="flex items-center gap-2 pt-3 border-t border-zinc-200">
 <a href="{{ route('admin.complaints.show', $complaint) }}" class="flex-1 text-center py-2 text-[13px] font-medium text-zinc-900 border border-zinc-200 hover:border-zinc-400 rounded-xl">
 Lihat Detail
 </a>
 <button type="button" data-open-modal="deleteComplaint{{ $complaint->id }}" class="flex-1 py-2 text-[13px] font-medium text-red-600 border border-red-200 hover:border-red-400 rounded-xl">
 Hapus
 </button>
 </div>
 </div>
 @empty
 <div class="text-center py-8 text-zinc-500">Belum ada pengaduan.</div>
 @endforelse
 </div>

 {{-- Desktop Table View --}}
 <div class="hidden md:block">
 <x-admin.table :headers="['Tiket', 'Pelapor', 'Tipe', 'Status', 'Tanggal', 'Aksi']">
 @forelse($complaints as $complaint)
 <tr>
 <td class="px-4 py-3">
 <div class="min-w-0">
 <p class="font-medium text-zinc-900">{{ $complaint->ticket_number }}</p>
 <p class="text-[13px] text-zinc-500 max-w-[200px]">{{ Str::limit($complaint->subject, 40) }}</p>
 </div>
 </td>
 <td class="px-4 py-3 text-[11px]">
 @if($complaint->is_anonymous)
 <span class="text-zinc-400 italic">Anonim</span>
 @else
 <div class="min-w-0">
 <p class="text-zinc-900">{{ $complaint->name }}</p>
 <p class="text-[13px] text-zinc-500">{{ $complaint->email }}</p>
 </div>
 @endif
 </td>
 <td class="px-4 py-3">
 <x-admin.badge>{{ $complaint->type_label }}</x-admin.badge>
 </td>
 <td class="px-4 py-3">
 @switch($complaint->status)
 @case('pending')
 <x-admin.badge variant="warning">Menunggu</x-admin.badge>
 @break
 @case('in_review')
 <x-admin.badge variant="info">Dalam Review</x-admin.badge>
 @break
 @case('investigating')
 <x-admin.badge variant="primary">Investigasi</x-admin.badge>
 @break
 @case('resolved')
 <x-admin.badge variant="success">Selesai</x-admin.badge>
 @break
 @case('closed')
 <x-admin.badge>Ditutup</x-admin.badge>
 @break
 @endswitch
 </td>
 <td class="px-4 py-3 text-[13px] text-zinc-500 border-b border-zinc-200 tabular-nums">{{ $complaint->created_at->format('d M Y') }}</td>
 <td class="px-4 py-3 border-b border-zinc-200">
 <div class="flex items-center gap-1">
 <a href="{{ route('admin.complaints.show', $complaint) }}" class="p-1.5 text-zinc-500 hover:text-zinc-900 border border-transparent hover:border-zinc-200 rounded-xl">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
 </svg>
 </a>
 <button type="button" data-open-modal="deleteComplaint{{ $complaint->id }}" class="p-1.5 text-zinc-500 hover:text-red-600 border border-transparent hover:border-red-200 rounded-xl">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
 </svg>
 </button>
 </div>
 </td>
 </tr>
 @empty
 <tr><td colspan="6" class="px-4 py-8 text-center text-zinc-500">Belum ada pengaduan.</td></tr>
 @endforelse
 </x-admin.table>
 </div>

 @if($complaints->hasPages())
 <div class="p-4 border-t border-zinc-200">{{ $complaints->links() }}</div>
 @endif
</x-admin.card>

{{-- Delete Modals --}}
@if($complaints->count())
 @foreach($complaints as $complaint)
 <x-admin.delete-modal
 id="deleteComplaint{{ $complaint->id }}"
 title="Hapus Pengaduan"
 :message="'Apakah Anda yakin ingin menghapus pengaduan ini? Tindakan ini tidak dapat dibatalkan.'"
 action="{{ route('admin.complaints.destroy', $complaint) }}"
 />
 @endforeach
@endif
@endsection
