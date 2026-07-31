@extends('layouts.admin')

@section('title', isset($heroSlide) ? 'Edit Slide' : 'Tambah Slide')

@section('content')
<x-admin.page-header :title="isset($heroSlide) ? 'Edit Slide' : 'Tambah Slide'">
    <x-slot:actions>
        <x-admin.button href="{{ route('admin.hero-slides.index') }}" variant="secondary">Kembali</x-admin.button>
    </x-slot:actions>
</x-admin.page-header>

<form action="{{ isset($heroSlide) ? route('admin.hero-slides.update', $heroSlide) : route('admin.hero-slides.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($heroSlide)) @method('PUT') @endif

    @if(session('error'))
    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-[13px]">
        {{ session('error') }}
    </div>
    @endif

    @if($errors->any())
    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-[13px]">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <x-admin.card title="Konten Slide">
                <div class="space-y-4">
                    <x-admin.input name="title" label="Judul" :value="old('title', $heroSlide->title ?? '')" hint="Opsional"/>

                    <x-admin.textarea name="subtitle" label="Subtitle" :value="old('subtitle', $heroSlide->subtitle ?? '')" rows="2"/>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-admin.input type="text" name="link_url" label="URL Link" :value="old('link_url', $heroSlide->link_url ?? '')" placeholder="https://..."/>
                        <x-admin.input name="link_text" label="Teks Tombol" :value="old('link_text', $heroSlide->link_text ?? '')" placeholder="Selengkapnya"/>
                    </div>
                </div>
            </x-admin.card>

            <x-admin.card title="Gambar Slide">
                <div class="space-y-4">
                    <x-admin.image-picker
                        name="image"
                        :value="$heroSlide->image ?? null"
                        :required="!isset($heroSlide)"
                        hint="Rekomendasi: 1920x800px (2.4:1). Format: JPG, PNG, WebP. Maks 5MB. Minimal lebar 1920px."
                        previewClass="w-full h-48 object-cover"
                    />
                    @error('image')<p class="text-[13px] text-red-600 font-medium">{{ $message }}</p>@enderror

                    {{-- Focal Point Selector --}}
                    @if($heroSlide && $heroSlide->image)
                    <x-admin.card title="Titik Fokus (Focal Point)">
                        <div class="space-y-3">
                            <p class="text-[12px] dark:text-slate-400 dark:text-slate-400 text-zinc-500">Klik pada gambar untuk menentukan titik fokus. Titik ini akan dijaga agar tetap terlihat di semua ukuran layar.</p>
                            <div class="relative inline-block" id="focal-preview">
                                <img src="{{ \App\Helpers\StorageHelper::url($heroSlide->image) }}"
                                     alt="Preview"
                                     class="max-w-full h-64 object-cover cursor-crosshair border dark:border-slate-700 border-zinc-200 rounded-lg"
                                     id="focal-img"
                                     loading="lazy">
                                <div class="absolute pointer-events-none transform -translate-x-1/2 -translate-y-1/2 w-12 h-12 border-2 border-emerald-500 rounded-full opacity-0 transition-opacity"
                                     id="focal-crosshair"
                                     style="top: {{ ($heroSlide->focal_y ?? 0.5) * 100 }}%; left: {{ ($heroSlide->focal_x ?? 0.5) * 100 }}%;">
                                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-px bg-emerald-500"></div>
                                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-px h-full bg-emerald-500"></div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3 pt-2">
                                <x-admin.input
                                    type="number"
                                    name="focal_x"
                                    label="X (Kanan %)"
                                    :value="old('focal_x', $heroSlide->focal_x ?? 0.5)"
                                    min="0"
                                    max="1"
                                    step="0.01"
                                    id="focal_x_input"
                                    hint="0 = kiri, 1 = kanan"
                                />
                                <x-admin.input
                                    type="number"
                                    name="focal_y"
                                    label="Y (Bawah %)"
                                    :value="old('focal_y', $heroSlide->focal_y ?? 0.5)"
                                    min="0"
                                    max="1"
                                    step="0.01"
                                    id="focal_y_input"
                                    hint="0 = atas, 1 = bawah"
                                />
                            </div>
                            <button type="button"
                                    class="text-xs text-emerald-600 hover:underline"
                                    onclick="document.getElementById('focal_x_input').value=0.5; document.getElementById('focal_y_input').value=0.5; updateCrosshair();">
                                Reset ke tengah
                            </button>
                        </div>
                    </x-admin.card>
                    @endif
                </div>
            </x-admin.card>
        </div>

        <div class="space-y-6">
            <x-admin.card title="Pengaturan">
                <div class="space-y-4">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                            {{ old('is_active', $heroSlide->is_active ?? true) ? 'checked' : '' }}
                            class="rounded border-zinc-300 text-emerald-600 focus:ring-emerald-500 h-4 w-4">
                        <label for="is_active" class="text-[13px] dark:text-slate-300 dark:text-slate-300 text-zinc-700 font-medium">Aktif</label>
                    </div>

                    <x-admin.input type="number" name="order_position" label="Urutan" :value="old('order_position', $heroSlide->order_position ?? 0)" min="0"/>

                    <div>
                        <label class="block text-[13px] font-medium dark:text-slate-300 dark:text-slate-300 text-zinc-700 mb-2">Tipe Transisi</label>
                        <select name="transition_type" class="w-full rounded-xl border border-zinc-300 bg-white px-3 py-2 text-[13px] focus:border-emerald-500 focus:ring-emerald-500">
                            @foreach($transitionTypes as $key => $label)
                            <option value="{{ $key }}" {{ old('transition_type', $heroSlide->transition_type ?? 'slide') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <x-admin.input type="number" name="transition_duration" label="Durasi Transisi (ms)" :value="old('transition_duration', $heroSlide->transition_duration ?? 500)" min="100" max="10000"/>
                </div>
            </x-admin.card>

            <x-admin.card title="Tampilkan">
                <div class="space-y-3">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="show_title" id="show_title" value="1"
                            {{ old('show_title', $heroSlide->show_title ?? true) ? 'checked' : '' }}
                            class="rounded border-zinc-300 text-emerald-600 focus:ring-emerald-500 h-4 w-4">
                        <label for="show_title" class="text-[13px] dark:text-slate-300 dark:text-slate-300 text-zinc-700 font-medium">Tampilkan Judul</label>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="show_subtitle" id="show_subtitle" value="1"
                            {{ old('show_subtitle', $heroSlide->show_subtitle ?? true) ? 'checked' : '' }}
                            class="rounded border-zinc-300 text-emerald-600 focus:ring-emerald-500 h-4 w-4">
                        <label for="show_subtitle" class="text-[13px] dark:text-slate-300 dark:text-slate-300 text-zinc-700 font-medium">Tampilkan Subtitle</label>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="show_button" id="show_button" value="1"
                            {{ old('show_button', $heroSlide->show_button ?? true) ? 'checked' : '' }}
                            class="rounded border-zinc-300 text-emerald-600 focus:ring-emerald-500 h-4 w-4">
                        <label for="show_button" class="text-[13px] dark:text-slate-300 dark:text-slate-300 text-zinc-700 font-medium">Tampilkan Tombol</label>
                    </div>
                </div>
            </x-admin.card>

            <x-admin.button type="submit" class="w-full">
                {{ isset($heroSlide) ? 'Simpan Perubahan' : 'Tambah Slide' }}
            </x-admin.button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script nonce="{{ $nonce }}">
(function() {
    const img = document.getElementById('focal-img');
    const crosshair = document.getElementById('focal-crosshair');
    const xInput = document.getElementById('focal_x_input');
    const yInput = document.getElementById('focal_y_input');
    if (!img || !crosshair || !xInput || !yInput) return;

    function updateCrosshair() {
        const x = Math.max(0, Math.min(1, parseFloat(xInput.value) || 0.5));
        const y = Math.max(0, Math.min(1, parseFloat(yInput.value) || 0.5));
        crosshair.style.left = (x * 100) + '%';
        crosshair.style.top = (y * 100) + '%';
        crosshair.style.opacity = '1';
    }

    function handleImgClick(e) {
        const rect = img.getBoundingClientRect();
        const x = (e.clientX - rect.left) / rect.width;
        const y = (e.clientY - rect.top) / rect.height;
        xInput.value = x.toFixed(2);
        yInput.value = y.toFixed(2);
        updateCrosshair();
    }

    img.addEventListener('click', handleImgClick);
    xInput.addEventListener('input', updateCrosshair);
    yInput.addEventListener('input', updateCrosshair);

    // Initial
    updateCrosshair();
})();
</script>
@endpush
