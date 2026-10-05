@extends('layouts.admin')

@section('title', 'Profil Perusahaan')

@section('content')
<x-admin.page-header title="Profil Perusahaan" subtitle="Kelola informasi dan profil perusahaan">
</x-admin.page-header>

{{-- Success --}}
@if (session('success'))
<div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800/60 rounded-xl flex items-start gap-3">
    <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center shrink-0">
        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </div>
    <span class="text-sm text-emerald-700 dark:text-emerald-300 font-medium">{{ session('success') }}</span>
</div>
@endif

{{-- Validation errors --}}
@if ($errors->any())
<div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/60 rounded-xl p-4">
    <div class="flex items-start gap-3">
        <div class="w-10 h-10 rounded-xl bg-red-100 dark:bg-red-900/40 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <div>
            <h4 class="text-sm font-semibold text-red-800 dark:text-red-200">Terjadi kesalahan validasi</h4>
            <ul class="mt-2 text-sm text-red-700 dark:text-red-300 list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

<form action="{{ route('admin.company-info.update') }}" method="POST" enctype="multipart/form-data"
    x-data="companyInfoForm()">
    @csrf
    @method('PUT')

    <div class="space-y-6">

        {{-- ============================================================
            1. INFORMASI DASAR
        ============================================================ --}}
        <x-admin.card>
            <x-slot:header>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-sm shadow-emerald-600/20">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100">Informasi Dasar</h3>
                </div>
            </x-slot:header>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-admin.input label="Nama Perusahaan" type="text" id="name" name="name"
                        value="{{ old('name', $company->name) }}" required />
                    @error('name') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-admin.input label="Tagline" type="text" id="tagline" name="tagline"
                        value="{{ old('tagline', $company->tagline) }}"
                        placeholder="contoh: Mitra Terpercaya Sejak Anda" />
                    @error('tagline') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-admin.input label="Tahun Berdiri" type="number" id="established_year" name="established_year"
                        value="{{ old('established_year', $company->established_year) }}"
                        min="1900" max="{{ date('Y') }}" />
                    @error('established_year') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <x-admin.textarea label="Deskripsi Perusahaan" id="description" name="description"
                        rows="4">{{ old('description', $company->description) }}</x-admin.textarea>
                    @error('description') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>
        </x-admin.card>

        {{-- ============================================================
            2. INFORMASI KONTAK
        ============================================================ --}}
        <x-admin.card>
            <x-slot:header>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-sky-500 to-sky-600 flex items-center justify-center shadow-sm shadow-sky-600/20">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100">Informasi Kontak</h3>
                </div>
            </x-slot:header>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <x-admin.textarea label="Alamat" id="address" name="address"
                        rows="3">{{ old('address', $company->address) }}</x-admin.textarea>
                    @error('address') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-admin.input label="Telepon" type="text" id="phone" name="phone"
                        value="{{ old('phone', $company->phone) }}" />
                    @error('phone') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-admin.input label="Fax" type="text" id="fax" name="fax"
                        value="{{ old('fax', $company->fax) }}" />
                    @error('fax') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-admin.input label="WhatsApp" type="text" id="whatsapp" name="whatsapp"
                        value="{{ old('whatsapp', $company->whatsapp) }}" placeholder="contoh: 6281234567890" />
                    @error('whatsapp') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-admin.input label="Website" type="url" id="website" name="website"
                        value="{{ old('website', $company->website) }}" placeholder="https://" />
                    @error('website') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-admin.input label="Email Utama" type="email" id="email" name="email"
                        value="{{ old('email', $company->email) }}" placeholder="info@perusahaan.com" />
                    @error('email') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-admin.input label="Email Kontak" type="email" id="email_contact" name="email_contact"
                        value="{{ old('email_contact', $company->email_contact) }}" placeholder="kontak@perusahaan.com" />
                    @error('email_contact') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-admin.input label="Email Pengaduan" type="email" id="email_complaint" name="email_complaint"
                        value="{{ old('email_complaint', $company->email_complaint) }}" placeholder="pengaduan@perusahaan.com" />
                    @error('email_complaint') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-admin.input label="Email Whistleblowing" type="email" id="email_whistleblowing" name="email_whistleblowing"
                        value="{{ old('email_whistleblowing', $company->email_whistleblowing) }}"
                        placeholder="whistleblowing@perusahaan.com" />
                    @error('email_whistleblowing') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>
        </x-admin.card>

        {{-- ============================================================
            3. ASET VISUAL
        ============================================================ --}}
        <x-admin.card>
            <x-slot:header>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center shadow-sm shadow-amber-600/20">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100">Aset Visual</h3>
                </div>
            </x-slot:header>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Logo Utama --}}
                <div>
                    <label class="block text-[13px] font-medium text-slate-700 dark:text-slate-300 mb-1.5">Logo Utama</label>
                    <x-file-upload
                        name="logo"
                        :current="$company->logo_url"
                        accept="image/*"
                        max-size="2048"
                        help="Format: JPG, PNG, SVG. Maksimal 2MB" />
                    @error('logo') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                {{-- Logo Footer --}}
                <div>
                    <label class="block text-[13px] font-medium text-slate-700 dark:text-slate-300 mb-1.5">Logo Footer</label>
                    <x-file-upload
                        name="logo_footer"
                        :current="$company->logo_footer_url"
                        accept="image/*"
                        max-size="2048"
                        help="Format: JPG, PNG, SVG. Maksimal 2MB" />
                    @error('logo_footer') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror

                    <div class="mt-4 space-y-3 p-3.5 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200/60 dark:border-slate-700">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="hidden" name="logo_footer_remove_bg" value="0">
                            <input type="checkbox" name="logo_footer_remove_bg" value="1"
                                {{ old('logo_footer_remove_bg', $company->logo_footer_remove_bg) ? 'checked' : '' }}
                                class="peer sr-only">
                            <div class="w-9 h-5 rounded-full bg-slate-200 dark:bg-slate-700 peer-checked:bg-gradient-to-r peer-checked:from-emerald-600 peer-checked:to-emerald-500 transition-colors duration-200 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all after:duration-200 peer-checked:after:translate-x-4 peer-checked:after:border-white relative shadow-sm"></div>
                            <span class="text-[13px] text-slate-700 dark:text-slate-300">Remove Background</span>
                        </label>

                        <div x-data="{ value: {{ old('logo_footer_opacity', $company->logo_footer_opacity ?? 100) }} }">
                            <label for="logo_footer_opacity" class="block text-[13px] text-slate-600 dark:text-slate-400 mb-1">Opacity Logo Footer (%)</label>
                            <div class="flex items-center gap-3">
                                <input type="range" name="logo_footer_opacity" id="logo_footer_opacity"
                                    min="0" max="100"
                                    x-model="value"
                                    class="flex-1 h-2 bg-slate-200 dark:bg-slate-700 rounded-xl appearance-none cursor-pointer accent-emerald-500">
                                <span x-text="value + '%'" class="text-[13px] font-semibold text-slate-700 dark:text-slate-300 w-12 text-right tabular-nums"></span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Favicon --}}
                <div>
                    <label class="block text-[13px] font-medium text-slate-700 dark:text-slate-300 mb-1.5">Favicon</label>
                    <x-file-upload
                        name="favicon"
                        :current="$company->favicon_url"
                        accept=".ico,.png,.jpg,.jpeg"
                        max-size="512"
                        help="Format: ICO, PNG. Maksimal 512KB" />
                    @error('favicon') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                {{-- Profile Image --}}
                <div>
                    <label class="block text-[13px] font-medium text-slate-700 dark:text-slate-300 mb-1.5">Gambar Profil</label>
                    <x-file-upload
                        name="profile_image"
                        :current="$company->profile_image_url"
                        accept="image/*"
                        max-size="5120"
                        help="Format: JPG, PNG, WebP. Maksimal 5MB" />
                    @error('profile_image') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                {{-- Organization Structure --}}
                <div class="md:col-span-2">
                    <label class="block text-[13px] font-medium text-slate-700 dark:text-slate-300 mb-1.5">Struktur Organisasi</label>
                    <x-file-upload
                        name="organization_structure"
                        :current="$company->organization_structure_url"
                        accept="image/*"
                        max-size="5120"
                        help="Format: JPG, PNG, WebP. Maksimal 5MB" />
                    @error('organization_structure') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>
        </x-admin.card>

        {{-- ============================================================
            4. PROFIL PERUSAHAAN (VISI, MISI, SEJARAH)
        ============================================================ --}}
        <x-admin.card>
            <x-slot:header>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-500 to-violet-600 flex items-center justify-center shadow-sm shadow-violet-600/20">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100">Profil Perusahaan</h3>
                </div>
            </x-slot:header>

            <div class="space-y-6">
                <div>
                    <x-admin.textarea label="Visi" id="vision" name="vision"
                        rows="3">{{ old('vision', $company->vision) }}</x-admin.textarea>
                    @error('vision') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                @php
                    $missionRaw = old('mission', $company->mission ?? '');
                    $missionPoints = collect(preg_split('/\r\n|\r|\n/', $missionRaw))
                        ->map(fn($m) => trim($m))
                        ->filter()
                        ->values()
                        ->map(fn($m) => ['text' => $m])
                        ->all();
                    if (empty($missionPoints)) { $missionPoints = [['text' => '']]; }
                @endphp
                <div x-data="missionPoints(@js($missionPoints))">
                    <label for="mission" class="block text-[13px] font-medium text-slate-700 dark:text-slate-300 mb-2">Misi</label>
                    <div class="space-y-2">
                        <template x-for="(point, i) in points" :key="i">
                            <div class="flex items-center gap-2">
                                <span class="shrink-0 w-9 h-9 rounded-lg bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 font-bold text-sm flex items-center justify-center border border-amber-100 dark:border-amber-800/40"
                                    x-text="String(i + 1).padStart(2, '0')"></span>
                                <input type="text" x-model="point.text"
                                    class="input flex-1"
                                    placeholder="Tulis poin misi">
                                <button type="button" x-show="points.length > 1" @click="points.splice(i, 1)"
                                    class="shrink-0 w-9 h-9 rounded-lg text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 border border-transparent hover:border-red-200 dark:hover:border-red-800/60 flex items-center justify-center transition-all"
                                    title="Hapus poin">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </template>
                    </div>
                    <button type="button" @click="points.push({ text: '' })"
                        class="mt-3 inline-flex items-center gap-1.5 text-sm font-medium text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Poin
                    </button>
                    <textarea name="mission" x-model="missionJoined" class="hidden"></textarea>
                    <p class="mt-2 text-xs text-slate-400 dark:text-slate-500 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Kelola poin misi satu per satu. Nomor otomatis ditambahkan oleh halaman depan.
                    </p>
                </div>

                <div>
                    <label for="summernote" class="block text-[13px] font-medium text-slate-700 dark:text-slate-300 mb-1.5">Sejarah</label>
                    <textarea name="history" id="summernote" rows="5"
                        class="input resize-y min-h-[300px]"
                        placeholder="Tulis sejarah perusahaan...">{{ old('history', $company->history) }}</textarea>
                    <p class="mt-1.5 text-xs text-slate-400 dark:text-slate-500 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Gunakan editor untuk memformat konten sejarah: paragraf, judul, daftar, teks tebal, dan lainnya.
                    </p>
                    @error('history') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>
        </x-admin.card>

        {{-- ============================================================
            5. STATISTIK
        ============================================================ --}}
        <x-admin.card>
            <x-slot:header>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center shadow-sm shadow-amber-600/20">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100">Statistik</h3>
                </div>
            </x-slot:header>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <x-admin.input label="Tahun Pengalaman" type="number" id="stat_years_experience" name="stat_years_experience"
                        value="{{ old('stat_years_experience', $company->stat_years_experience) }}" min="0" />
                    @error('stat_years_experience') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-admin.input label="Kantor Cabang" type="number" id="stat_branch_offices" name="stat_branch_offices"
                        value="{{ old('stat_branch_offices', $company->stat_branch_offices) }}" min="0" />
                    @error('stat_branch_offices') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-admin.input label="Total Aset" type="text" id="stat_total_assets" name="stat_total_assets"
                        value="{{ old('stat_total_assets', $company->stat_total_assets) }}"
                        placeholder="contoh: 150 Miliar" />
                    @error('stat_total_assets') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-admin.input label="Kantor Kas" type="number" id="stat_cash_offices" name="stat_cash_offices"
                        value="{{ old('stat_cash_offices', $company->stat_cash_offices) }}" min="0" />
                    @error('stat_cash_offices') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-admin.input label="Kas Keliling" type="number" id="stat_mobile_cash_offices" name="stat_mobile_cash_offices"
                        value="{{ old('stat_mobile_cash_offices', $company->stat_mobile_cash_offices) }}" min="0" />
                    @error('stat_mobile_cash_offices') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-admin.input label="Jumlah Pengunjung Legacy" type="number" id="legacy_visitor_count" name="legacy_visitor_count"
                        value="{{ old('legacy_visitor_count', $company->legacy_visitor_count) }}" min="0" />
                    @error('legacy_visitor_count') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>
        </x-admin.card>

        {{-- ============================================================
            6. MEDIA SOSIAL
        ============================================================ --}}
        <x-admin.card>
            <x-slot:header>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-rose-500 to-rose-600 flex items-center justify-center shadow-sm shadow-rose-600/20">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100">Media Sosial</h3>
                </div>
            </x-slot:header>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-admin.input label="Facebook" type="url" id="facebook" name="facebook"
                        value="{{ old('facebook', $company->facebook) }}" placeholder="https://facebook.com/..." />
                    @error('facebook') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-admin.input label="Instagram" type="url" id="instagram" name="instagram"
                        value="{{ old('instagram', $company->instagram) }}" placeholder="https://instagram.com/..." />
                    @error('instagram') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-admin.input label="Twitter / X" type="url" id="twitter" name="twitter"
                        value="{{ old('twitter', $company->twitter) }}" placeholder="https://twitter.com/..." />
                    @error('twitter') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-admin.input label="YouTube" type="url" id="youtube" name="youtube"
                        value="{{ old('youtube', $company->youtube) }}" placeholder="https://youtube.com/..." />
                    @error('youtube') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-admin.input label="LinkedIn" type="url" id="linkedin" name="linkedin"
                        value="{{ old('linkedin', $company->linkedin) }}" placeholder="https://linkedin.com/..." />
                    @error('linkedin') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-admin.input label="TikTok" type="url" id="tiktok" name="tiktok"
                        value="{{ old('tiktok', $company->tiktok) }}" placeholder="https://tiktok.com/@..." />
                    @error('tiktok') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>
        </x-admin.card>

        {{-- ============================================================
            7. INFORMASI REGULASI
        ============================================================ --}}
        <x-admin.card>
            <x-slot:header>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-slate-700 to-slate-900 dark:from-slate-600 dark:to-slate-800 flex items-center justify-center shadow-sm">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100">Informasi Regulasi</h3>
                </div>
            </x-slot:header>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-admin.input label="Nomor Izin OJK" type="text" id="ojk_license" name="ojk_license"
                        value="{{ old('ojk_license', $company->ojk_license) }}" />
                    @error('ojk_license') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-admin.input label="Jumlah Jaminan LPS" type="text" id="lps_guarantee_amount" name="lps_guarantee_amount"
                        value="{{ old('lps_guarantee_amount', $company->lps_guarantee_amount) }}"
                        placeholder="contoh: Rp 2 Miliar per nasabah" />
                    @error('lps_guarantee_amount') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-admin.textarea label="Tagline OJK" id="ojk_tagline" name="ojk_tagline"
                        rows="2">{{ old('ojk_tagline', $company->ojk_tagline) }}</x-admin.textarea>
                    @error('ojk_tagline') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-admin.textarea label="Tagline LPS" id="lps_tagline" name="lps_tagline"
                        rows="2">{{ old('lps_tagline', $company->lps_tagline) }}</x-admin.textarea>
                    @error('lps_tagline') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>
        </x-admin.card>

        {{-- ============================================================
            8. SEO & FOOTER
        ============================================================ --}}
        <x-admin.card>
            <x-slot:header>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-sky-500 to-sky-600 flex items-center justify-center shadow-sm shadow-sky-600/20">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100">SEO & Footer</h3>
                </div>
            </x-slot:header>

            <div class="space-y-6">
                <div>
                    <x-admin.textarea label="Deskripsi Footer" id="footer_description" name="footer_description"
                        rows="3">{{ old('footer_description', $company->footer_description) }}</x-admin.textarea>
                    @error('footer_description') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-admin.textarea label="Meta Description" id="meta_description" name="meta_description"
                        rows="2" placeholder="Deskripsi untuk mesin pencari (maks 160 karakter)"
                        >{{ old('meta_description', $company->meta_description) }}</x-admin.textarea>
                    @error('meta_description') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-admin.textarea label="Meta Keywords" id="meta_keywords" name="meta_keywords"
                        rows="2" placeholder="Pisahkan dengan koma, contoh: koperasi, simpan pinjam, kredit"
                        >{{ old('meta_keywords', $company->meta_keywords) }}</x-admin.textarea>
                    @error('meta_keywords') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>
        </x-admin.card>

        {{-- ============================================================
            9. JAM OPERASIONAL
        ============================================================ --}}
        <x-admin.card>
            <x-slot:header>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-sm shadow-emerald-600/20">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100">Jam Operasional</h3>
                </div>
            </x-slot:header>

            @php
                $days = ['Senin','Selasa','Rabu','Kamis',"Jum'at",'Sabtu','Minggu'];
                $savedHours = old('operational_hours', $company->operational_hours ?? []);
                $hoursMap = [];
                if (is_array($savedHours)) {
                    foreach ($savedHours as $key => $item) {
                        if ($key === 'notes') continue;
                        if (is_array($item)) {
                            if (isset($item['day'])) {
                                $entry = $item;
                            } elseif (is_numeric($key)) {
                                $entry = array_merge($item, ['day' => $days[(int) $key] ?? (string) $key]);
                            } else {
                                $entry = array_merge(['day' => (string) $key], $item);
                            }
                        } elseif (is_string($item) && is_string($key)) {
                            $raw = trim($item);
                            $isClosed = in_array(strtolower($raw), ['tutup','libur','closed','off','-','','0'], true);
                            $open = null; $close = null;
                            if (!$isClosed && preg_match('/(\d{1,2}:\d{2})\s*[-–—]\s*(\d{1,2}:\d{2})/', $raw, $m)) {
                                $open = $m[1]; $close = $m[2];
                            }
                            $entry = ['day' => (string) $key, 'active' => !$isClosed, 'open' => $open, 'close' => $close];
                        } else {
                            continue;
                        }
                        $hoursMap[(string) ($entry['day'] ?? '')] = $entry;
                    }

                    $normDay = fn($s) => mb_strtolower(str_replace(["'", '’'], '', trim($s)));
                    $expanded = [];
                    foreach ($hoursMap as $label => $entry) {
                        $normLabel = $normDay($label);
                        $matched = false;
                        foreach ($days as $i => $startDay) {
                            for ($j = $i; $j < count($days); $j++) {
                                $endDay = $days[$j];
                                $pattern = '/^' . preg_quote($normDay($startDay), '/') . '.*' . preg_quote($normDay($endDay), '/') . '$/';
                                if (preg_match($pattern, $normLabel)) {
                                    for ($k = $i; $k <= $j; $k++) {
                                        $expanded[$days[$k]] = array_merge($entry, ['day' => $days[$k]]);
                                    }
                                    $matched = true;
                                    break 2;
                                }
                            }
                        }
                        if (!$matched && $normLabel === 'setiaphari') {
                            foreach ($days as $day) {
                                $expanded[$day] = array_merge($entry, ['day' => $day]);
                            }
                            $matched = true;
                        }
                        if (!$matched) {
                            $singleMatched = false;
                            foreach ($days as $day) {
                                if ($normDay($label) === $normDay($day)) {
                                    $expanded[$day] = array_merge($entry, ['day' => $day]);
                                    $singleMatched = true;
                                    break;
                                }
                            }
                            if (!$singleMatched) {
                                $expanded[$label] = $entry;
                            }
                        }
                    }
                    $hoursMap = $expanded;
                }
            @endphp

            <div class="rounded-xl border border-slate-200/60 dark:border-slate-700/60 overflow-hidden divide-y divide-slate-100 dark:divide-slate-800">
                @foreach($days as $i => $day)
                    @php
                        $saved  = $hoursMap[$day] ?? null;
                        $active = isset($saved['active']) ? (bool)$saved['active'] : in_array($day, ['Senin','Selasa','Rabu','Kamis',"Jum'at"]);
                        $open   = $saved['open']  ?? '08:00';
                        $close  = $saved['close'] ?? '15:00';
                    @endphp
                    <div x-data="{ active: {{ $active ? 'true' : 'false' }} }"
                        class="flex flex-wrap items-center gap-4 px-4 py-3.5 {{ $i % 2 === 0 ? 'bg-white dark:bg-slate-900' : 'bg-slate-50/60 dark:bg-slate-800/30' }}">
                        <input type="hidden" name="operational_hours[{{ $i }}][day]" value="{{ $day }}">
                        <input type="hidden" name="operational_hours[{{ $i }}][active]" :value="active ? 1 : 0">

                        {{-- Toggle + nama hari --}}
                        <label class="flex items-center gap-2.5 cursor-pointer w-32 shrink-0">
                            <input type="checkbox" x-model="active" class="peer sr-only">
                            <div class="w-9 h-5 rounded-full bg-slate-200 dark:bg-slate-700 peer-checked:bg-gradient-to-r peer-checked:from-emerald-600 peer-checked:to-emerald-500 transition-colors duration-200 after:content-[''] after:relative after:inline-block after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all after:duration-200 peer-checked:after:translate-x-4 peer-checked:after:border-white shadow-sm"></div>
                            <span class="text-sm font-semibold text-slate-800 dark:text-slate-100">{{ $day }}</span>
                        </label>

                        {{-- Jam buka/tutup --}}
                        <div x-show="active" x-cloak class="flex items-center gap-2 flex-1">
                            <div class="flex items-center gap-1.5">
                                <label class="text-xs text-slate-500 dark:text-slate-400 w-10">Buka</label>
                                <input type="time" name="operational_hours[{{ $i }}][open]"
                                    value="{{ $open }}"
                                    class="px-2.5 py-1.5 text-sm input">
                            </div>
                            <span class="text-slate-300 dark:text-slate-600">–</span>
                            <div class="flex items-center gap-1.5">
                                <label class="text-xs text-slate-500 dark:text-slate-400 w-10">Tutup</label>
                                <input type="time" name="operational_hours[{{ $i }}][close]"
                                    value="{{ $close }}"
                                    class="px-2.5 py-1.5 text-sm input">
                            </div>
                        </div>
                        <div x-show="!active" x-cloak class="text-xs text-slate-400 dark:text-slate-500 italic flex-1">Tutup</div>
                    </div>
                @endforeach
            </div>
        </x-admin.card>

        {{-- ============================================================
            SUBMIT
        ============================================================ --}}
        <div class="flex justify-end pt-2">
            <x-admin.button type="submit" variant="primary" size="lg">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Perubahan
            </x-admin.button>
        </div>
    </div>
</form>

<style>
[x-cloak] { display: none !important; }
</style>
@endsection