@extends('layouts.admin')

@section('title', 'Simple Backup Database')

@section('content')
<div class="space-y-6">
 <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
 <div>
 <h1 class="text-5xl font-bold text-gray-900">Simple Backup Database</h1>
 <p class="text-gray-500 mt-1">Test backup functionality</p>
 </div>
 <button data-action="create-backup"
 class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white font-medium rounded-lg">
 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
 </svg>
 Buat Backup Test
 </button>
 </div>

 {{-- Database Info --}}
 <div class="bg-white rounded-lg border p-6">
 <h2 class="text-3xl font-semibold text-gray-900 mb-4">Database Info</h2>
 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
 <div>
 <span class="text-gray-500">Database:</span>
 <span class="font-medium ml-2">{{ $databaseInfo['name'] }}</span>
 </div>
 <div>
 <span class="text-gray-500">Host:</span>
 <span class="font-medium ml-2">{{ $databaseInfo['host'] }}:{{ $databaseInfo['port'] }}</span>
 </div>
 <div>
 <span class="text-gray-500">Tables:</span>
 <span class="font-medium ml-2">{{ $databaseInfo['table_count'] }}</span>
 </div>
 <div>
 <span class="text-gray-500">Total Backups:</span>
 <span class="font-medium ml-2">{{ $storageInfo['total_backups'] }}</span>
 </div>
 </div>
 </div>

 {{-- Backup List --}}
 <div class="bg-white rounded-lg border">
 <div class="px-6 py-4 border-b">
 <h2 class="text-3xl font-semibold text-gray-900">Backup Files</h2>
 </div>

 @if($backups->count() > 0)
 <div class="overflow-x-auto">
 <table class="w-full border-collapse">
 <thead>
 <tr class="border-b dark:border-slate-700 border-zinc-200/70 dark:bg-slate-800/50 dark:bg-slate-800/50 bg-zinc-50/80">
 <th class="pl-5 pr-4 py-3.5 text-left text-[11px] font-semibold dark:text-slate-400 dark:text-slate-400 text-zinc-500 uppercase tracking-[0.05em]">File</th>
 <th class="px-5 py-3.5 text-left text-[11px] font-semibold dark:text-slate-400 dark:text-slate-400 text-zinc-500 uppercase tracking-[0.05em]">Size</th>
 <th class="pl-4 pr-5 py-3.5 text-left text-[11px] font-semibold dark:text-slate-400 dark:text-slate-400 text-zinc-500 uppercase tracking-[0.05em]">Created</th>
 </tr>
 </thead>
 <tbody class="divide-y divide-zinc-100/80">
 @foreach($backups as $backup)
 <tr class="table-row-hover">
 <td class="pl-5 pr-4 py-3.5">
 <span class="table-cell-text font-medium">{{ $backup['filename'] }}</span>
 </td>
 <td class="px-5 py-3.5 table-cell-secondary">
 {{ $backup['size_formatted'] }}
 </td>
 <td class="pl-4 pr-5 py-3.5 table-cell-secondary">
 {{ $backup['created_at']->format('d/m/Y H:i') }}
 </td>
 </tr>
 @endforeach
 </tbody>
 </table>
 </div>
 @else
 <div class="px-6 py-12 text-center">
 <p class="text-gray-500">Belum ada backup. Klik tombol "Buat Backup Test" untuk membuat backup pertama.</p>
 </div>
 @endif
 </div>
</div>

<script nonce="{{ $nonce }}">
document.querySelector('[data-action="create-backup"]').addEventListener('click', async function() {
 try {
 const response = await fetch('{{ route("admin.simple-backup.create") }}', {
 method: 'POST',
 headers: {
 'Content-Type': 'application/json',
 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
 }
 });

 const data = await response.json();

 if (data.success) {
 alert('Backup berhasil dibuat: ' + data.filename);
 window.location.reload();
 } else {
 alert('Error: ' + data.message);
 }
 } catch (error) {
 alert('Error: ' + error.message);
 }
});
</script>
@endsection
