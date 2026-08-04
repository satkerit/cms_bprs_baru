@php
    $inputClass = 'w-full rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 text-slate-900 dark:text-slate-100';
    $labelClass = 'block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1';
    $old = fn($field, $default = null) => old($field, $auction?->{$field} ?? $default);
@endphp

{{-- ==================== SEKSI 1: INFORMASI DASAR ==================== --}}
<x-admin.card title="Informasi Dasar">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

        {{-- Judul --}}
        <div class="md:col-span-2">
            <label class="{{ $labelClass }}">Judul Lelang <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ $old('title') }}" required
                placeholder="cth: Rumah Tinggal 2 Lantai di Pangkalpinang"
                class="{{ $inputClass }} @error('title') border-red-400 @enderror">
            @error('title') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        {{-- Nomor Lelang --}}
        <div>
            <label class="{{ $labelClass }}">Nomor Lelang <span class="text-red-500">*</span></label>
            <input type="text" name="auction_number" value="{{ $old('auction_number') }}" required
                placeholder="cth: LLG-2024-001"
                class="{{ $inputClass }} @error('auction_number') border-red-400 @enderror">
            @error('auction_number') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        {{-- Status --}}
        <div>
            <label class="{{ $labelClass }}">Status <span class="text-red-500">*</span></label>
            <select name="status" required class="{{ $inputClass }} @error('status') border-red-400 @enderror">
                <option value="">-- Pilih Status --</option>
                @foreach(\App\Enums\AuctionStatus::cases() as $s)
                    <option value="{{ $s->value }}" @selected($old('status') === $s->value)>{{ $s->label() }}</option>
                @endforeach
            </select>
            @error('status') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        {{-- Jenis Aset --}}
        <div>
            <label class="{{ $labelClass }}">Jenis Aset <span class="text-red-500">*</span></label>
            <select name="asset_type" required class="{{ $inputClass }} @error('asset_type') border-red-400 @enderror">
                <option value="">-- Pilih Jenis Aset --</option>
                @foreach(\App\Enums\AssetType::cases() as $a)
                    <option value="{{ $a->value }}" @selected($old('asset_type') === $a->value)>{{ $a->label() }}</option>
                @endforeach
            </select>
            @error('asset_type') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        {{-- Unggulan --}}
        <div class="flex items-center gap-3">
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="hidden" name="is_featured" value="0">
                <input type="checkbox" name="is_featured" value="1"
                    @if($old('is_featured', false)) checked @endif
                    class="sr-only peer">
                <div class="w-11 h-6 bg-slate-200 dark:bg-slate-700 peer-focus:ring-2 peer-focus:ring-emerald-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
            </label>
            <span class="text-sm text-slate-700 dark:text-slate-300">Tandai sebagai Unggulan</span>
        </div>

        {{-- Deskripsi --}}
        <div class="md:col-span-2">
            <label class="{{ $labelClass }}">Deskripsi</label>
            <textarea name="description" rows="5"
                placeholder="Deskripsi lengkap tentang aset lelang..."
                class="{{ $inputClass }} @error('description') border-red-400 @enderror">{{ $old('description') }}</textarea>
            @error('description') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

    </div>
</x-admin.card>

{{-- ==================== SEKSI 2: DETAIL ASET ==================== --}}
<x-admin.card title="Detail Aset">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

        {{-- Jenis Sertifikat --}}
        <div>
            <label class="{{ $labelClass }}">Jenis Sertifikat</label>
            <select name="certificate_type" class="{{ $inputClass }}">
                <option value="">-- Pilih Sertifikat --</option>
                @foreach(\App\Enums\CertificateType::cases() as $c)
                    <option value="{{ $c->value }}" @selected($old('certificate_type') === $c->value)>{{ $c->label() }}</option>
                @endforeach
            </select>
        </div>

        {{-- Nomor Sertifikat --}}
        <div>
            <label class="{{ $labelClass }}">Nomor Sertifikat</label>
            <input type="text" name="certificate_number" value="{{ $old('certificate_number') }}"
                placeholder="cth: 1234/SHM/2020"
                class="{{ $inputClass }}">
        </div>

        {{-- Luas Tanah --}}
        <div>
            <label class="{{ $labelClass }}">Luas Tanah (m²)</label>
            <input type="number" name="land_area" value="{{ $old('land_area') }}"
                min="0" step="0.01" placeholder="cth: 120"
                class="{{ $inputClass }}">
        </div>

        {{-- Luas Bangunan --}}
        <div>
            <label class="{{ $labelClass }}">Luas Bangunan (m²)</label>
            <input type="number" name="building_area" value="{{ $old('building_area') }}"
                min="0" step="0.01" placeholder="cth: 90"
                class="{{ $inputClass }}">
        </div>

        {{-- Alamat --}}
        <div class="md:col-span-2">
            <label class="{{ $labelClass }}">Alamat <span class="text-red-500">*</span></label>
            <input type="text" name="address" value="{{ $old('address') }}" required
                placeholder="Jl. Contoh No. 1, Kelurahan, Kecamatan"
                class="{{ $inputClass }} @error('address') border-red-400 @enderror">
            @error('address') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        {{-- Kota --}}
        <div>
            <label class="{{ $labelClass }}">Kota / Kabupaten</label>
            <input type="text" name="city" value="{{ $old('city') }}"
                placeholder="cth: Pangkalpinang"
                class="{{ $inputClass }}">
        </div>

        {{-- Provinsi --}}
        <div>
            <label class="{{ $labelClass }}">Provinsi</label>
            <input type="text" name="province" value="{{ $old('province') }}"
                placeholder="cth: Kep. Bangka Belitung"
                class="{{ $inputClass }}">
        </div>

    </div>
