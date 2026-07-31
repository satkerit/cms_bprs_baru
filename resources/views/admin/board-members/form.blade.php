@extends('layouts.admin')

@section('title', isset($boardMember) ? 'Edit Anggota' : 'Tambah Anggota')

@section('content')
<x-admin.page-header :title="isset($boardMember) ? 'Edit Anggota' : 'Tambah Anggota'" subtitle="Isi informasi lengkap anggota dewan">
    <x-slot:actions>
        <x-admin.button href="{{ route('admin.board-members.index') }}" variant="secondary">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </x-admin.button>
    </x-slot:actions>
</x-admin.page-header>

<form action="{{ isset($boardMember) ? route('admin.board-members.update', $boardMember) : route('admin.board-members.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($boardMember)) @method('PUT') @endif

    {{-- Error Messages --}}
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl flex items-start gap-3">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
            <div class="flex items-center gap-2 font-semibold mb-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Terdapat kesalahan pada form:
            </div>
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Basic Information --}}
            <x-admin.card title="Informasi Anggota" subtitle="Data utama anggota dewan">
                <div class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-admin.input name="name" label="Nama Lengkap" :value="old('name', $boardMember->name ?? '')" required placeholder="Contoh: Dr. H. Ahmad Syaifi, M.M." :error="$errors->first('name')"/>
                        <x-admin.input name="position" label="Jabatan" :value="old('position', $boardMember->position ?? '')" required placeholder="Contoh: Komisaris Utama" :error="$errors->first('position')"/>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="type" class="block text-sm font-semibold dark:text-slate-300 dark:text-slate-300 text-zinc-700 mb-1.5 ml-0.5">
                                Tipe Anggota <span class="text-red-500">*</span>
                            </label>
                            <select name="type" id="type" required class="block w-full rounded-xl border-0 py-2.5 px-4 dark:text-slate-100 dark:text-slate-100 text-zinc-900 dark:bg-slate-800/50 dark:bg-slate-800/50 bg-zinc-50 shadow-sm ring-1 ring-inset ring-zinc-200 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-sky-500 sm:text-sm sm:leading-6 hover:ring-zinc-300 transition-all">
                                <option value="komisaris" {{ old('type', $boardMember->type ?? '') == 'komisaris' ? 'selected' : '' }}>Dewan Komisaris</option>
                                <option value="direksi" {{ old('type', $boardMember->type ?? '') == 'direksi' ? 'selected' : '' }}>Dewan Direksi</option>
                                <option value="pengawas_syariah" {{ old('type', $boardMember->type ?? '') == 'pengawas_syariah' ? 'selected' : '' }}>Dewan Pengawas Syariah</option>
                            </select>
                            @error('type')
                                <p class="mt-1.5 text-xs text-red-600 font-medium ml-0.5">{{ $message }}</p>
                            @enderror
                        </div>
                        <x-admin.input type="number" name="order_position" label="Urutan Tampil" :value="old('order_position', $boardMember->order_position ?? 0)" min="0" max="999" hint="Angka lebih kecil ditampilkan lebih dulu" :error="$errors->first('order_position')"/>
                    </div>

                    <div>
                        <label for="biography" class="block text-sm font-semibold dark:text-slate-300 dark:text-slate-300 text-zinc-700 mb-1.5 ml-0.5">Biografi</label>
                        <textarea name="biography" id="biography" rows="5" placeholder="Ceritakan latar belakang dan pengalaman anggota ini..." class="block w-full rounded-xl border-0 py-2.5 px-4 dark:text-slate-100 dark:text-slate-100 text-zinc-900 dark:bg-slate-800/50 dark:bg-slate-800/50 bg-zinc-50 shadow-sm ring-1 ring-inset ring-zinc-200 placeholder:dark:text-slate-500 dark:text-slate-500 text-zinc-400 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-sky-500 sm:text-sm sm:leading-6 hover:ring-zinc-300 transition-all @error('biography') ring-red-300 focus:ring-red-500 bg-red-50/50 @enderror">{{ old('biography', $boardMember->biography ?? '') }}</textarea>
                        @error('biography')
                            <p class="mt-1.5 text-xs text-red-600 font-medium ml-0.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-admin.card>

            {{-- Education --}}
            <x-admin.card title="Pendidikan" subtitle="Riwayat pendidikan formal">
                <div x-data="repeaterField(@js(old('education', $boardMember->education ?? [''])))" class="space-y-3">
                    <template x-for="(item, index) in items" :key="item.id">
                        <div class="flex gap-2 group">
                            <div class="relative flex-1">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 dark:text-slate-500 dark:text-slate-500 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                    </svg>
                                </div>
                                <input type="text"
                                       :name="'education[' + index + ']'"
                                       x-model="items[index].value"
                                       class="w-full pl-10 rounded-xl border-0 py-2.5 px-4 dark:text-slate-100 dark:text-slate-100 text-zinc-900 dark:bg-slate-800/50 dark:bg-slate-800/50 bg-zinc-50 shadow-sm ring-1 ring-inset ring-zinc-200 placeholder:dark:text-slate-500 dark:text-slate-500 text-zinc-400 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-sky-500 sm:text-sm sm:leading-6 hover:ring-zinc-300 transition-all"
                                       placeholder="Contoh: S1 Ekonomi - Universitas Indonesia">
                            </div>
                            <button type="button"
                                    @click="removeItem(index)"
                                    x-show="items.length > 1"
                                    class="p-2.5 dark:text-slate-500 dark:text-slate-500 text-zinc-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all opacity-0 group-hover:opacity-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </template>
                    <button type="button"
                            @click="addItem()"
                            class="inline-flex items-center gap-1.5 text-sm font-medium text-sky-600 hover:text-sky-700 mt-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Pendidikan
                    </button>
                </div>
            </x-admin.card>

            {{-- Experience --}}
            <x-admin.card title="Pengalaman" subtitle="Riwayat pengalaman kerja">
                <div x-data="repeaterField(@js(old('experience', $boardMember->experience ?? [''])))" class="space-y-3">
                    <template x-for="(item, index) in items" :key="item.id">
                        <div class="flex gap-2 group">
                            <div class="relative flex-1">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 dark:text-slate-500 dark:text-slate-500 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <input type="text"
                                       :name="'experience[' + index + ']'"
                                       x-model="items[index].value"
                                       class="w-full pl-10 rounded-xl border-0 py-2.5 px-4 dark:text-slate-100 dark:text-slate-100 text-zinc-900 dark:bg-slate-800/50 dark:bg-slate-800/50 bg-zinc-50 shadow-sm ring-1 ring-inset ring-zinc-200 placeholder:dark:text-slate-500 dark:text-slate-500 text-zinc-400 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-sky-500 sm:text-sm sm:leading-6 hover:ring-zinc-300 transition-all"
                                       placeholder="Contoh: Direktur Utama PT ABC (2015-2020)">
                            </div>
                            <button type="button"
                                    @click="removeItem(index)"
                                    x-show="items.length > 1"
                                    class="p-2.5 dark:text-slate-500 dark:text-slate-500 text-zinc-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all opacity-0 group-hover:opacity-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </template>
                    <button type="button"
                            @click="addItem()"
                            class="inline-flex items-center gap-1.5 text-sm font-medium text-sky-600 hover:text-sky-700 mt-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Pengalaman
                    </button>
                </div>
            </x-admin.card>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Photo --}}
            <x-admin.card title="Foto Profil" subtitle="Upload foto anggota dewan">
                <div class="space-y-4">
                    <x-admin.image-picker
                        name="photo"
                        :value="$boardMember->photo ?? null"
                        hint="Format: JPG, PNG, WebP. Maksimal 2MB. Rekomendasi: 400×500px."
                        previewClass="w-full h-48 object-cover rounded-lg"
                    />
                </div>
            </x-admin.card>

            {{-- Submit Button --}}
            <x-admin.button type="submit" class="w-full justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ isset($boardMember) ? 'Simpan Perubahan' : 'Tambah Anggota' }}
            </x-admin.button>
        </div>
    </div>
</form>
@endsection
