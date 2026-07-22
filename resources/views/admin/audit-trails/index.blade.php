@extends('layouts.admin')

@section('title', 'Log Aktivitas')

@section('content')
<x-admin.page-header title="Log Aktivitas" subtitle="Riwayat semua aktivitas di sistem">
 @if(auth()->user()->isSuperAdmin())
 <x-slot:actions>
 <button type="button" data-action="open-modal" data-modal="clearModal"
 class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-xl text-[11px] font-semibold">
 <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
 </svg>
 Bersihkan Log Lama
 </button>
 </x-slot:actions>
 @endif
</x-admin.page-header>

<x-admin.card :noPadding="true">
 <!-- Filters -->
 <div class="p-5 border-b border-zinc-100 bg-zinc-50/50">
 <form method="GET" class="space-y-4">
 <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:grid-cols-2 lg:grid-cols-4 gap-4">
 <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari deskripsi, user, IP..."
 class="w-full rounded-xl border-0 py-2.5 px-4 text-zinc-900 bg-white">

 <select name="action" class="rounded-xl border-0 py-2.5 px-4 text-zinc-900 bg-white">
 <option value="">Semua Aksi</option>
 @foreach($actions as $action)
 <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
 {{ ucfirst(str_replace('_', ' ', $action)) }}
 </option>
 @endforeach
 </select>

 <select name="user_id" class="rounded-xl border-0 py-2.5 px-4 text-zinc-900 bg-white">
 <option value="">Semua User</option>
 @foreach($users as $user)
 <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
 {{ $user->name }}
 </option>
 @endforeach
 </select>

 <select name="model_type" class="rounded-xl border-0 py-2.5 px-4 text-zinc-900 bg-white">
 <option value="">Semua Model</option>
 @foreach($modelTypes as $type)
 <option value="{{ $type }}" {{ request('model_type') == $type ? 'selected' : '' }}>
 {{ $type }}
 </option>
 @endforeach
 </select>
 </div>
 <div class="is-flex flex-wrap items-center gap-4">
 <div class="is-flex items-center gap-2">
 <label class="text-[11px] text-zinc-700">Dari:</label>
 <input type="date" name="date_from" value="{{ request('date_from') }}"
 class="rounded-xl border-0 py-2 px-3 text-zinc-900 bg-white">
 </div>
 <div class="is-flex items-center gap-2">
 <label class="text-[11px] text-zinc-700">Sampai:</label>
 <input type="date" name="date_to" value="{{ request('date_to') }}"
 class="rounded-xl border-0 py-2 px-3 text-zinc-900 bg-white">
 </div>
 <div class="is-flex gap-2">
 <x-admin.button type="submit" variant="secondary">Filter</x-admin.button>
 @if(request()->hasAny(['search', 'action', 'user_id', 'model_type', 'date_from', 'date_to']))
 <a href="{{ route('admin.audit-trails.index') }}" class="inline-flex items-center px-4 py-2 bg-zinc-50 text-zinc-700 rounded-xl text-[11px] font-semibold">
 Reset
 </a>
 @endif
 </div>
 </div>
 </form>
 </div>

 <!-- Table -->
 <div class="overflow-x-auto">
 <table class="w-full border-collapse">
 <thead>
 <tr class="border-b border-zinc-200/70 bg-zinc-50/80">
 <th class="pl-5 pr-4 py-3.5 text-left text-[11px] font-semibold text-zinc-500 uppercase tracking-[0.05em]">Waktu</th>
 <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-zinc-500 uppercase tracking-[0.05em]">User</th>
 <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-zinc-500 uppercase tracking-[0.05em]">Aksi</th>
 <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-zinc-500 uppercase tracking-[0.05em]">Deskripsi</th>
 <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-zinc-500 uppercase tracking-[0.05em]">IP Address</th>
 <th class="pl-4 pr-5 py-3.5 text-center text-[11px] font-semibold text-zinc-500 uppercase tracking-[0.05em]">Detail</th>
 </tr>
 </thead>
 <tbody class="divide-y divide-zinc-100/80">
 @forelse($audits as $audit)
 <tr class="table-row-hover">
 <td class="pl-5 pr-4 py-3.5">
 <div class="table-cell-text">{{ $audit->created_at->format('d/m/Y') }}</div>
 <div class="table-cell-secondary">{{ $audit->created_at->format('H:i:s') }}</div>
 </td>
 <td class="px-5 py-3.5">
 <div class="flex items-center gap-3">
 <div class="w-9 h-9 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-semibold text-[13px] shrink-0">
 {{ strtoupper(substr($audit->user_name ?? 'S', 0, 1)) }}
 </div>
 <div>
 <div class="table-cell-text font-medium">{{ $audit->user_name ?? 'System' }}</div>
 </div>
 </div>
 </td>
 <td class="px-5 py-3.5">
 <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-[11px] font-medium {{ $audit->action_badge }}">
 @if($audit->action === 'create')
 <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
 @elseif($audit->action === 'update')
 <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
 @elseif($audit->action === 'delete')
 <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
 @elseif($audit->action === 'login')
 <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
 @elseif($audit->action === 'logout')
 <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
 @endif
 {{ ucfirst(str_replace('_', ' ', $audit->action)) }}
 </span>
 </td>
 <td class="px-5 py-3.5">
 <div class="table-cell-text" title="{{ $audit->description }}">
 {{ $audit->description }}
 </div>
 @if($audit->model_type)
 <div class="table-cell-secondary">{{ class_basename($audit->model_type) }} #{{ $audit->model_id }}</div>
 @endif
 </td>
 <td class="px-5 py-3.5">
 <span class="table-cell-mono">{{ $audit->ip_address }}</span>
 </td>
 <td class="pl-4 pr-5 py-3.5 text-center">
 <a href="{{ route('admin.audit-trails.show', $audit) }}" class="table-action-btn" title="Lihat Detail">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
 </svg>
 </a>
 </td>
 </tr>
 @empty
 <tr>
 <td colspan="6" class="px-5 py-12 text-center">
 <span class="table-cell-secondary">
 Belum ada log aktivitas.
 </span>
 </td>
 </tr>
 @endforelse
 </tbody>
 </table>
 </div>

 @if($audits->hasPages())
 <div class="p-5 border-t border-slate-200/60 bg-slate-50/30">
 {{ $audits->links() }}
 </div>
 @endif