</x-admin.card>

{{-- ==================== SEKSI 3: PELAKSANAAN LELANG ==================== --}}
<x-admin.card title="Pelaksanaan Lelang">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

        {{-- Tanggal Lelang --}}
        <div>
            <label class="{{ $labelClass }}">Tanggal Lelang <span class="text-red-500">*</span></label>
            <input type="date" name="auction_date"
                value="{{ $auction?->auction_date ? $auction->auction_date->format('Y-m-d') : old('auction_date') }}"
                required
                class="{{ $inputClass }} @error('auction_date') border-red-400 @enderror">
            @error('auction_date') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        {{-- Waktu Lelang --}}
        <div>
            <label class="{{ $labelClass }}">Waktu Lelang</label>
            <input type="time" name="auction_time"
                value="{{ $old('auction_time', $auction?->auction_time) }}"
                class="{{ $inputClass }}">
        </div>

        {{-- Lokasi Lelang --}}
        <div class="md:col-span-2">
            <label class="{{ $labelClass }}">Lokasi / Tempat Lelang</label>
            <input type="text" name="auction_location"
                value="{{ $old('auction_location', $auction?->auction_location) }}"
                placeholder="cth: Kantor KPKNL Pangkalpinang / Online via url"
                class="{{ $inputClass }}">
        </div>

        {{-- Tipe Lelang --}}
        <div>
            <label class="{{ $labelClass }}">Tipe Lelang</label>
            <select name="auction_type" class="{{ $inputClass }}">
                <option value="">-- Pilih Tipe --</option>
                @foreach(\App\Enums\AuctionType::cases() as $t)
                    <option value="{{ $t->value }}" @selected($old('auction_type', $auction?->auction_type) === $t->value)>{{ $t->label() }}</option>
                @endforeach
            </select>
        </div>

        {{-- Metode Lelang --}}
        <div>
            <label class="{{ $labelClass }}">Metode Pelaksanaan</label>
            <select name="auction_method" class="{{ $inputClass }}">
                <option value="">-- Pilih Metode --</option>
                @foreach([
                    'open_bidding'    => 'Open Bidding (Terbuka)',
                    'closed_bidding'  => 'Closed Bidding (Tertutup)',
                    'email'           => 'Penawaran via Email',
                    'internet'        => 'Lelang Internet',
                    'langsung'        => 'Tatap Muka / Langsung',
                ] as $val => $lbl)
                    <option value="{{ $val }}" @selected($old('auction_method', $auction?->auction_method) === $val)>{{ $lbl }}</option>
                @endforeach
            </select>
        </div>

        {{-- Harga Limit --}}
        <div>
            <label class="{{ $labelClass }}">Harga Limit (Rp) <span class="text-red-500">*</span></label>
            <input type="number" name="limit_price" value="{{ $old('limit_price', $auction?->limit_price) }}"
                min="0" step="1" required
                placeholder="cth: 500000000"
                class="{{ $inputClass }} @error('limit_price') border-red-400 @enderror">
            @error('limit_price') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        {{-- Harga Estimasi --}}
        <div>
            <label class="{{ $labelClass }}">Harga Estimasi (Rp)</label>
            <input type="number" name="estimated_price" value="{{ $old('estimated_price', $auction?->estimated_price) }}"
                min="0" step="1"
                placeholder="cth: 600000000"
                class="{{ $inputClass }}">
        </div>

        {{-- Uang Jaminan --}}
        <div>
            <label class="{{ $labelClass }}">Uang Jaminan Penawaran (Rp)</label>
            <input type="number" name="deposit_amount" value="{{ $old('deposit_amount', $auction?->deposit_amount) }}"
                min="0" step="1"
                placeholder="cth: 50000000"
                class="{{ $inputClass }}">
        </div>

    </div>
