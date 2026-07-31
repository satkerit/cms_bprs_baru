@extends('layouts.admin')

@section('title', 'Jadwal Kas Keliling - ' . $kasKeliling->area_name)

@section('content')
<x-admin.page-header title="Jadwal Kas Keliling" :subtitle="$kasKeliling->area_name">
 <x-slot:actions>
 <button @click="$dispatch('open-modal', 'add-schedule')" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-xl font-medium">
 <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
 </svg>
 Tambah Jadwal
 </button>
 <x-admin.button href="{{ route('admin.kas-keliling.index') }}" variant="secondary">
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
 <th class="pl-5 pr-4 py-3.5 text-left text-[11px] font-semibold dark:text-slate-400 text-zinc-500 uppercase tracking-[0.05em]">Tanggal</th>
 <th class="px-5 py-3.5 text-left text-[11px] font-semibold dark:text-slate-400 text-zinc-500 uppercase tracking-[0.05em]">Hari</th>
 <th class="px-5 py-3.5 text-left text-[11px] font-semibold dark:text-slate-400 text-zinc-500 uppercase tracking-[0.05em]">Waktu</th>
 <th class="px-5 py-3.5 text-left text-[11px] font-semibold dark:text-slate-400 text-zinc-500 uppercase tracking-[0.05em]">Lokasi</th>
 <th class="px-5 py-3.5 text-left text-[11px] font-semibold dark:text-slate-400 text-zinc-500 uppercase tracking-[0.05em]">Status</th>
 <th class="pl-4 pr-5 py-3.5 text-right text-[11px] font-semibold dark:text-slate-400 text-zinc-500 uppercase tracking-[0.05em]">Aksi</th>
 </tr>
 </thead>
 <tbody class="divide-y divide-zinc-100/80">
 @forelse($schedules as $schedule)
 <tr class="table-row-hover">
 <td class="pl-5 pr-4 py-3.5">
 <span class="table-cell-text font-medium">{{ $schedule->schedule_date->format('d M Y') }}</span>
 </td>
 <td class="px-5 py-3.5 table-cell-text">
 {{ $schedule->day_name }}
 </td>
 <td class="px-5 py-3.5 table-cell-text">
 {{ $schedule->start_time }} - {{ $schedule->end_time }}
 </td>
 <td class="px-5 py-3.5 table-cell-text">
 {{ $schedule->location }}
 </td>
 <td class="px-5 py-3.5">
 @if($schedule->is_active)
 <x-admin.badge variant="info">Aktif</x-admin.badge>
 @else
 <x-admin.badge variant="secondary">Tidak Aktif</x-admin.badge>
 @endif
 </td>
 <td class="pl-4 pr-5 py-3.5 text-right">
 <div class="inline-flex items-center gap-1">
 <button @click="editSchedule({{ $schedule->id }})" class="table-action-btn" title="Edit">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
 </svg>
 </button>
 <form action="{{ route('admin.kas-keliling.schedules.destroy', [$kasKeliling, $schedule]) }}" method="POST" class="inline">
 @csrf @method('DELETE')
 <button type="submit" class="table-action-btn-danger" title="Hapus" data-action="confirm-delete">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
 </svg>
 </button>
 </form>
 </div>
 </td>
 </tr>
 @empty
 <tr>
 <td colspan="6" class="px-5 py-12 text-center">
 <span class="table-cell-secondary">Belum ada jadwal</span>
 </td>
 </tr>
 @endforelse
 </tbody>
 </table>
 </div>

 @if($schedules->hasPages())
 <div class="px-5 py-4 border-t dark:border-slate-800 border-zinc-100/80">
 {{ $schedules->links() }}
 </div>
 @endif
</x-admin.card>

