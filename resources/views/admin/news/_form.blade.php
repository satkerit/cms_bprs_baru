<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Validation Error Summary --}}
    @if($errors->any())
    <div class="lg:col-span-3 bg-red-50 border border-red-200 rounded-xl p-4">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <div>
                <h4 class="text-sm font-semibold text-red-800">Terjadi kesalahan validasi</h4>
                <ul class="mt-2 text-sm text-red-700 list-disc list-inside space-y-1">
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
                <h3 class="text-lg font-semibold text-foreground">Informasi Utama</h3>
            </x-slot:header>

            <div class="space-y-4">
                {{-- Title --}}
                <div>
                    <label for="title" class="block text-sm font-medium text-foreground mb-1">Judul <span class="text-destructive">*</span></label>
                    <x-admin.input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title', $news->title ?? '') }}"
                        placeholder="Masukkan judul berita..."
                        required
                    />
                    @error('title') <p class="text-sm text-destructive mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Content --}}
                <div>
                    <label for="content" class="block text-sm font-medium text-foreground mb-1">Konten <span class="text-destructive">*</span></label>
                    <textarea
                        id="summernote"
                        name="content"
                        class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring min-h-[400px] resize-y"
                        placeholder="Tulis konten berita..."
                        required
                    >{{ old('content', $news->content ?? '') }}</textarea>
                    @error('content') <p class="text-sm text-destructive mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Excerpt --}}
                <div>
                    <label for="excerpt" class="block text-sm font-medium text-foreground mb-1">Ringkasan</label>
                    <x-admin.textarea
                        id="excerpt"
                        name="excerpt"
                        placeholder="Ringkasan singkat berita (opsional, maks 500 karakter)"
                        rows="3"
                    >{{ old('excerpt', $news->excerpt ?? '') }}</x-admin.textarea>
                    @error('excerpt') <p class="text-sm text-destructive mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </x-admin.card>

        {{-- Featured Image --}}
        <x-admin.card>
            <x-slot:header>
                <h3 class="text-lg font-semibold text-foreground">Gambar Utama</h3>
            </x-slot:header>

            <div>
                @if(!empty($news->featured_image))
                    <div class="relative group mb-3">
                        <img src="{{ storage_url($news->featured_image) }}" alt="Featured Image" class="w-full h-48 object-cover rounded-lg">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                            <span class="text-white text-sm">Gambar saat ini</span>
                        </div>
                    </div>
                @endif
                <x-admin.image-picker
                    name="featured_image"
                    accept="image/*"
                    label="Pilih gambar atau seret ke sini"
                />
                @error('featured_image') <p class="text-sm text-destructive mt-1">{{ $message }}</p> @enderror
            </div>
        </x-admin.card>

        {{-- Gallery Images --}}
        <x-admin.card>
            <x-slot:header>
                <h3 class="text-lg font-semibold text-foreground">Galeri Gambar</h3>
            </x-slot:header>

            <div>
                @if(!empty($news->images) && $news->images->count() > 0)
                    <div class="grid grid-cols-3 gap-2 mb-3">
                        @foreach($news->images as $img)
                            <div class="relative group">
                                <img src="{{ storage_url($img->image_path) }}" class="w-full h-24 object-cover rounded-lg">
                                <button type="button"
                                    @click="deleteGalleryImage('{{ $img->id }}', $el)"
                                    class="absolute top-1 right-1 w-5 h-5 bg-destructive text-white rounded-full text-xs flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
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
                @error('slide_images') <p class="text-sm text-destructive mt-1">{{ $message }}</p> @enderror
            </div>
        </x-admin.card>
    </div>

    {{-- Sidebar --}}
    <div class="space-y-6">
        {{-- Publish Settings --}}
        <x-admin.card>
            <x-slot:header>
                <h3 class="text-lg font-semibold text-foreground">Pengaturan Publikasi</h3>
            </x-slot:header>

            <div class="space-y-4">
                {{-- Category --}}
                <div>
                    <label for="category" class="block text-sm font-medium text-foreground mb-1">Kategori <span class="text-destructive">*</span></label>
                    <x-admin.select id="category" name="category" required>
                        <option value="">Pilih Kategori</option>
                        @foreach(['Berita', 'Artikel', 'Pengumuman', 'Promo', 'Event'] as $cat)
                            <option value="{{ $cat }}" {{ old('category', $news->category ?? '') === $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </x-admin.select>
                    @error('category') <p class="text-sm text-destructive mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Published --}}
                <div class="flex items-center gap-2">
                    <input
                        type="checkbox"
                        name="is_published"
                        id="is_published"
                        value="1"
                        {{ old('is_published', $news->is_published ?? false) ? 'checked' : '' }}
                        class="rounded border-input bg-background text-primary focus:ring-primary"
                    />
                    <label for="is_published" class="text-sm font-medium text-foreground">Publikasikan</label>
                </div>
                @error('is_published') <p class="text-sm text-destructive">{{ $message }}</p> @enderror

                {{-- Published At --}}
                <div>
                    <label for="published_at" class="block text-sm font-medium text-foreground mb-1">Tanggal Publikasi</label>
                    <x-admin.input
                        type="datetime-local"
                        id="published_at"
                        name="published_at"
                        value="{{ old('published_at', isset($news->published_at) ? $news->published_at->format('Y-m-d\TH:i') : '') }}"
                    />
                    @error('published_at') <p class="text-sm text-destructive mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-2">
                    <x-admin.button type="submit" variant="default" class="flex-1">
                        {{ isset($news) ? 'Perbarui' : 'Publikasikan' }}
                    </x-admin.button>
                </div>
            </div>
        </x-admin.card>

        {{-- SEO --}}
        <x-admin.card>
            <x-slot:header>
                <h3 class="text-lg font-semibold text-foreground">SEO & Metadata</h3>
            </x-slot:header>

            <div class="space-y-4">
                <div>
                    <label for="meta_description" class="block text-sm font-medium text-foreground mb-1">Meta Description</label>
                    <x-admin.textarea
                        id="meta_description"
                        name="meta_description"
                        placeholder="Deskripsi untuk mesin pencari (maks 160 karakter)"
                        rows="3"
                    >{{ old('meta_description', $news->meta_description ?? '') }}</x-admin.textarea>
                    @error('meta_description') <p class="text-sm text-destructive mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="tags" class="block text-sm font-medium text-foreground mb-1">Tags</label>
                    <x-admin.input
                        type="text"
                        id="tags"
                        name="tags"
                        value="{{ old('tags', $news->tags ?? '') }}"
                        placeholder="tag1, tag2, tag3"
                    />
                    @error('tags') <p class="text-sm text-destructive mt-1">{{ $message }}</p> @enderror
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
        const response = await fetch(`/admin/news/images/${imageId}`, {
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
