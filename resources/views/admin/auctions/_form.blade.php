@php
    $isEdit = isset($auction) && $auction->exists;
    $model = $isEdit ? $auction : null;
    $inputClass = 'w-full rounded-xl border border-zinc-300 dark:border-zinc-600 px-4 py-2.5 text-sm bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-emerald-500';
    $labelClass = 'block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1.5';
    $sectionHeader = 'text-sm font-semibold text-zinc-900 dark:text-zinc-100';
    function auctionValue($model, $key, $default = '') {
        if ($model) {
            $v = $model->{$key} ?? $default;
            if ($key === 'auction_time' && $v) return \Carbon\Carbon::parse($v)->format('H:i');
            if (in_array($key, ['auction_date','certificate_date','featured_until']) && $v) return \Carbon\Carbon::parse($v)->format('Y-m-d');
            return $v ?? $default;
        }
        return old($key, $default);
    }
@endphp

<div class="space-y-6" x-data="auctionForm('{{ request()->routeIs('admin.auctions.edit') ? 'edit' : 'create' }}')">

    @if($isEdit && !empty($model->images))
    <x-admin.card title="Gambar Saat Ini">
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
            @foreach($model->images as $idx => $img)
            @php $imgUrl = \App\Helpers\StorageHelper::url($img); @endphp
            <div class="relative rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden"
                :class="deleted[{{ $idx }}] ? 'ring-2 ring-red-500 opacity-60' : ''">
                <img src="{{ $imgUrl }}" alt="" class="w-full h-28 object-cover">
                {{-- Tombol hapus selalu terlihat --}}
                <button type="button" @click="toggleDelete({{ $idx }})"
                    :title="deleted[{{ $idx }}] ? 'Batalkan penghapusan' : 'Hapus gambar'"
                    class="absolute top-1.5 left-1.5 p-1.5 rounded-full transition-colors"
                    :class="deleted[{{ $idx }}] ? 'bg-emerald-500 text-white hover:bg-emerald-600' : 'bg-white/90 text-red-600 shadow-sm hover:bg-red-500 hover:text-white dark:bg-zinc-800/90'">
                    <svg x-show="deleted[{{ $idx }}]" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <svg x-show="!deleted[{{ $idx }}]" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
                {{-- Overlay besar saat hover / ditandai hapus --}}
                <button type="button"
                    @click="toggleDelete({{ $idx }})"
                    class="absolute inset-0 flex items-center justify-center font-semibold text-xs transition-all"
                    :class="deleted[{{ $idx }}] ? 'bg-red-500/70 text-white' : 'bg-red-500/0 text-transparent hover:bg-red-500/60 hover:text-white'">
                    <span x-show="deleted[{{ $idx }}]">Batal Hapus</span>
                    <span x-show="!deleted[{{ $idx }}]">Hapus</span>
                </button>
                <input type="hidden" name="deleted_images[]" value="{{ $img }}" :disabled="!deleted[{{ $idx }}]">
                <span class="absolute top-2 right-2 px-1.5 py-0.5 rounded bg-zinc-900/60 text-white text-[10px]">#{{ $idx+1 }}</span>
            </div>
            @endforeach
        </div>
        <p class="mt-3 text-xs text-zinc-500 dark:text-zinc-400">Klik ikon tempat sampah untuk menandai penghapusan. Gambar yang ditandai dihapus permanen setelah tombol "Simpan Perubahan".</p>
    </x-admin.card>
    @endif

    {{-- ═══════════ 1. INFORMASI DASAR ═══════════ --}}
    <x-admin.card title="Informasi Dasar">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div>
                <label class="{{ $labelClass }}">Judul Lelang <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ auctionValue($model, 'title') }}" required class="{{ $inputClass }}" placeholder="Contoh: Rumah Tinggal SHM di Pangkalpinang">
            </div>
            <div>
                <label class="{{ $labelClass }}">Nomor Lelang <span class="text-red-500">*</span></label>
                <input type="text" name="auction_number" value="{{ auctionValue($model, 'auction_number') }}" required class="{{ $inputClass }}" placeholder="Contoh: 012/2026/BBN-II">
            </div>
            <div>
                <label class="{{ $labelClass }}">Status <span class="text-red-500">*</span></label>
                <select name="status" class="{{ $inputClass }}">
                    @foreach($statuses as $s)
                        <option value="{{ $s->value }}" @selected(auctionValue($model, 'status', 'draft') === $s->value)>{{ $s->label() }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mt-5">
            <label class="{{ $labelClass }}">Deskripsi Singkat</label>
            <textarea name="description" rows="3" class="{{ $inputClass }} resize-none" placeholder="Ringkasan singkat objek lelang yang ditampilkan di halaman publik.">{{ auctionValue($model, 'description') }}</textarea>
        </div>
    </x-admin.card>

    {{-- ═══════════ 2. DETAIL ASET ═══════════ --}}
    <x-admin.card title="Detail Aset">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div>
                <label class="{{ $labelClass }}">Tipe Aset <span class="text-red-500">*</span></label>
                <select name="asset_type" class="{{ $inputClass }}">
                    @foreach($assetTypes as $type)
                        <option value="{{ $type }}" @selected(auctionValue($model, 'asset_type') === $type)>{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="{{ $labelClass }}">Luas Tanah (m²)</label>
                <input type="number" step="0.01" name="land_area" value="{{ auctionValue($model, 'land_area') }}" class="{{ $inputClass }}">
            </div>
            <div>
                <label class="{{ $labelClass }}">Luas Bangunan (m²)</label>
                <input type="number" step="0.01" name="building_area" value="{{ auctionValue($model, 'building_area') }}" class="{{ $inputClass }}">
            </div>
            <div>
                <label class="{{ $labelClass }}">Kondisi Bangunan</label>
                <input type="text" name="building_condition" value="{{ auctionValue($model, 'building_condition') }}" class="{{ $inputClass }}" placeholder="Bagus, Sedang, dll">
            </div>
            <div>
                <label class="{{ $labelClass }}">Jenis Sertifikat</label>
                <select name="certificate_type" class="{{ $inputClass }}">
                    <option value="">Pilih</option>
                    @foreach(['SHM','SHGB','SHP','AJB','PPJB','Girik','BPKB','Lainnya'] as $ct)
                        <option value="{{ $ct }}" @selected(auctionValue($model, 'certificate_type') === $ct)>{{ $ct }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="{{ $labelClass }}">Nomor Sertifikat</label>
                <input type="text" name="certificate_number" value="{{ auctionValue($model, 'certificate_number') }}" class="{{ $inputClass }}">
            </div>
        </div>
        <div class="mt-5">
            <label class="{{ $labelClass }}">Deskripsi Aset</label>
            <textarea name="asset_description" rows="4" class="{{ $inputClass }} resize-none" placeholder="Kondisi fisik, spesifikasi, dan hal penting lain tentang objek lelang.">{{ auctionValue($model, 'asset_description') }}</textarea>
        </div>
    </x-admin.card>

    {{-- ═══════════ 3. LOKASI ASET ═══════════ --}}
    <x-admin.card title="Lokasi Aset">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="md:col-span-3">
                <label class="{{ $labelClass }}">Alamat Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="address" value="{{ auctionValue($model, 'address') }}" required class="{{ $inputClass }}">
            </div>
            <div>
                <label class="{{ $labelClass }}">Kelurahan</label>
                <input type="text" name="village" value="{{ auctionValue($model, 'village') }}" class="{{ $inputClass }}">
            </div>
            <div>
                <label class="{{ $labelClass }}">Kecamatan</label>
                <input type="text" name="district" value="{{ auctionValue($model, 'district') }}" class="{{ $inputClass }}">
            </div>
            <div>
                <label class="{{ $labelClass }}">Kota/Kabupaten</label>
                <input type="text" name="city" value="{{ auctionValue($model, 'city') }}" class="{{ $inputClass }}">
            </div>
            <div>
                <label class="{{ $labelClass }}">Provinsi</label>
                <input type="text" name="province" value="{{ auctionValue($model, 'province') }}" class="{{ $inputClass }}">
            </div>
            <div>
                <label class="{{ $labelClass }}">Kode Pos</label>
                <input type="text" name="postal_code" value="{{ auctionValue($model, 'postal_code') }}" class="{{ $inputClass }}">
            </div>
            <div>
                <label class="{{ $labelClass }}">Nama Debitur</label>
                <input type="text" name="debtor_name" value="{{ auctionValue($model, 'debtor_name') }}" class="{{ $inputClass }}" placeholder="Pemilik agunan">
            </div>
        </div>
    </x-admin.card>

    {{-- ═══════════ 4. INFORMASI LELANG ═══════════ --}}
    <x-admin.card title="Informasi Lelang">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div>
                <label class="{{ $labelClass }}">Jenis Lelang <span class="text-red-500">*</span></label>
                <select name="auction_type" class="{{ $inputClass }}">
                    @foreach(['eksekusi_hak_tanggungan' => 'Eksekusi Hak Tanggungan','eksekusi_fidusia' => 'Eksekusi Fidusia','eksekusi_hipotik' => 'Eksekusi Hipotik','non_eksekusi_wajib' => 'Non Eksekusi Wajib','non_eksekusi_sukarela' => 'Non Eksekusi Sukarela'] as $atVal => $atLabel)
                        <option value="{{ $atVal }}" @selected(auctionValue($model, 'auction_type', 'eksekusi_hak_tanggungan') === $atVal)>{{ $atLabel }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="{{ $labelClass }}">Tanggal Lelang</label>
                <input type="date" name="auction_date" value="{{ auctionValue($model, 'auction_date') }}" class="{{ $inputClass }}">
            </div>
            <div>
                <label class="{{ $labelClass }}">Waktu Lelang</label>
                <input type="time" name="auction_time" value="{{ auctionValue($model, 'auction_time') }}" class="{{ $inputClass }}">
            </div>
            <div>
                <label class="{{ $labelClass }}">Lokasi Pelaksanaan <span class="text-red-500">*</span></label>
                <input type="text" name="auction_location" value="{{ auctionValue($model, 'auction_location') }}" required class="{{ $inputClass }}" placeholder="Contoh: Kantor KPKNL Pangkalpinang">
            </div>
            <div>
                <label class="{{ $labelClass }}">URL Lelang (KPKNL)</label>
                <input type="url" name="auction_url" value="{{ auctionValue($model, 'auction_url') }}" class="{{ $inputClass }}" placeholder="https://...">
            </div>
            <div>
                <label class="{{ $labelClass }}">Penyelenggara</label>
                <input type="text" name="organizer_name" value="{{ auctionValue($model, 'organizer_name') }}" class="{{ $inputClass }}" placeholder="Contoh: KPKNL Pangkalpinang">
            </div>
        </div>
    </x-admin.card>

    {{-- ═══════════ 5. HARGA & JAMINAN ═══════════ --}}
    <x-admin.card title="Harga & Jaminan">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div>
                <label class="{{ $labelClass }}">Harga Limit (Rp)</label>
                <input type="text" name="limit_price" value="{{ auctionValue($model, 'limit_price') }}" class="{{ $inputClass }}" placeholder="500000000">
            </div>
            <div>
                <label class="{{ $labelClass }}">Harga Estimasi (Rp)</label>
                <input type="text" name="estimated_price" value="{{ auctionValue($model, 'estimated_price') }}" class="{{ $inputClass }}">
            </div>
            <div>
                <label class="{{ $labelClass }}">Uang Jaminan (Rp)</label>
                <input type="text" name="deposit_amount" value="{{ auctionValue($model, 'deposit_amount') }}" class="{{ $inputClass }}">
            </div>
        </div>
    </x-admin.card>

    {{-- ═══════════ 6. KONTAK ═══════════ --}}
    <x-admin.card title="Kontak" subtitle="Informasi kontak yang ditampilkan kepada publik untuk pertanyaan lelang">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div>
                <label class="{{ $labelClass }}">Nama Kontak Person</label>
                <input type="text" name="contact_name" value="{{ auctionValue($model, 'contact_name') }}" class="{{ $inputClass }}">
            </div>
            <div>
                <label class="{{ $labelClass }}">Telepon</label>
                <input type="text" name="contact_phone" value="{{ auctionValue($model, 'contact_phone') }}" class="{{ $inputClass }}">
            </div>
            <div>
                <label class="{{ $labelClass }}">Email</label>
                <input type="email" name="contact_email" value="{{ auctionValue($model, 'contact_email') }}" class="{{ $inputClass }}">
            </div>
        </div>
    </x-admin.card>

    {{-- ═══════════ 7. GAMBAR ASET ═══════════ --}}
    <x-admin.card title="Gambar Aset" subtitle="Opsional — bisa unggah banyak gambar sekaligus (format: JPEG/PNG/JPG/WebP)">
        <div>
            <div class="flex flex-wrap">
                <label class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border-2 border-dashed border-zinc-300 dark:border-zinc-600 text-zinc-600 dark:text-zinc-400 text-sm font-medium hover:border-emerald-500 hover:text-emerald-600 cursor-pointer transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    Pilih Gambar
                    <input type="file" name="images[]" accept="image/*" multiple class="sr-only" @change="images = Array.from($event.target.files)">
                </label>
                <span class="text-xs text-zinc-400 dark:text-zinc-500 self-center" x-text="images.length > 0 ? images.length + ' gambar dipilih' : 'Belum ada gambar dipilih'"></span>
            </div>
            <div class="mt-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                <template x-for="(img, i) in images" :key="img.name + i">
                    <div class="relative rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden aspect-square">
                        <img :src="URL.createObjectURL(img)" class="w-full h-full object-cover" alt="">
                        <button type="button" @click="images.splice(i, 1)"
                            class="absolute top-1.5 right-1.5 p-1 rounded-full bg-zinc-900/60 text-white hover:bg-red-500 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </x-admin.card>

    {{-- ═══════════ 8. PUBLIKASI ═══════════ --}}
    <x-admin.card title="Publikasi">
        <div class="space-y-5">
            <label class="flex items-center gap-2.5 cursor-pointer">
                <input type="checkbox" name="is_featured" value="1" @checked(auctionValue($model, 'is_featured')) class="rounded border-zinc-300 dark:border-zinc-600 text-emerald-600 focus:ring-emerald-500">
                <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Tampilkan di Unggulan</span>
            </label>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="{{ $labelClass }}">Meta Title</label>
                    <input type="text" name="meta_title" value="{{ auctionValue($model, 'meta_title') }}" class="{{ $inputClass }}">
                </div>
                <div>
                    <label class="{{ $labelClass }}">Meta Description</label>
                    <textarea name="meta_description" rows="3" class="{{ $inputClass }} resize-none">{{ auctionValue($model, 'meta_description') }}</textarea>
                </div>
            </div>
        </div>
    </x-admin.card>

    {{-- Submit --}}
    <div class="flex items-center justify-end gap-3 sticky bottom-4">
        <a href="{{ route('admin.auctions.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 text-sm font-semibold hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">
            Batal
        </a>
        <x-admin.button type="submit" variant="default">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Lelang' }}
        </x-admin.button>
    </div>

    <input type="hidden" name="published_at" value="{{ auctionValue($model, 'published_at') ? \Carbon\Carbon::parse($model->published_at)->format('Y-m-d H:i:s') : now() }}">
</div>

@push('scripts')
<script nonce="{{ $nonce }}">
    function auctionForm(mode) {
        return {
            images: [],
            deleted: [],
            toggleDelete(idx) {
                this.deleted[idx] = !this.deleted[idx];
            }
        };
    }
</script>
@endpush
