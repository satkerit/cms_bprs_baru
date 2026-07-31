@extends('layouts.admin')

@section('title', 'Kelola IP Terblokir')

@section('content')
<x-admin.page-header title="Kelola IP Terblokir" subtitle="Daftar IP yang diblokir oleh sistem">
 <x-slot:actions>
 <button @click="$dispatch('open-modal', 'block-ip')" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-xl font-medium">
 <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
 </svg>
 Blokir IP Manual
 </button>
 <form action="{{ route('admin.settings.blocked-ips.clear-expired') }}" method="POST" class="inline">
 @csrf
 <button type="submit" data-action="confirm-submit" data-message="Hapus semua blokir yang sudah kadaluarsa?" class="inline-flex items-center px-4 py-2 bg-orange-600 text-white rounded-xl font-medium">
 <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
 </svg>
 Hapus Kadaluarsa
 </button>
 </form>
 <x-admin.button href="{{ route('admin.settings.security') }}" variant="secondary">
 Kembali
 </x-admin.button>
 </x-slot:actions>
</x-admin.page-header>

@if(session('success'))
<div class="mb-6 p-4 bg-amber-50 border border-amber-200 text-amber-700 rounded-xl">
 {{ session('success') }}
</div>
@endif

<x-admin.card :noPadding="true">
 <div class="overflow-x-auto">
 <table class="w-full border-collapse">
 <thead>
 <tr class="border-b dark:border-slate-700 border-zinc-200/70 dark:bg-slate-800/50 bg-zinc-50/80">
 <th class="pl-5 pr-4 py-3.5 text-left text-[11px] font-semibold dark:text-slate-400 text-zinc-500 uppercase tracking-[0.05em]">IP Address</th>
 <th class="px-5 py-3.5 text-left text-[11px] font-semibold dark:text-slate-400 text-zinc-500 uppercase tracking-[0.05em]">Reason</th>
 <th class="px-5 py-3.5 text-left text-[11px] font-semibold dark:text-slate-400 text-zinc-500 uppercase tracking-[0.05em]">Attempts</th>
 <th class="px-5 py-3.5 text-left text-[11px] font-semibold dark:text-slate-400 text-zinc-500 uppercase tracking-[0.05em]">Blocked Until</th>
 <th class="px-5 py-3.5 text-left text-[11px] font-semibold dark:text-slate-400 text-zinc-500 uppercase tracking-[0.05em]">Type</th>
 <th class="px-5 py-3.5 text-left text-[11px] font-semibold dark:text-slate-400 text-zinc-500 uppercase tracking-[0.05em]">Created</th>
 <th class="pl-4 pr-5 py-3.5 text-right text-[11px] font-semibold dark:text-slate-400 text-zinc-500 uppercase tracking-[0.05em]">Aksi</th>
 </tr>
 </thead>
 <tbody class="divide-y divide-zinc-100/80">
 @forelse($blockedIps as $block)
 <tr class="table-row-hover">
 <td class="pl-5 pr-4 py-3.5">
 <span class="table-cell-mono">{{ $block->ip_address }}</span>
 </td>
 <td class="px-5 py-3.5 table-cell-secondary">
 {{ $block->reason ?? '-' }}
 </td>
 <td class="px-5 py-3.5">
 <x-admin.badge variant="secondary">{{ $block->attempts }} attempts</x-admin.badge>
 </td>
 <td class="px-5 py-3.5">
 @if($block->is_permanent)
 <span class="text-[12px] font-semibold text-red-600">Permanent</span>
 @else
 <span class="table-cell-secondary">{{ $block->blocked_until ? $block->blocked_until->format('d M Y H:i') : '-' }}</span>
 @endif
 </td>
 <td class="px-5 py-3.5">
 @if($block->is_permanent)
 <x-admin.badge variant="destructive">Permanent</x-admin.badge>
 @elseif($block->blocked_until && $block->blocked_until->isPast())
 <x-admin.badge variant="secondary">Expired</x-admin.badge>
 @else
 <x-admin.badge variant="warning">Temporary</x-admin.badge>
 @endif
 </td>
 <td class="px-5 py-3.5 table-cell-secondary">
 {{ $block->created_at->format('d M Y H:i') }}
 </td>
 <td class="pl-4 pr-5 py-3.5 text-right">
 <form action="{{ route('admin.settings.blocked-ips.unblock', $block) }}" method="POST" class="inline">
 @csrf @method('DELETE')
 <button type="submit" class="table-action-btn text-sky-600 hover:text-sky-700" title="Unblock" data-action="confirm-submit" data-message="Unblock IP {{ $block->ip_address }}?">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/>
 </svg>
 </button>
 </form>
 </td>
 </tr>
 @empty
 <tr>
 <td colspan="7" class="px-5 py-12 text-center">
 <span class="table-cell-secondary">Tidak ada IP yang terblokir</span>
 </td>
 </tr>
 @endforelse
 </tbody>
 </table>
 </div>

 @if($blockedIps->hasPages())
 <div class="p-5 border-t border-slate-200/60 bg-slate-50/30">
 {{ $blockedIps->links() }}
 </div>
 @endif