</x-admin.card>

<!-- Clear Modal -->
<div id="clearModal" class="hidden" aria-modal="true">
 <div class="is-flex items-center justify-center px-4 pt-4 pb-20 text-center sm:p-0">
 <div class="fixed bg-zinc-500 bg-opacity-75" data-action="close-modal" data-modal="clearModal"></div>
 <div class="bg-white rounded-xl text-left transform sm:my-8 sm:max-w-lg sm:w-full">
 <form action="{{ route('admin.audit-trails.clear') }}" method="POST">
 @csrf
 <div class="bg-white px-6 pt-6 pb-4">
 <div class="is-flex items-start">
 <div class="shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
 <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
 </svg>
 </div>
 <div class="ml-4">
 <h3 class="text-3xl font-semibold text-zinc-900">Bersihkan Log Lama</h3>
 <p class="mt-2 text-[13px] text-zinc-500">
 Hapus log aktivitas yang lebih lama dari jumlah hari yang ditentukan. Tindakan ini tidak dapat dibatalkan.
 </p>
 <div class="mt-4">
 <label class="block text-[11px] font-medium text-zinc-700 mb-1">Hapus log lebih dari:</label>
 <select name="days" class="w-full rounded-xl border-zinc-300 text-[13px]">
 <option value="30">30 hari</option>
 <option value="60">60 hari</option>
 <option value="90" selected>90 hari</option>
 <option value="180">180 hari</option>
 <option value="365">1 tahun</option>
 </select>
 </div>
 </div>
 </div>
 </div>
 <div class="bg-zinc-50 px-6 py-4 flex justify-end gap-3">
 <button type="button" data-action="close-modal" data-modal="clearModal" class="px-4 py-2 bg-white border border-zinc-300 rounded-xl text-[11px] font-medium text-zinc-700 hover:bg-zinc-50">
 Batal
 </button>
 <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-xl text-[11px] font-medium">
 Hapus Log
 </button>
 </div>
 </form>
 </div>
 </div>
</div>
@push('scripts')
<script nonce="{{ $nonce }}">
document.addEventListener('DOMContentLoaded', function() {
 document.querySelectorAll('[data-action="open-modal"]').forEach(function(btn) {
 btn.addEventListener('click', function() {
 var modalId = this.getAttribute('data-modal');
 document.getElementById(modalId).classList.remove('hidden');
 });
 });

 document.querySelectorAll('[data-action="close-modal"]').forEach(function(btn) {
 btn.addEventListener('click', function() {
 var modalId = this.getAttribute('data-modal');
 document.getElementById(modalId).classList.add('hidden');
 });
 });
});
</script>
@endpush
@endsection