<!-- Add Schedule Modal -->
<div x-data="{ open: false }" 
 @open-modal.window="open = ($event.detail === 'add-schedule')"
 x-show="open" 
 x-cloak
 
 style="display: none;">
 <div class="flex items-center justify-center px-4">
 <div x-show="open" @click="open = false" class="fixed bg-black"></div>
 
 <div x-show="open" class="bg-white rounded-2xl container max-w-5xl w-full p-8">
 <h3 class="text-3xl font-bold dark:text-slate-100 text-zinc-900 mb-6">Tambah Jadwal</h3>
 
 <form action="{{ route('admin.kas-keliling.schedules.store', $kasKeliling) }}" method="POST" class="space-y-4">
 @csrf
 
 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
 <div>
 <x-admin.input type="date" name="schedule_date" label="Tanggal" required />
 </div>
 <div>
 <label class="block text-[11px] font-semibold dark:text-slate-300 text-zinc-700 mb-2">Hari</label>
 <select name="day_name" class="w-full rounded-xl border-zinc-300">
 <option value="">Pilih Hari</option>
 <option value="Senin">Senin</option>
 <option value="Selasa">Selasa</option>
 <option value="Rabu">Rabu</option>
 <option value="Kamis">Kamis</option>
 <option value="Jumat">Jumat</option>
 <option value="Sabtu">Sabtu</option>
 <option value="Minggu">Minggu</option>
 </select>
 </div>
 </div>
 
 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
 <x-admin.input type="time" name="start_time" label="Jam Mulai" required />
 <x-admin.input type="time" name="end_time" label="Jam Selesai" required />
 </div>
 
 <x-admin.input name="location" label="Lokasi" required placeholder="Contoh: Pasar Pagi" />
 
 <div>
 <label class="block text-[11px] font-semibold dark:text-slate-300 text-zinc-700 mb-2">Rute Perjalanan (Opsional)</label>
 <div x-data="{ routes: [''] }">
 <template x-for="(route, index) in routes" :key="index">
 <div class="flex gap-2 mb-2">
 <input type="text" :name="'route['+index+']'" x-model="routes[index]"
 placeholder="Contoh: Jl. Pasar Pagi"
 class="flex-1 rounded-xl border-zinc-300">
 <button type="button" @click="routes.splice(index, 1)" x-show="routes.length > 1"
 class="px-3 py-2 text-red-600 rounded-xl">
 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
 </svg>
 </button>
 </div>
 </template>
 <button type="button" @click="routes.push('')" class="text-[13px] text-sky-600 font-medium">
 + Tambah Rute
 </button>
 </div>
 </div>
 
 <div>
 <label class="block text-[11px] font-semibold dark:text-slate-300 text-zinc-700 mb-2">Layanan yang Ditawarkan (Opsional)</label>
 <div x-data="{ services: [''] }">
 <template x-for="(service, index) in services" :key="index">
 <div class="flex gap-2 mb-2">
 <input type="text" :name="'services_offered['+index+']'" x-model="services[index]"
 placeholder="Contoh: Setoran Tabungan"
 class="flex-1 rounded-xl border-zinc-300">
 <button type="button" @click="services.splice(index, 1)" x-show="services.length > 1"
 class="px-3 py-2 text-red-600 rounded-xl">
 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
 </svg>
 </button>
 </div>
 </template>
 <button type="button" @click="services.push('')" class="text-[13px] text-sky-600 font-medium">
 + Tambah Layanan
 </button>
 </div>
 </div>
 
 <div>
 <label class="block text-[11px] font-semibold dark:text-slate-300 text-zinc-700 mb-2">Catatan</label>
 <textarea name="notes" rows="3" class="w-full rounded-xl border-zinc-300" placeholder="Catatan tambahan (opsional)"></textarea>
 </div>
 
 <div class="flex items-center">
 <input type="checkbox" name="is_active" id="is_active_add" value="1" checked
 class="rounded border-zinc-300 text-sky-600">
 <label for="is_active_add" class="ml-2 text-[13px] dark:text-slate-300 text-zinc-700">Aktif</label>
 </div>
 
 <div class="flex gap-3 pt-4">
 <x-admin.button type="submit">Simpan</x-admin.button>
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
 document.querySelectorAll('[data-action="confirm-delete"]').forEach(btn => {
 btn.addEventListener('click', function(e) {
 if (!confirm('Yakin ingin menghapus jadwal ini?')) {
 e.preventDefault();
 }
 });
 });
</script>
@endpush
@endsection