</x-admin.card>

{{-- ==================== SEKSI 4: KONTAK & MEDIA ==================== --}}
<x-admin.card title="Kontak & Media">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

        {{-- Contact Person --}}
        <div class="md:col-span-2">
            <label class="{{ $labelClass }}">Nama Contact Person</label>
            <input type="text" name="contact_person" value="{{ $old('contact_person', $auction?->contact_person) }}"
                placeholder="cth: Budi Santoso"
                class="{{ $inputClass }}">
        </div>

        {{-- Telepon --}}
        <div>
            <label class="{{ $labelClass }}">Nomor Telepon</label>
            <input type="text" name="contact_phone" value="{{ $old('contact_phone', $auction?->contact_phone) }}"
                placeholder="cth: 0821-xxxx-xxxx"
                class="{{ $inputClass }}">
        </div>

        {{-- WhatsApp --}}
        <div>
            <label class="{{ $labelClass }}">Nomor WhatsApp</label>
            <input type="text" name="contact_whatsapp" value="{{ $old('contact_whatsapp', $auction?->contact_whatsapp) }}"
                placeholder="cth: 628xx (format internasional)"
                class="{{ $inputClass }}">
        </div>

        {{-- Upload Foto --}}
        <div class="md:col-span-2">
            <label class="{{ $labelClass }}">Upload Foto Aset</label>
            <input type="file" name="images[]" multiple accept="image/*"
                class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-emerald-50 file:text-emerald-700 dark:file:bg-emerald-900/30 dark:file:text-emerald-400 hover:file:bg-emerald-100 cursor-pointer">
            <p class="mt-1 text-xs text-slate-500">Format: JPEG, PNG, WebP. Maksimal 5MB per file.</p>
            @error('images.*') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        {{-- Preview gambar existing (saat edit) --}}
        @if($auction && is_array($auction->images) && count($auction->images))
        <div class="md:col-span-2">
            <label class="{{ $labelClass }}">Foto Saat Ini</label>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 mt-1">
                @foreach($auction->images as $i => $img)
                    @php $url = $auction->thumbnailUrl($i) ?: $auction->imageUrl($i); @endphp
                    @if($url)
                    <div class="relative group rounded-xl overflow-hidden bg-slate-100 dark:bg-slate-800 aspect-video">
                        <img src="{{ $url }}" alt="Foto {{ $i+1 }}" class="w-full h-full object-cover">
                        <label class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer">
                            <input type="checkbox" name="delete_images[]" value="{{ $img }}"
                                class="sr-only peer">
                            <div class="peer-checked:bg-red-500 bg-white/20 border-2 border-white rounded-full w-7 h-7 flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </div>
                            <span class="ml-1.5 text-white text-xs font-medium">Hapus</span>
                        </label>
                    </div>
                    @endif
                @endforeach
            </div>
            <p class="mt-1.5 text-xs text-slate-500">Centang foto untuk menghapusnya saat menyimpan.</p>
        </div>
        @endif

    </div>
</x-admin.card>

{{-- ==================== SEKSI 5: HASIL LELANG (hanya tampil saat status=sold) ==================== --}}
<div x-data="{ status: '{{ $old('status', $auction?->status?->value) }}' }" x-show="status === 'sold'" x-transition>
    <x-admin.card title="Hasil Lelang">
        <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Isi bagian ini setelah lelang berhasil terjual.</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div>
                <label class="{{ $labelClass }}">Harga Menang (Rp)</label>
                <input type="number" name="winning_bid"
                    value="{{ $old('winning_bid', $auction?->winning_bid) }}"
                    min="0" step="1"
                    placeholder="cth: 550000000"
                    class="{{ $inputClass }}">
            </div>
            <div>
                <label class="{{ $labelClass }}">Nama Pemenang</label>
                <input type="text" name="winner_name"
                    value="{{ $old('winner_name', $auction?->winner_name) }}"
                    placeholder="Nama peserta pemenang"
                    class="{{ $inputClass }}">
            </div>
            <div>
                <label class="{{ $labelClass }}">Tanggal Terjual</label>
                <input type="date" name="sold_at"
                    value="{{ $auction?->sold_at ? $auction->sold_at->format('Y-m-d') : old('sold_at') }}"
                    class="{{ $inputClass }}">
            </div>
        </div>
    </x-admin.card>
</div>

{{-- Listen perubahan status untuk show/hide seksi hasil lelang via Alpine dispatch --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const statusSelect = document.querySelector('select[name="status"]');
        if (!statusSelect) return;
        statusSelect.addEventListener('change', function () {
            statusSelect.dispatchEvent(new Event('input', { bubbles: true }));
        });
    });
</script>
@endpush
