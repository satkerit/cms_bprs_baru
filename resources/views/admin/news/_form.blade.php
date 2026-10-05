<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Validation Error Summary --}}
    @if($errors->any())
    <div class="lg:col-span-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/60 rounded-xl p-4">
        <div class="flex items-start gap-3">
            <div class="w-10 h-10 rounded-xl bg-red-100 dark:bg-red-900/40 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-red-800 dark:text-red-200">Terjadi kesalahan validasi</h4>
                <ul class="mt-2 text-sm text-red-700 dark:text-red-300 list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    {{-- Main Content --}}
    <div class="lg:col-span-2 space-y-6">
        {{-- Basic Info --}}
        <x-admin.card>
            <x-slot:header>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-sm shadow-emerald-600/20">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100">Informasi Utama</h3>
                </div>
            </x-slot:header>

            <div class="space-y-5">
                {{-- Title --}}
                <div>
                    <x-admin.input
                        label="Judul"
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title', $news->title ?? '') }}"
                        placeholder="Masukkan judul berita..."
                        required
                    />
                    @error('title') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                {{-- Content --}}
                <div>
                    <label for="content" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Konten <span class="text-red-600 dark:text-red-400">*</span></label>
                    <textarea
                        id="summernote"
                        name="content"
                        class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 px-3.5 py-2.5 text-sm text-slate-900 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition min-h-[400px]"
                        placeholder="Tulis konten berita..."
                        required
                    >{{ old('content', $news->content ?? '') }}</textarea>
                    @error('content') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                {{-- Excerpt --}}
                <div>
                    <x-admin.textarea
                        label="Ringkasan"
                        id="excerpt"
                        name="excerpt"
                        placeholder="Ringkasan singkat berita (opsional, maks 500 karakter)"
                        rows="3"
                    >{{ old('excerpt', $news->excerpt ?? '') }}</x-admin.textarea>
                    @error('excerpt') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>
        </x-admin.card>

        {{-- Featured Image --}}
        <x-admin.card>
            <x-slot:header>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-sky-500 to-sky-600 flex items-center justify-center shadow-sm shadow-sky-600/20">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100">Gambar Utama</h3>
                </div>
            </x-slot:header>

            <div>
                @if(!empty($news->featured_image))
                    <div class="relative group mb-3 rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700">
                        <img src="{{ storage_url($news->featured_image) }}" alt="Featured Image" class="w-full h-48 object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/70 via-slate-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-start p-3">
                            <span class="text-white text-xs font-medium px-2 py-1 rounded-lg bg-white/20 backdrop-blur-sm">Gambar saat ini</span>
                        </div>
                    </div>
                @endif
                <x-admin.image-picker
                    name="featured_image"
                    accept="image/*"
                    label="Pilih gambar atau seret ke sini"
                />
                @error('featured_image') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
            </div>
        </x-admin.card>

        {{-- Gallery Images --}}
        <x-admin.card>
            <x-slot:header>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-500 to-violet-600 flex items-center justify-center shadow-sm shadow-violet-600/20">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100">Galeri Gambar</h3>
                </div>
            </x-slot:header>

            <div>
                @if(!empty($news->images) && $news->images->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-3">
                        @foreach($news->images as $img)
                            <div class="relative group rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700">
                                <img src="{{ storage_url($img->image_path) }}" class="w-full h-24 object-cover">
                                <button type="button"
                                    @click="deleteGalleryImage('{{ $img->id }}', $el)"
                                    class="absolute top-2 right-2 w-7 h-7 bg-red-600 hover:bg-red-700 text-white rounded-full text-xs font-bold flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all shadow-sm">
                                    &times;
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif
                <x-admin.image-picker
                    name="slide_images[]"
                    accept="image/*"
                    multiple
                    label="Tambah gambar galeri"
                />
                @error('slide_images') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
            </div>
        </x-admin.card>
    </div>

    {{-- Sidebar --}}
    <div class="space-y-6">
        {{-- Publish Settings --}}
        <x-admin.card>
            <x-slot:header>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center shadow-sm shadow-amber-600/20">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100">Pengaturan Publikasi</h3>
                </div>
            </x-slot:header>

            <div class="space-y-5">
                {{-- Category --}}
                <div>
                    <x-admin.select
                        label="Kategori"
                        id="category"
                        name="category"
                        required
                        :value="old('category', $news->category ?? '')"
                    >
                        @foreach(['Berita', 'Event', 'Artikel', 'Pengumuman', 'Promo'] as $cat)
                            <option value="{{ $cat }}">{{ $cat }}</option>
                        @endforeach
                    </x-admin.select>
                    @error('category') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                {{-- Published Toggle --}}
                <div class="flex items-center justify-between gap-3 py-2.5 px-3.5 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200/60 dark:border-slate-700">
                    <div class="flex-1">
                        <label for="is_published" class="text-sm font-semibold text-slate-800 dark:text-slate-100 block">Publikasikan</label>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Tampilkan di halaman publik</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer shrink-0">
                        <input
                            type="checkbox"
                            name="is_published"
                            id="is_published"
                            value="1"
                            {{ old('is_published', $news->is_published ?? false) ? 'checked' : '' }}
                            class="peer sr-only"
                        >
                        <div class="w-11 h-6 rounded-full bg-slate-200 dark:bg-slate-700 peer-checked:bg-gradient-to-r peer-checked:from-emerald-600 peer-checked:to-emerald-500 transition-colors duration-200 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all after:duration-200 peer-checked:after:translate-x-full peer-checked:after:border-white shadow-sm"></div>
                    </label>
                </div>
                @error('is_published') <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror

                {{-- Published At --}}
                <div>
                    <x-admin.input
                        label="Tanggal Publikasi"
                        type="datetime-local"
                        id="published_at"
                        name="published_at"
                        value="{{ old('published_at', isset($news->published_at) ? $news->published_at->format('Y-m-d\TH:i') : '') }}"
                    />
                    @error('published_at') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div class="pt-2">
                    <x-admin.button type="submit" variant="primary" class="w-full">
                        {{ isset($news) ? 'Perbarui' : 'Publikasikan' }}
                    </x-admin.button>
                </div>
            </div>
        </x-admin.card>

        {{-- SEO --}}
        <x-admin.card>
            <x-slot:header>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-slate-700 to-slate-900 dark:from-slate-600 dark:to-slate-800 flex items-center justify-center shadow-sm">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100">SEO & Metadata</h3>
                </div>
            </x-slot:header>

            <div class="space-y-5">
                <div>
                    <x-admin.textarea
                        label="Meta Description"
                        id="meta_description"
                        name="meta_description"
                        placeholder="Deskripsi untuk mesin pencari (maks 160 karakter)"
                        rows="3"
                    >{{ old('meta_description', $news->meta_description ?? '') }}</x-admin.textarea>
                    @error('meta_description') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-admin.input
                        label="Tags"
                        type="text"
                        id="tags"
                        name="tags"
                        value="{{ old('tags', $news->tags ?? '') }}"
                        placeholder="tag1, tag2, tag3"
                    />
                    @error('tags') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>
        </x-admin.card>
    </div>
</div>

@php $nonce = request()->attributes->get('csp_nonce'); @endphp
<script nonce="{{ $nonce }}">
async function deleteGalleryImage(imageId, btn) {
    if (!confirm('Hapus gambar ini?')) return;
    try {
        const response = await fetch(`/admin/news/image/${imageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
            },
        });
        if (response.ok) {
            btn.closest('.group').remove();
        } else {
            const data = await response.json();
            alert(data.error || 'Gagal menghapus gambar');
        }
    } catch (error) {
        alert('Gagal menghapus gambar');
    }
}
</script>