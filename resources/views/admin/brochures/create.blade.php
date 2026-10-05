@extends('layouts.admin')

@section('title', 'Upload Brosur')

@section('content')
<x-admin.page-header title="Upload Brosur" subtitle="Upload file brosur baru (PDF)">
    <x-slot:actions>
        <x-admin.button href="{{ route('admin.brochures.index') }}" variant="secondary" icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>'>
            Kembali
        </x-admin.button>
    </x-slot:actions>
</x-admin.page-header>

<x-admin.card>
    <div x-data="fileUpload()" class="max-w-xl mx-auto py-6">
        {{-- Validation Error --}}
        @if($errors->any())
            <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/60 rounded-xl p-4">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-red-100 dark:bg-red-900/40 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <ul class="text-sm text-red-700 dark:text-red-300 list-disc list-inside space-y-1 mt-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Dropzone --}}
        <div
            class="relative border-2 border-dashed rounded-2xl p-10 text-center transition-all duration-200"
            :class="{
                'border-emerald-500 bg-emerald-50 dark:bg-emerald-900/20 ring-4 ring-emerald-500/10': isDropping,
                'border-slate-300 dark:border-slate-700 hover:border-emerald-400 dark:hover:border-emerald-500 bg-slate-50/50 dark:bg-slate-800/30': !isDropping
            }"
            @dragover.prevent="isDropping = true"
            @dragleave.prevent="isDropping = false"
            @drop.prevent="handleDrop($event)"
        >
            <input type="file" x-ref="fileInput" class="hidden" accept=".pdf" @change="handleFileSelect($event)">

            {{-- Empty State --}}
            <div x-show="!file && !isUploading">
                <div class="w-20 h-20 mx-auto mb-5 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-600/20">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-1">Upload File Brosur</h3>
                <p class="text-[13px] text-slate-500 dark:text-slate-400 mb-5">Drag &amp; drop file PDF di sini atau klik tombol di bawah</p>
                <button type="button" @click="$refs.fileInput.click()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-emerald-600 to-emerald-500 text-white rounded-xl font-semibold text-sm shadow-emerald-600/30 hover:shadow-lg hover:-translate-y-0.5 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Pilih File
                </button>
                <div class="mt-5 inline-flex items-center gap-1.5 text-[11px] text-slate-500 dark:text-slate-400">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Hanya format PDF. Maksimal 10MB.
                </div>
            </div>

            {{-- File Selected State --}}
            <div x-show="file" style="display: none;">
                <div class="flex items-center justify-center gap-4 mb-5">
                    <div class="w-14 h-14 rounded-2xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center ring-2 ring-red-200/60 dark:ring-red-800/40">
                        <svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="font-semibold text-slate-800 dark:text-slate-100" x-text="file?.name"></p>
                        <p class="text-[13px] text-slate-500 dark:text-slate-400 mt-0.5" x-text="formatSize(file?.size)"></p>
                    </div>
                </div>

                {{-- Progress Bar --}}
                <div x-show="isUploading" class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2.5 mb-5 overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-600 to-emerald-500 h-2.5 rounded-full transition-all duration-300" :style="`width: ${progress}%`"></div>
                </div>

                {{-- Actions --}}
                <div class="flex justify-center gap-3">
                    <x-admin.button type="button" variant="secondary" size="sm" @click="file = null; progress = 0; isUploading = false" ::disabled="isUploading">
                        Batal
                    </x-admin.button>
                    <x-admin.button type="button" variant="primary" size="sm" @click="uploadFile()" ::disabled="isUploading">
                        <span x-show="!isUploading">Upload Sekarang</span>
                        <span x-show="isUploading" x-text="`Uploading ${progress}%`"></span>
                    </x-admin.button>
                </div>
            </div>

            {{-- Error Message --}}
            <div x-show="errorMessage" x-text="errorMessage" class="mt-4 text-[13px] text-red-600 dark:text-red-400 font-medium" style="display: none;"></div>
        </div>
    </div>
</x-admin.card>

@push('scripts')
<script nonce="{{ $nonce }}">
function fileUpload() {
    return {
        isDropping: false,
        file: null,
        progress: 0,
        isUploading: false,
        errorMessage: '',

        handleDrop(e) {
            this.isDropping = false;
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                this.validateAndSetFile(files[0]);
            }
        },

        handleFileSelect(e) {
            const files = e.target.files;
            if (files.length > 0) {
                this.validateAndSetFile(files[0]);
            }
        },

        validateAndSetFile(file) {
            this.errorMessage = '';
            if (file.type !== 'application/pdf') {
                this.errorMessage = 'File harus berformat PDF.';
                return;
            }
            if (file.size > 10 * 1024 * 1024) {
                this.errorMessage = 'Ukuran file maksimal 10MB.';
                return;
            }
            this.file = file;
        },

        formatSize(bytes) {
            if (!bytes) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        },

        uploadFile() {
            if (!this.file) return;

            this.isUploading = true;
            this.progress = 0;
            this.errorMessage = '';

            let formData = new FormData();
            formData.append('file', this.file);

            axios.post('{{ route('admin.brochures.store') }}', formData, {
                headers: { 'Content-Type': 'multipart/form-data' },
                onUploadProgress: (progressEvent) => {
                    this.progress = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                }
            })
            .then(response => {
                window.location.href = '{{ route('admin.brochures.index') }}';
            })
            .catch(error => {
                this.isUploading = false;
                this.errorMessage = error.response?.data?.message || 'Terjadi kesalahan saat upload.';
                console.error(error);
            });
        }
    }
}
</script>
@endpush
@endsection