@extends('layouts.admin')

@section('title', 'Backup Database')

@section('content')
<div class="space-y-6 max-w-7xl" x-data="backupManager({
 createUrl: @js(route('admin.database-backup.create')),
 cleanupUrl: @js(route('admin.database-backup.cleanup')),
 restoreUrlTemplate: @js(route('admin.database-backup.restore', ':filename')),
 deleteUrlTemplate: @js(route('admin.database-backup.delete', ':filename'))
})" x-init="init()">

    <x-admin.page-header
        title="Backup Database"
        subtitle="Kelola backup database untuk keamanan data"
        accent="gold">
        <x-slot:actions>
            <button @click="showCreateModal = true"
                    class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Buat Backup Baru
            </button>
        </x-slot:actions>
    </x-admin.page-header>

    {{-- ═══ INFO + MAINTENANCE CARDS ═══ --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Database Info --}}
        <x-admin.card title="Database" accent="sky">
            <template x-ref="database-icon">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
            </template>
            <div x-init="$el.querySelector('.card-icon').innerHTML = '<svg class=\'w-6 h-6 text-sky-600\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\' stroke-width=\'1.5\'>' + $refs['database-icon'].innerHTML + '</svg>'">
                <div class="flex items-center gap-4 mb-5">
                    <div class="card-icon w-11 h-11 rounded-xl bg-sky-100 flex items-center justify-center shrink-0"></div>
                    <div>
                        <p class="text-[13px] font-semibold text-slate-900">{{ $databaseInfo['name'] }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-x-4 gap-y-3">
                    <div class="flex justify-between text-[13px]">
                        <span class="text-slate-500">Tabel:</span>
                        <span class="font-medium text-slate-900 tabular-nums">{{ $databaseInfo['table_count'] }}</span>
                    </div>
                    <div class="flex justify-between text-[13px]">
                        <span class="text-slate-500">Ukuran:</span>
                        <span class="font-medium text-slate-900">{{ $databaseInfo['size_formatted'] }}</span>
                    </div>
                    <div class="flex justify-between text-[13px] col-span-2">
                        <span class="text-slate-500">Host:</span>
                        <span class="font-medium text-slate-900 font-mono">{{ $databaseInfo['host'] }}:{{ $databaseInfo['port'] }}</span>
                    </div>
                </div>
            </div>
        </x-admin.card>

        {{-- Storage Info --}}
        <x-admin.card title="Storage Backup" accent="emerald">
            <div class="flex items-center gap-4 mb-5">
                <div class="w-11 h-11 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[13px] text-slate-500">{{ $storageInfo['total_backups'] }} file backup</p>
                </div>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between text-[13px]">
                    <span class="text-slate-500">Total Backup:</span>
                    <span class="font-medium text-slate-900 tabular-nums">{{ $storageInfo['total_backups'] }}</span>
                </div>
                <div class="flex justify-between text-[13px]">
                    <span class="text-slate-500">Ukuran Total:</span>
                    <span class="font-medium text-slate-900">{{ $storageInfo['total_size_formatted'] }}</span>
                </div>
                <div class="flex justify-between text-[13px]">
                    <span class="text-slate-500">Ruang Tersedia:</span>
                    <span class="font-medium text-emerald-600">{{ $storageInfo['available_space_formatted'] }}</span>
                </div>
            </div>
        </x-admin.card>
    </div>

    {{-- Maintenance Card (full width) --}}
    <x-admin.card title="Maintenance" subtitle="Pembersihan otomatis backup lama" accent="gold">
        <div class="flex items-center gap-6">
            <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-[13px] text-slate-600">Hapus backup yang lebih lama dari periode tertentu untuk menghemat ruang penyimpanan.</p>
            </div>
            <button @click="showCleanupModal = true"
                    class="btn-outline shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Bersihkan Backup Lama
            </button>
        </div>
    </x-admin.card>

    {{-- ═══ BACKUP LIST ═══ --}}
    <x-admin.card :noPadding="true">
        <div class="px-6 py-5 border-b border-slate-100/80">
            <div class="flex items-center gap-3">
                <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-emerald-500 to-emerald-600 shrink-0"></div>
                <h2 class="text-[15px] font-semibold text-slate-900">Daftar Backup</h2>
                @if($backups->count() > 0)
                    <span class="admin-badge-emerald text-[10px]">{{ $backups->count() }} file</span>
                @endif
            </div>
        </div>

        @if($backups->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-slate-200/60 bg-gradient-to-b from-slate-50 to-slate-50/80">
                        <th class="pl-6 pr-4 py-3.5 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-[0.06em] whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <div class="w-0.5 h-3.5 rounded-full bg-gradient-to-b from-emerald-500 to-emerald-600 shrink-0"></div>
                                File
                            </div>
                        </th>
                        <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-[0.06em] whitespace-nowrap">Tipe</th>
                        <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-[0.06em] whitespace-nowrap">Ukuran</th>
                        <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-[0.06em] whitespace-nowrap">Dibuat</th>
                        <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-[0.06em] whitespace-nowrap">Deskripsi</th>
                        <th class="pl-4 pr-6 py-3.5 text-right text-[11px] font-semibold text-slate-500 uppercase tracking-[0.06em] whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/80">
                    @foreach($backups as $backup)
                    <tr class="hover:bg-emerald-50/30 transition-colors duration-150">
                        <td class="pl-6 pr-4 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center shrink-0 ring-1 ring-slate-200/50">
                                    @if($backup['compressed'])
                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                    @else
                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[13px] font-medium text-slate-900 break-words">{{ $backup['filename'] }}</p>
                                    @if($backup['compressed'])
                                        <p class="text-[11px] text-slate-400 flex items-center gap-1 mt-0.5">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"/></svg>
                                            Terkompresi (Gzip)
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            @php
                                $typeLabels = [
                                    'full' => ['Full Backup', 'emerald'],
                                    'structure_only' => ['Struktur Saja', 'sky'],
                                    'data_only' => ['Data Saja', 'violet'],
                                    'unknown' => ['Unknown', 'secondary']
                                ];
                                $typeInfo = $typeLabels[$backup['type']] ?? $typeLabels['unknown'];
                            @endphp
                            <x-admin.badge :variant="$typeInfo[1]">{{ $typeInfo[0] }}</x-admin.badge>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-[13px] font-medium text-slate-900 tabular-nums">
                            {{ $backup['size_formatted'] }}
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <p class="text-[13px] text-slate-900 font-medium">{{ $backup['created_at']->format('d/m/Y H:i') }}</p>
                            <p class="text-[11px] text-slate-400 mt-0.5">{{ $backup['created_at']->diffForHumans() }}</p>
                        </td>
                        <td class="px-5 py-4 text-[13px] text-slate-500 max-w-[300px]">
                            <span class="line-clamp-2">{{ $backup['metadata']['description'] ?? '-' }}</span>
                        </td>
                        <td class="pl-4 pr-6 py-4 text-right whitespace-nowrap">
                            <div class="inline-flex items-center gap-1.5">
                                {{-- Download --}}
                                <a href="{{ route('admin.database-backup.download', $backup['filename']) }}"
                                   class="table-action-btn" title="Download">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9.75v6.75m0 0l-3-3m3 3l3-3m-8.25 6a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z"/>
                                    </svg>
                                </a>
                                {{-- Restore --}}
                                <button @click="confirmRestore('{{ $backup['filename'] }}')"
                                        class="table-action-btn" title="Restore">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                </button>
                                {{-- Delete --}}
                                <button @click="confirmDelete('{{ $backup['filename'] }}')"
                                        class="table-action-btn-danger" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <x-admin.empty-state
                icon="database"
                title="Belum Ada Backup"
                description="Buat backup pertama untuk mengamankan data database Anda."
            >
                <x-slot:action>
                    <button @click="showCreateModal = true" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Buat Backup Sekarang
                    </button>
                </x-slot:action>
            </x-admin.empty-state>
        @endif
    </x-admin.card>
</div>

{{-- ═══ CRATE BACKUP MODAL ═══ --}}
<div x-cloak>
    <div x-show="showCreateModal" x-cloak>
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            {{-- Backdrop --}}
            <div x-show="showCreateModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-black/50 backdrop-blur-sm"
                 @click="showCreateModal = false"></div>

            {{-- Panel --}}
            <div x-show="showCreateModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 overflow-hidden z-10">
                {{-- Gradient top bar --}}
                <div class="h-1 bg-gradient-to-r from-emerald-500 to-emerald-600"></div>

                <div class="p-6">
                    {{-- Header --}}
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-50 to-emerald-100 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">Buat Backup Database</h3>
                            <p class="text-[13px] text-slate-500">Pilih jenis backup yang ingin dibuat</p>
                        </div>
                    </div>

                    <form @submit.prevent="createBackup()">
                        <div class="space-y-5">
                            {{-- Backup Type --}}
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wide mb-2.5">Jenis Backup</label>
                                <div class="space-y-3">
                                    <label class="flex items-center p-3 rounded-xl border border-slate-200 has-[:checked]:border-emerald-300 has-[:checked]:bg-emerald-50/50 cursor-pointer transition-all duration-150">
                                        <input type="radio" x-model="backupForm.backup_type" value="full"
                                               class="h-4 w-4 text-emerald-600 border-slate-300 focus:ring-emerald-500/30">
                                        <div class="ml-3">
                                            <span class="text-[13px] font-medium text-slate-900">Full Backup</span>
                                            <p class="text-[11px] text-slate-500 mt-0.5">Struktur tabel + seluruh data</p>
                                        </div>
                                    </label>
                                    <label class="flex items-center p-3 rounded-xl border border-slate-200 has-[:checked]:border-emerald-300 has-[:checked]:bg-emerald-50/50 cursor-pointer transition-all duration-150">
                                        <input type="radio" x-model="backupForm.backup_type" value="structure_only"
                                               class="h-4 w-4 text-emerald-600 border-slate-300 focus:ring-emerald-500/30">
                                        <div class="ml-3">
                                            <span class="text-[13px] font-medium text-slate-900">Struktur Saja</span>
                                            <p class="text-[11px] text-slate-500 mt-0.5">Hanya struktur tabel, tanpa data</p>
                                        </div>
                                    </label>
                                    <label class="flex items-center p-3 rounded-xl border border-slate-200 has-[:checked]:border-emerald-300 has-[:checked]:bg-emerald-50/50 cursor-pointer transition-all duration-150">
                                        <input type="radio" x-model="backupForm.backup_type" value="data_only"
                                               class="h-4 w-4 text-emerald-600 border-slate-300 focus:ring-emerald-500/30">
                                        <div class="ml-3">
                                            <span class="text-[13px] font-medium text-slate-900">Data Saja</span>
                                            <p class="text-[11px] text-slate-500 mt-0.5">Hanya data, tanpa struktur tabel</p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            {{-- Compression --}}
                            <div>
                                <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 cursor-pointer hover:border-slate-300 transition-all duration-150">
                                    <input type="checkbox" x-model="backupForm.compression"
                                           class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500/30">
                                    <div>
                                        <span class="text-[13px] font-medium text-slate-900">Kompresi file (Gzip)</span>
                                        <p class="text-[11px] text-slate-500">Memperkecil ukuran file backup</p>
                                    </div>
                                </label>
                            </div>

                            {{-- Description --}}
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wide mb-2">Deskripsi <span class="text-slate-400 normal-case tracking-normal">(Opsional)</span></label>
                                <input type="text" x-model="backupForm.description"
                                       class="input"
                                       placeholder="Contoh: Backup sebelum update sistem">
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-3 mt-6 pt-5 border-t border-slate-100">
                            <button type="button" @click="showCreateModal = false"
                                    class="btn-secondary flex-1">
                                Batal
                            </button>
                            <button type="submit" :disabled="isCreating"
                                    class="btn-primary flex-1">
                                <span x-show="!isCreating">Buat Backup</span>
                                <span x-show="isCreating" class="flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                                    </svg>
                                    Membuat...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ═══ CLEANUP MODAL ═══ --}}
