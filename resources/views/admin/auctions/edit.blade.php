@extends('layouts.admin')

@section('title', 'Edit Lelang Agunan')

@section('content')
<x-admin.page-header title="Edit Lelang Agunan" subtitle="Perbarui informasi lelang agunan">
    <x-slot:actions>
        <x-admin.button href="{{ route('admin.auctions.index') }}" variant="secondary" icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>'>
            Kembali
        </x-admin.button>
    </x-slot:actions>
</x-admin.page-header>

@if(session('error'))
    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-[13px] flex items-center gap-2 shadow-sm">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <span>{{ session('error') }}</span>
    </div>
@endif

<form method="POST" action="{{ route('admin.auctions.update', $auction) }}" enctype="multipart/form-data" id="auction-form">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- 1. Informasi Utama Agunan --}}
            <x-admin.card title="Informasi Utama Agunan" subtitle="Data dasar objek lelang">
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="title" class="block text-[13px] font-semibold text-zinc-700 dark:text-slate-300 mb-1.5">
                                Judul Lelang / Nama Agunan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" id="title" value="{{ old('title', $auction->title) }}"
                                   class="w-full px-4 py-2 border dark:border-slate-700 border-zinc-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors text-sm @error('title') border-red-500 @enderror"
                                   required placeholder="Contoh: Rumah Tinggal 2 Lantai Strategis">
                            @error('title')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="auction_number" class="block text-[13px] font-semibold text-zinc-700 dark:text-slate-300 mb-1.5">
                                Nomor Lelang / Objek <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="auction_number" id="auction_number" value="{{ old('auction_number', $auction->auction_number) }}"
                                   class="w-full px-4 py-2 border dark:border-slate-700 border-zinc-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors text-sm @error('auction_number') border-red-500 @enderror"
                                   required placeholder="Contoh: LA-2026-001">
                            @error('auction_number')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="asset_type" class="block text-[13px] font-semibold text-zinc-700 dark:text-slate-300 mb-1.5">
                                Jenis Aset <span class="text-red-500">*</span>
                            </label>
                            <select name="asset_type" id="asset_type" class="w-full px-4 py-2 border dark:border-slate-700 border-zinc-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors text-sm @error('asset_type') border-red-500 @enderror" required>
                                <option value="">Pilih Jenis Aset</option>
                                @foreach(\App\Enums\AssetType::cases() as $assetType)
                                    <option value="{{ $assetType->value }}" {{ old('asset_type', $auction->asset_type) === $assetType->value ? 'selected' : '' }}>
                                        {{ $assetType->label() }}
                                    </option>
                                @endforeach
                            </select>
                            @error('asset_type')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="city" class="block text-[13px] font-semibold text-zinc-700 dark:text-slate-300 mb-1.5">Kota / Kabupaten</label>
                            <input type="text" name="city" id="city" value="{{ old('city', $auction->city) }}"
                                   class="w-full px-4 py-2 border dark:border-slate-700 border-zinc-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors text-sm @error('city') border-red-500 @enderror"
                                   placeholder="Contoh: Pangkalpinang">
                            @error('city')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="address" class="block text-[13px] font-semibold text-zinc-700 dark:text-slate-300 mb-1.5">
                            Alamat Lengkap Aset <span class="text-red-500">*</span>
                        </label>
                        <textarea name="address" id="address" rows="2"
                                  class="w-full px-4 py-2 border dark:border-slate-700 border-zinc-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors resize-none text-sm @error('address') border-red-500 @enderror"
                                  required placeholder="Alamat lengkap lokasi agunan...">{{ old('address', $auction->address) }}</textarea>
                        @error('address')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-[13px] font-semibold text-zinc-700 dark:text-slate-300 mb-1.5">Deskripsi / Keterangan Agunan</label>
                        <textarea name="description" id="description" rows="4"
                                  class="w-full px-4 py-2 border dark:border-slate-700 border-zinc-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors resize-y text-sm @error('description') border-red-500 @enderror"
                                  placeholder="Jelaskan kondisi agunan, batas wilayah, fasilitas sekitar, atau informasi penting lainnya...">{{ old('description', $auction->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-admin.card>

            {{-- 2. Detail Spesifikasi & Legalitas --}}
            <x-admin.card title="Spesifikasi & Legalitas" subtitle="Detail luas dan dokumen sertifikat">
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="certificate_type" class="block text-[13px] font-semibold text-zinc-700 dark:text-slate-300 mb-1.5">Jenis Sertifikat</label>
                            <select name="certificate_type" id="certificate_type" class="w-full px-4 py-2 border dark:border-slate-700 border-zinc-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors text-sm @error('certificate_type') border-red-500 @enderror">
                                <option value="">Pilih Jenis Sertifikat</option>
                                @foreach(\App\Enums\CertificateType::cases() as $certType)
                                    <option value="{{ $certType->value }}" {{ old('certificate_type', $auction->certificate_type) === $certType->value ? 'selected' : '' }}>
                                        {{ $certType->label() }}
                                    </option>
                                @endforeach
                            </select>
                            @error('certificate_type')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="certificate_number" class="block text-[13px] font-semibold text-zinc-700 dark:text-slate-300 mb-1.5">Nomor Sertifikat</label>
                            <input type="text" name="certificate_number" id="certificate_number" value="{{ old('certificate_number', $auction->certificate_number) }}"
                                   class="w-full px-4 py-2 border dark:border-slate-700 border-zinc-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors text-sm @error('certificate_number') border-red-500 @enderror"
                                   placeholder="Contoh: SHM No. 1234 / Pangkalpinang">
                            @error('certificate_number')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="land_area" class="block text-[13px] font-semibold text-zinc-700 dark:text-slate-300 mb-1.5">Luas Tanah (m²)</label>
                            <input type="number" name="land_area" id="land_area" value="{{ old('land_area', $auction->land_area) }}"
                                   class="w-full px-4 py-2 border dark:border-slate-700 border-zinc-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors text-sm @error('land_area') border-red-500 @enderror"
                                   step="0.01" placeholder="Misal: 150">
                            @error('land_area')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="building_area" class="block text-[13px] font-semibold text-zinc-700 dark:text-slate-300 mb-1.5">Luas Bangunan (m²)</label>
                            <input type="number" name="building_area" id="building_area" value="{{ old('building_area', $auction->building_area) }}"
                                   class="w-full px-4 py-2 border dark:border-slate-700 border-zinc-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors text-sm @error('building_area') border-red-500 @enderror"
                                   step="0.01" placeholder="Misal: 90 (isi 0 jika berupa tanah)">
                            @error('building_area')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </x-admin.card>

            {{-- 3. Informasi Harga & Uang Jaminan --}}
            <x-admin.card title="Harga & Uang Jaminan" subtitle="Penetapan nilai limit lelang">
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="limit_price" class="block text-[13px] font-semibold text-zinc-700 dark:text-slate-300 mb-1.5">Harga Limit / Pokok (Rp)</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-zinc-500 font-medium text-xs">Rp</span>
                                <input type="number" name="limit_price" id="limit_price" value="{{ old('limit_price', $auction->limit_price) }}"
                                       class="w-full pl-10 pr-4 py-2 border dark:border-slate-700 border-zinc-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors text-sm @error('limit_price') border-red-500 @enderror"
                                       placeholder="Contoh: 500000000">
                            </div>
                            @error('limit_price')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="deposit_amount" class="block text-[13px] font-semibold text-zinc-700 dark:text-slate-300 mb-1.5">Uang Jaminan (Rp)</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-zinc-500 font-medium text-xs">Rp</span>
                                <input type="number" name="deposit_amount" id="deposit_amount" value="{{ old('deposit_amount', $auction->deposit_amount) }}"
                                       class="w-full pl-10 pr-4 py-2 border dark:border-slate-700 border-zinc-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors text-sm @error('deposit_amount') border-red-500 @enderror"
                                       placeholder="Contoh: 100000000">
                            </div>
                            @error('deposit_amount')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </x-admin.card>

            {{-- 4. Pelaksanaan Lelang --}}
            <x-admin.card title="Pelaksanaan Lelang" subtitle="Jadwal, tempat, dan link informasi resmi">
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="auction_date" class="block text-[13px] font-semibold text-zinc-700 dark:text-slate-300 mb-1.5">Tanggal & Waktu Lelang</label>
                            <input type="datetime-local" name="auction_date" id="auction_date" value="{{ old('auction_date', $auction->auction_date ? $auction->auction_date->format('Y-m-d\TH:i') : '') }}"
                                   class="w-full px-4 py-2 border dark:border-slate-700 border-zinc-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors text-sm @error('auction_date') border-red-500 @enderror">
                            @error('auction_date')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="auction_type" class="block text-[13px] font-semibold text-zinc-700 dark:text-slate-300 mb-1.5">Jenis Lelang <span class="text-red-500">*</span></label>
                            <select name="auction_type" id="auction_type" class="w-full px-4 py-2 border dark:border-slate-700 border-zinc-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors text-sm @error('auction_type') border-red-500 @enderror" required>
                                <option value="">Pilih Jenis Lelang</option>
                                @foreach(\App\Enums\AuctionType::cases() as $aType)
                                    <option value="{{ $aType->value }}" {{ old('auction_type', $auction->auction_type) === $aType->value ? 'selected' : '' }}>
                                        {{ $aType->label() }}
                                    </option>
                                @endforeach
                            </select>
                            @error('auction_type')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="auction_location" class="block text-[13px] font-semibold text-zinc-700 dark:text-slate-300 mb-1.5">Penyelenggara / Tempat Lelang <span class="text-red-500">*</span></label>
                            <input type="text" name="auction_location" id="auction_location" value="{{ old('auction_location', $auction->auction_location ?? 'KPKNL Pangkalpinang') }}"
                                   class="w-full px-4 py-2 border dark:border-slate-700 border-zinc-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors text-sm @error('auction_location') border-red-500 @enderror"
                                   required placeholder="Contoh: KPKNL Pangkalpinang / Office BPRS">
                            @error('auction_location')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="auction_url" class="block text-[13px] font-semibold text-zinc-700 dark:text-slate-300 mb-1.5">Link Lelang Resmi (Opsional)</label>
                            <input type="url" name="auction_url" id="auction_url" value="{{ old('auction_url', $auction->auction_url) }}"
                                   class="w-full px-4 py-2 border dark:border-slate-700 border-zinc-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors text-sm @error('auction_url') border-red-500 @enderror"
                                   placeholder="https://lelang.go.id/lot-lelang/...">
                            <p class="mt-1 text-[11px] text-zinc-400">Tautan jika ada pengumuman resmi di portal lelang.go.id</p>
                            @error('auction_url')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </x-admin.card>

            {{-- 5. Informasi Kontak Petugas --}}
            <x-admin.card title="Kontak Petugas & Informasi" subtitle="Petugas BPRS yang dapat dihubungi calon pembeli">
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="contact_person" class="block text-[13px] font-semibold text-zinc-700 dark:text-slate-300 mb-1.5">Nama Petugas / Contact Person</label>
                            <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person', $auction->contact_person) }}"
                                   class="w-full px-4 py-2 border dark:border-slate-700 border-zinc-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors text-sm @error('contact_person') border-red-500 @enderror"
                                   placeholder="Contoh: Tim Penyelamatan Agunan BPRS">
                            @error('contact_person')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="contact_whatsapp" class="block text-[13px] font-semibold text-zinc-700 dark:text-slate-300 mb-1.5">Nomor HP / WhatsApp (Aktif)</label>
                            <input type="text" name="contact_whatsapp" id="contact_whatsapp" value="{{ old('contact_whatsapp', $auction->contact_whatsapp) }}"
                                   class="w-full px-4 py-2 border dark:border-slate-700 border-zinc-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors text-sm @error('contact_whatsapp') border-red-500 @enderror"
                                   placeholder="Contoh: 081234567890">
                            @error('contact_whatsapp')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </x-admin.card>

            {{-- 6. Galeri Foto & Lampiran Dokumen --}}
            <x-admin.card title="Foto Aset & Lampiran" subtitle="Kelola foto aset dan brosur PDF">
                <div class="space-y-4">
                    @if($auction->images && count($auction->images) > 0)
                    <div>
                        <label class="block text-[13px] font-semibold text-zinc-700 dark:text-slate-300 mb-2">Foto Saat Ini</label>
                        <div class="grid grid-cols-4 sm:grid-cols-6 gap-3">
                            @foreach($auction->images as $img)
                            <div class="aspect-square rounded-lg overflow-hidden border border-zinc-200 dark:border-slate-700 relative group">
                                <img src="{{ \App\Helpers\StorageHelper::url($img) }}" class="w-full h-full object-cover">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div>
                        <label for="images" class="block text-[13px] font-semibold text-zinc-700 dark:text-slate-300 mb-1.5">Tambah / Ganti Foto Aset</label>
                        <input type="file" name="images[]" id="images" multiple accept="image/*"
                               class="w-full px-4 py-2 border dark:border-slate-700 border-zinc-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors text-sm bg-white dark:bg-slate-800">
                        <p class="mt-1 text-xs text-zinc-500">Unggah foto baru untuk menambah/memperbarui foto agunan</p>
                        @error('images')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-admin.card>

        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            <x-admin.card title="Status Publikasi">
                <div class="space-y-4">
                    <div>
                        <label for="status" class="block text-[13px] font-semibold text-zinc-700 dark:text-slate-300 mb-1.5">
                            Status Lelang <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status" class="w-full px-4 py-2.5 border dark:border-slate-700 border-zinc-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors text-sm @error('status') border-red-500 @enderror" required>
                            <option value="draft" {{ old('status', $auction->status) === 'draft' ? 'selected' : '' }}>Draft (Sembunyi)</option>
                            <option value="published" {{ old('status', $auction->status) === 'published' ? 'selected' : '' }}>Dipublikasi (Aktif)</option>
                            <option value="registration_open" {{ old('status', $auction->status) === 'registration_open' ? 'selected' : '' }}>Pendaftaran Dibuka</option>
                            <option value="sold" {{ old('status', $auction->status) === 'sold' ? 'selected' : '' }}>Terjual</option>
                            <option value="cancelled" {{ old('status', $auction->status) === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-2 border-t border-zinc-200 dark:border-slate-700">
                        <label class="relative flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $auction->is_featured) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-5 h-5 bg-zinc-200 dark:bg-slate-700 peer-focus:outline-none rounded-md peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-zinc-300 after:border after:rounded-md after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-600"></div>
                            <span class="text-xs font-semibold text-zinc-700 dark:text-slate-300">Tampilkan di Agunan Unggulan</span>
                        </label>
                    </div>

                    <div class="pt-4 space-y-2">
                        <button type="submit" class="w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-xl shadow-sm transition-colors flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Perbarui Lelang Agunan
                        </button>

                        <a href="{{ route('admin.auctions.index') }}" class="block w-full text-center py-2.5 px-4 bg-zinc-100 dark:bg-slate-800 hover:bg-zinc-200 text-zinc-700 dark:text-slate-300 font-semibold text-sm rounded-xl transition-colors">
                            Batal
                        </a>
                    </div>
                </div>
            </x-admin.card>
        </div>
    </div>
</form>
@endsection
