@extends('layouts.admin')

@section('title', 'File Tidak Terpakai')

@section('content')
<x-admin.page-header title="File Tidak Terpakai" subtitle="File di storage yang tidak terdaftar di database">
    <x-slot:actions>
        <a href="{{ route('admin.storage.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border dark:border-slate-700 border-zinc-200 dark:text-slate-300 text-zinc-700 text-[11px] font-medium rounded-xl hover:bg-zinc-50 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke File Manager
        </a>
    </x-slot:actions>
</x-admin.page-header>

@if(session('success'))
    <div class="mb-4 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-[13px]">
        {{ session('success') }}
    </div>
@endif

{{-- Summary --}}
<div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="bg-white dark:bg-slate-800 rounded-xl p-4 border dark:border-slate-700 border-zinc-200">
        <p class="text-[11px] dark:text-slate-400 text-zinc-500">File Tidak Terpakai</p>
        <p class="text-3xl font-semibold dark:text-slate-100 text-zinc-900">{{ count($orphaned) }} file</p>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-xl p-4 border dark:border-slate-700 border-zinc-200">
        <p class="text-[11px] dark:text-slate-400 text-zinc-500">Total Ukuran</p>
        <p class="text-3xl font-semibold text-red-600">
            @if($totalSize > 1048576)
                {{ number_format($totalSize / 1048576, 2) }} MB
            @elseif($totalSize > 1024)
                {{ number_format($totalSize / 1024, 1) }} KB
            @else
                {{ $totalSize }} bytes
            @endif
        </p>
    </div>
</div>

@if(count($orphaned) === 0)
    <x-admin.card>
        <div class="text-center py-16">
            <svg class="w-16 h-16 mx-auto text-emerald-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-lg font-semibold dark:text-slate-200 text-zinc-700">Storage Bersih</p>
            <p class="text-[13px] dark:text-slate-400 text-zinc-500 mt-1">Semua file di storage sudah terdaftar di database.</p>
        </div>
    </x-admin.card>
@else
    <form method="POST" action="{{ route('admin.storage.cleanup-orphaned') }}" id="cleanupForm">
        @csrf
        <x-admin.card :noPadding="true">
            {{-- Toolbar --}}
            <div class="flex items-center justify-between px-4 py-3 border-b dark:border-slate-700 border-zinc-100">
                <div class="flex items-center gap-3">
                    <label class="flex items-center gap-2 cursor-pointer text-[12px] dark:text-slate-400 text-zinc-500">
                        <input type="checkbox" id="selectAll" class="rounded border-zinc-300 text-red-600 focus:ring-red-500">
                        Pilih Semua
                    </label>
                    <span class="text-[11px] dark:text-slate-500 text-zinc-400" id="selectedCount">0 dipilih</span>
                </div>
                <button type="submit" id="deleteBtn" disabled
                    onclick="return confirm('Yakin ingin menghapus file yang dipilih? Tindakan ini tidak dapat dibatalkan.')"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white text-[11px] font-medium rounded-xl hover:bg-red-700 disabled:opacity-40 disabled:cursor-not-allowed transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Hapus yang Dipilih
                </button>
            </div>

            {{-- File List --}}
            <div class="divide-y dark:divide-slate-700 divide-zinc-100">
                @foreach($orphaned as $file)
                    <div class="flex items-center gap-4 px-4 py-3 hover:dark:bg-slate-800/50 hover:bg-zinc-50 transition-colors">
                        {{-- Checkbox --}}
                        <input type="checkbox" name="files[]" value="{{ $file['path'] }}"
                            class="file-checkbox rounded border-zinc-300 text-red-600 focus:ring-red-500 shrink-0">

                        {{-- Preview --}}
                        <div class="w-12 h-12 rounded-lg overflow-hidden bg-zinc-100 dark:bg-slate-700 shrink-0 flex items-center justify-center">
                            @if(in_array($file['extension'], ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']))
                                <img src="{{ $file['url'] }}" alt="{{ $file['name'] }}" class="w-full h-full object-cover">
                            @elseif(in_array($file['extension'], ['pdf']))
                                <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            @else
                                <svg class="w-6 h-6 dark:text-slate-500 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <p class="text-[13px] font-medium dark:text-slate-200 text-zinc-800 truncate">{{ $file['name'] }}</p>
                            <p class="text-[11px] dark:text-slate-500 text-zinc-400 truncate">{{ $file['path'] }}</p>
                        </div>

                        {{-- Size & Date --}}
                        <div class="text-right shrink-0 hidden sm:block">
                            <p class="text-[12px] dark:text-slate-400 text-zinc-500">
                                {{ $file['size'] > 1048576 ? number_format($file['size'] / 1048576, 2).' MB' : number_format($file['size'] / 1024, 1).' KB' }}
                            </p>
                            <p class="text-[11px] dark:text-slate-500 text-zinc-400">
                                {{ $file['modified'] ? date('d M Y', $file['modified']) : '-' }}
                            </p>
                        </div>

                        {{-- Ext Badge --}}
                        <span class="shrink-0 px-2 py-0.5 text-[10px] font-medium uppercase bg-zinc-100 dark:bg-slate-700 dark:text-slate-400 text-zinc-500 rounded-lg">
                            {{ $file['extension'] ?: 'file' }}
                        </span>
                    </div>
                @endforeach
            </div>
        </x-admin.card>
    </form>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectAll  = document.getElementById('selectAll');
    const deleteBtn  = document.getElementById('deleteBtn');
    const countLabel = document.getElementById('selectedCount');
    const checkboxes = document.querySelectorAll('.file-checkbox');

    function updateState() {
        const checked = document.querySelectorAll('.file-checkbox:checked').length;
        countLabel.textContent = checked + ' dipilih';
        deleteBtn.disabled = checked === 0;
        selectAll.indeterminate = checked > 0 && checked < checkboxes.length;
        selectAll.checked = checked === checkboxes.length && checkboxes.length > 0;
    }

    selectAll?.addEventListener('change', function () {
        checkboxes.forEach(cb => cb.checked = this.checked);
        updateState();
    });

    checkboxes.forEach(cb => cb.addEventListener('change', updateState));
});
</script>
@endpush
@endsection
