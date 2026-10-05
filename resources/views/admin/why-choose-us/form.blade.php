@extends('layouts.admin')

@section('title', $item->exists ? 'Edit Item' : 'Tambah Item')

@section('content')
@php
    $isEdit = $item->exists;
@endphp

<x-admin.page-header
    :title="$isEdit ? 'Edit Item' : 'Tambah Item'"
    :subtitle="$isEdit ? 'Edit data keunggulan' : 'Tambahkan data keunggulan baru'"
>
    <x-slot:actions>
        <x-admin.button href="{{ route('admin.why-choose-us.index') }}" variant="secondary" icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>'>
            Kembali
        </x-admin.button>
    </x-slot:actions>
</x-admin.page-header>

@if($errors->any())
    <x-admin.alert type="error" title="Periksa kembali input Anda" class="mb-6">
        Ada {{ $errors->count() }} isian yang perlu diperbaiki.
    </x-admin.alert>
@endif

<form action="{{ $isEdit ? route('admin.why-choose-us.update', $item) : route('admin.why-choose-us.store') }}"
      method="POST"
      enctype="multipart/form-data"
      id="whyChooseUsForm">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-8 space-y-6">
            {{-- Basic Information --}}
            <x-admin.card title="Informasi Dasar" subtitle="Data utama keunggulan" accent="emerald">
                <div class="space-y-5">
                    <x-admin.input
                        name="title"
                        label="Judul"
                        :value="old('title', $item->title ?? '')"
                        placeholder="Contoh: Pelayanan Terbaik"
                        required
                        :error="$errors->first('title')"
                    />

                    <x-admin.textarea
                        name="description"
                        label="Deskripsi"
                        :value="old('description', $item->description ?? '')"
                        placeholder="Jelaskan keunggulan ini secara detail..."
                        :rows="4"
                        required
                        :error="$errors->first('description')"
                    />
                </div>
            </x-admin.card>

            {{-- Icon --}}
            <x-admin.card title="Icon" subtitle="Upload icon untuk item ini" accent="gold">
                <div class="space-y-4">
                    @if($item->exists && $item->icon)
                        <div class="p-4 rounded-xl border border-slate-200/70 dark:border-slate-800/70 bg-slate-50/70 dark:bg-slate-800/30" id="currentIconContainer">
                            <div class="flex items-center gap-4">
                                <img src="{{ \App\Helpers\StorageHelper::url($item->icon) }}"
                                     alt="Current icon"
                                     class="w-20 h-20 object-contain rounded-xl bg-white dark:bg-slate-900 p-2 ring-1 ring-slate-200/70 dark:ring-slate-700/70">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-slate-800 dark:text-slate-200">Icon saat ini</p>
                                    <p class="text-[13px] text-slate-500 dark:text-slate-400 mt-0.5">Akan diganti jika Anda upload icon baru.</p>
                                    <button type="button"
                                        data-action="remove-current-icon"
                                        class="mt-2 text-[13px] font-semibold text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition-colors">
                                        Hapus Icon
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div>
                        <input type="file"
                               name="icon"
                               id="icon"
                               accept="image/png,image/svg+xml,image/jpeg,image/webp"
                               class="sr-only"
                               data-action="preview-icon">
                        <label for="icon"
                               class="group flex flex-col items-center justify-center w-full h-36 px-4 py-6 border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-xl cursor-pointer
                                      hover:border-emerald-500 dark:hover:border-emerald-500 hover:bg-emerald-50/50 dark:hover:bg-emerald-950/30
                                      transition-all duration-200">
                            <div class="flex flex-col items-center justify-center text-center">
                                <div class="w-12 h-12 mb-3 rounded-xl bg-slate-100 dark:bg-slate-800 group-hover:bg-emerald-100 dark:group-hover:bg-emerald-900/50 flex items-center justify-center transition-colors">
                                    <svg class="w-6 h-6 text-slate-400 dark:text-slate-500 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">Upload Icon</p>
                                <p class="text-[12px] text-slate-500 dark:text-slate-400 mt-1">PNG, SVG, JPG, atau WebP (Max 2MB)</p>
                            </div>
                        </label>
                    </div>

                    {{-- Icon Preview --}}
                    <div id="iconPreview" class="hidden p-4 rounded-xl border border-slate-200/70 dark:border-slate-800/70 bg-slate-50/70 dark:bg-slate-800/30">
                        <div class="flex items-center gap-4">
                            <img src="" alt="Icon preview" id="iconPreviewImg" class="w-20 h-20 object-contain rounded-xl bg-white dark:bg-slate-900 p-2 ring-1 ring-slate-200/70 dark:ring-slate-700/70">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-slate-800 dark:text-slate-200">Preview Icon Baru</p>
                                <p class="text-[13px] text-slate-500 dark:text-slate-400 mt-0.5">Akan disimpan saat submit form.</p>
                                <button type="button"
                                    data-action="clear-icon-preview"
                                    class="mt-2 text-[13px] font-semibold text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition-colors">
                                    Batalkan Pilihan
                                </button>
                            </div>
                        </div>
                    </div>

                    <p class="text-[12px] text-slate-500 dark:text-slate-400 flex items-start gap-2">
                        <svg class="w-4 h-4 shrink-0 mt-0.5 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span><strong>Rekomendasi:</strong> Icon SVG atau PNG transparan, ukuran 200×200px (1:1) untuk tampilan optimal.</span>
                    </p>
                    @error('icon')
                        <p class="text-[12px] text-red-600 flex items-center gap-1" role="alert">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </x-admin.card>
        </div>

        {{-- Sidebar --}}
        <div class="lg:col-span-4 space-y-6">
            {{-- Settings --}}
            <x-admin.card title="Pengaturan" subtitle="Konfigurasi tampilan" accent="sky">
                <div class="space-y-5">
                    <x-admin.select
                        name="color_theme"
                        label="Tema Warna"
                        :options="$themes"
                        :value="old('color_theme', $item->color_theme ?? 'primary')"
                        required
                        helper="Warna untuk background icon"
                        :error="$errors->first('color_theme')"
                    />

                    <x-admin.input
                        type="number"
                        name="sort_order"
                        label="Urutan Tampil"
                        :value="old('sort_order', $item->sort_order ?? 0)"
                        required
                        min="0"
                        helper="Semakin kecil, semakin awal ditampilkan"
                        :error="$errors->first('sort_order')"
                    />

                    {{-- Toggle Switch --}}
                    <div class="pt-3 border-t border-slate-100/80 dark:border-slate-800/80">
                        <label for="is_active" class="flex items-center justify-between gap-3 cursor-pointer select-none">
                            <div class="min-w-0">
                                <span class="text-[13px] font-semibold text-slate-700 dark:text-slate-300">Status Aktif</span>
                                <p class="text-[12px] text-slate-500 dark:text-slate-400 mt-0.5">Tampilkan di frontend</p>
                            </div>
                            <div class="relative shrink-0">
                                <input type="checkbox"
                                       name="is_active"
                                       id="is_active"
                                       value="1"
                                       {{ old('is_active', $item->is_active ?? true) ? 'checked' : '' }}
                                       class="peer sr-only">
                                <div class="w-11 h-6 rounded-full bg-slate-200 dark:bg-slate-700 peer-checked:bg-gradient-to-r peer-checked:from-emerald-600 peer-checked:to-emerald-500 transition-colors duration-200 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all after:duration-200 peer-checked:after:translate-x-full peer-checked:after:border-white shadow-sm"></div>
                            </div>
                        </label>
                    </div>
                </div>
            </x-admin.card>

            {{-- Action Buttons --}}
            <x-admin.card :noPadding="true">
                <div class="p-5 space-y-3">
                    <x-admin.button type="submit" variant="primary" class="w-full justify-center"
                        icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>'>
                        {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Data' }}
                    </x-admin.button>

                    <x-admin.button href="{{ route('admin.why-choose-us.index') }}" variant="secondary" class="w-full justify-center"
                        icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>'>
                        Batal
                    </x-admin.button>
                </div>
            </x-admin.card>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script nonce="{{ $nonce }}">
(function() {
    'use strict';

    const removeBtn = document.querySelector('[data-action="remove-current-icon"]');
    if (removeBtn) {
        removeBtn.addEventListener('click', function() {
            window.Swal.fire({
                title: 'Hapus Icon?',
                text: 'Icon saat ini akan dihapus.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const container = document.getElementById('currentIconContainer');
                    if (container) container.remove();
                    window.Swal.fire({
                        icon: 'success',
                        title: 'Terhapus!',
                        text: 'Icon akan dihapus saat Anda menyimpan.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        });
    }

    const previewInput = document.querySelector('[data-action="preview-icon"]');
    if (previewInput) {
        previewInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('iconPreviewImg').src = e.target.result;
                document.getElementById('iconPreview').classList.remove('hidden');
                const currentContainer = document.getElementById('currentIconContainer');
                if (currentContainer) currentContainer.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        });
    }

    const clearBtn = document.querySelector('[data-action="clear-icon-preview"]');
    if (clearBtn) {
        clearBtn.addEventListener('click', function() {
            document.getElementById('icon').value = '';
            document.getElementById('iconPreview').classList.add('hidden');
            const currentContainer = document.getElementById('currentIconContainer');
            if (currentContainer) currentContainer.classList.remove('hidden');
        });
    }
})();
</script>
@endpush