<div x-cloak>
    <div x-show="showCleanupModal" x-cloak>
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            {{-- Backdrop --}}
            <div x-show="showCleanupModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-black/50 backdrop-blur-sm"
                 @click="showCleanupModal = false"></div>

            {{-- Panel --}}
            <div x-show="showCleanupModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 overflow-hidden z-10">
                {{-- Gradient top bar --}}
                <div class="h-1 bg-gradient-to-r from-amber-500 to-amber-600"></div>

                <div class="p-6">
                    {{-- Header --}}
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-50 to-amber-100 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">Bersihkan Backup Lama</h3>
                            <p class="text-[13px] text-slate-500">Hapus backup yang lebih lama dari periode tertentu</p>
                        </div>
                    </div>

                    <form @submit.prevent="cleanupBackups()">
                        <div class="space-y-5">
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wide mb-2.5">Hapus backup lebih lama dari:</label>
                                <select x-model="cleanupForm.days" class="select">
                                    <option value="7">7 hari</option>
                                    <option value="14">14 hari</option>
                                    <option value="30" selected>30 hari</option>
                                    <option value="60">60 hari</option>
                                    <option value="90">90 hari</option>
                                    <option value="180">180 hari</option>
                                    <option value="365">1 tahun</option>
                                </select>
                            </div>

                            <div class="bg-amber-50 border border-amber-200/70 rounded-xl p-4">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-amber-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                                    </svg>
                                    <div>
                                        <p class="text-[11px] font-semibold text-amber-800 mb-1">Peringatan</p>
                                        <p class="text-[13px] text-amber-700 leading-relaxed">File backup yang dihapus tidak dapat dikembalikan. Pastikan Anda sudah memiliki backup di tempat lain jika diperlukan.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 mt-6 pt-5 border-t border-slate-100">
                            <button type="button" @click="showCleanupModal = false"
                                    class="btn-secondary flex-1">
                                Batal
                            </button>
                            <button type="submit" :disabled="isCleaning"
                                    class="btn-destructive flex-1">
                                <span x-show="!isCleaning">Bersihkan</span>
                                <span x-show="isCleaning" class="flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                                    </svg>
                                    Membersihkan...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
