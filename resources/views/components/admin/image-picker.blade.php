@props([
    'name',
    'label' => null,
    'value' => null,
    'accept' => 'image/*',
    'hint' => null,
    'required' => false,
    'previewClass' => 'h-20',
])

@php
    use App\Helpers\StorageHelper;
    $inputId = 'input_' . $name;
    $deleteFieldName = $name . '_delete';
    $previewUrl = '';
    $hasExistingImage = !empty($value);
    if ($value) {
        $previewUrl = StorageHelper::url($value);
    }
@endphp

<div x-data="imagePicker({
    inputId: @js($inputId),
    initialPreview: @js($previewUrl),
    hasExistingImage: @js($hasExistingImage),
    deleteFieldName: @js($deleteFieldName)
})">
    @if($label)
        <label class="block text-[13px] font-medium dark:text-slate-300 text-zinc-700 mb-1.5">
            {{ $label }}
            @if($required) <span class="text-red-500">*</span> @endif
        </label>
    @endif

    {{-- Preview --}}
    <div class="mb-3" x-show="previewUrl" x-cloak>
        <img :src="previewUrl" alt="Preview" class="rounded-xl border dark:border-slate-700 border-zinc-200 dark:bg-slate-800/50 bg-zinc-50 {{ $previewClass }} w-full" style="object-fit: contain;">
    </div>

    {{-- Hidden input for storage path --}}
    <input type="hidden" name="{{ $name }}_from_storage" :value="fromStorage ? storagePath : ''">
    {{-- Hidden input for delete flag --}}
    <input type="hidden" name="{{ $name }}_delete" :value="shouldDelete ? '1' : ''">

    {{-- Buttons --}}
    <div class="flex flex-wrap items-center gap-2">
        {{-- Upload from PC --}}
        <label class="inline-flex items-center gap-1.5 px-3.5 py-2 text-sm font-medium text-emerald-700 bg-emerald-50 border border-emerald-200/60 rounded-xl hover:bg-emerald-100 cursor-pointer transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
            </svg>
            <span>Upload dari PC</span>
            <input type="file" name="{{ $name }}" id="{{ $inputId }}" accept="{{ $accept }}" class="sr-only" @change="handleFileSelect($event)">
        </label>

        {{-- Select from Storage --}}
        <button type="button" @click="openStorageModal()" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-sm font-medium text-emerald-700 bg-emerald-50 border border-emerald-200/60 rounded-xl hover:bg-emerald-100 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
            </svg>
            <span>Pilih dari Storage</span>
        </button>

        {{-- Clear --}}
        <button type="button" x-show="previewUrl" x-cloak @click="clearSelection()" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-sm font-medium text-red-600 bg-red-50 border border-red-200/60 rounded-xl hover:bg-red-100 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            <span>Hapus</span>
        </button>
    </div>

    @if($hint)
        <p class="mt-2 text-[12px] dark:text-slate-500 text-zinc-400">{{ $hint }}</p>
    @endif

    {{-- Storage Modal --}}
    <div x-show="showModal" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
        <div class="flex min-h-full items-center justify-center p-4">
            <div @click="closeStorageModal()" class="fixed inset-0 bg-zinc-900/50 backdrop-blur-sm transition-opacity"></div>
            <div class="relative z-10 w-full max-w-4xl transform overflow-hidden rounded-2xl bg-white shadow-2xl shadow-zinc-900/10">
                {{-- Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b dark:border-slate-800 border-zinc-100">
                    <h3 class="text-[15px] font-semibold dark:text-slate-100 text-zinc-900">Pilih Gambar dari Storage</h3>
                    <button type="button" @click="closeStorageModal()" class="dark:text-slate-500 text-zinc-400 hover:text-zinc-600 transition-colors p-1 rounded-lg hover:bg-zinc-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Breadcrumb --}}
                <div class="px-6 pt-4 pb-2">
                    <nav class="flex items-center gap-2 text-[13px] text-zinc-600 flex-wrap">
                        <button type="button" @click="navigateTo('')" class="inline-flex items-center gap-1 text-emerald-600 hover:text-emerald-700 font-medium">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span>Home</span>
                        </button>
                        <template x-for="(crumb, index) in breadcrumbs" :key="index">
                            <>
                                <svg class="w-3.5 h-3.5 dark:text-slate-500 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                <button type="button" @click="navigateTo(crumb.path)" class="text-emerald-600 hover:text-emerald-700 font-medium" x-text="crumb.name"></button>
                            </>
                        </template>
                    </nav>
                </div>

                {{-- Content --}}
                <div class="px-6 py-4 max-h-96 overflow-y-auto">
                    <div x-show="loading" class="flex items-center justify-center py-12">
                        <svg class="animate-spin h-8 w-8 text-emerald-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                    <div x-show="!loading && items.length === 0" class="text-center py-12 dark:text-slate-400 text-zinc-500">Folder kosong</div>
                    <div x-show="!loading" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                        <template x-for="item in items" :key="item.path">
                            <div @click="item.type === 'folder' ? navigateTo(item.path) : selectImage(item)"
                                 :class="{'ring-2 ring-emerald-500 ring-offset-2': selectedItem?.path === item.path}"
                                 class="relative rounded-xl border dark:border-slate-700 border-zinc-200 overflow-hidden cursor-pointer hover:shadow-md transition-all duration-150 hover:-translate-y-0.5">
                                <template x-if="item.type === 'folder'">
                                    <div class="bg-zinc-100 p-4 text-center">
                                        <svg class="w-10 h-10 mx-auto text-emerald-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M10 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2h-8l-2-2z"/>
                                        </svg>
                                        <p class="text-[11px] text-zinc-600 mt-1 truncate" x-text="item.name"></p>
                                    </div>
                                </template>
                                <template x-if="item.type === 'file' && item.isImage">
                                    <div>
                                        <div class="aspect-square bg-zinc-100">
                                            <img :src="item.url" :alt="item.name" class="w-full h-full object-cover">
                                        </div>
                                        <div class="bg-zinc-900/80 px-2 py-1">
                                            <p class="text-[11px] text-white truncate" x-text="item.name"></p>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-end gap-3 px-6 py-4 border-t dark:border-slate-800 border-zinc-100">
                    <button type="button" @click="closeStorageModal()" class="inline-flex items-center px-4 py-2 text-sm font-medium dark:text-slate-300 text-zinc-700 bg-white border dark:border-slate-700 border-zinc-200 rounded-xl hover:dark:bg-slate-800/50 bg-zinc-50 hover:border-zinc-300 transition-all duration-150">
                        Batal
                    </button>
                    <button type="button" @click="confirmSelection()" :disabled="!selectedItem" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-150 shadow-sm shadow-emerald-600/20">
                        Pilih
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