</x-admin.card>

<!-- Block IP Modal -->
<div x-data="{ open: false }" 
 @open-modal.window="open = ($event.detail === 'block-ip')"
 x-show="open" 
 x-cloak
 
 style="display: none;">
 <div class="flex items-center justify-center px-4">
 <div x-show="open" @click="open = false" class="fixed bg-black"></div>
 
 <div x-show="open" class="bg-white rounded-2xl container max-w-5xl w-full p-8">
 <h3 class="text-3xl font-bold dark:text-slate-100 text-zinc-900 mb-6">Blokir IP Manual</h3>
 
 <form action="{{ route('admin.settings.blocked-ips.block') }}" method="POST" class="space-y-4">
 @csrf
 
 <div>
 <label class="block text-[11px] font-semibold dark:text-slate-300 text-zinc-700 mb-2">
 IP Address
 </label>
 <input type="text" name="ip_address" required
 placeholder="192.168.1.1"
 class="w-full rounded-xl border-zinc-300 font-mono">
 <p class="mt-1 text-[11px] dark:text-slate-400 text-zinc-500">Masukkan IP address yang ingin diblokir</p>
 </div>
 
 <div>
 <label class="block text-[11px] font-semibold dark:text-slate-300 text-zinc-700 mb-2">
 Alasan
 </label>
 <input type="text" name="reason"
 placeholder="Contoh: Suspicious activity, Brute force attempt"
 class="w-full rounded-xl border-zinc-300">
 </div>
 
 <div class="flex items-center">
 <input type="checkbox" name="is_permanent" id="is_permanent" value="1"
 x-data="{ checked: false }"
 x-model="checked"
 @change="document.getElementById('duration_field').style.display = checked ? 'none' : 'block'"
 class="rounded border-zinc-300 text-sky-600">
 <label for="is_permanent" class="ml-2 text-[11px] dark:text-slate-300 text-zinc-700">Blokir Permanen</label>
 </div>
 
 <div id="duration_field">
 <label class="block text-[11px] font-semibold dark:text-slate-300 text-zinc-700 mb-2">
 Durasi (jam)
 </label>
 <input type="number" name="duration_hours" value="24" min="1" max="168"
 class="w-full rounded-xl border-zinc-300">
 <p class="mt-1 text-[11px] dark:text-slate-400 text-zinc-500">Durasi pemblokiran dalam jam (1-168 jam / 1-7 hari)</p>
 </div>
 
 <div class="flex gap-3 pt-4">
 <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-xl font-medium">
 Blokir IP
 </button>
 <button type="button" @click="open = false" class="px-4 py-2 dark:bg-slate-800/50 bg-zinc-50 dark:text-slate-300 text-zinc-700 rounded-xl font-medium">
 Batal
 </button>
 </div>
 </form>
 </div>
 </div>
</div>
@push('scripts')
<script nonce="{{ $nonce }}">
document.addEventListener('DOMContentLoaded', function() {
 document.querySelectorAll('[data-action="confirm-submit"]').forEach(function(btn) {
 btn.addEventListener('click', function(e) {
 if (!confirm(this.getAttribute('data-message'))) {
 e.preventDefault();
 }
 });
 });
});
</script>
@endpush
@endsection
