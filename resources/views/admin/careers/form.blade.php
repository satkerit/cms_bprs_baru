@extends('layouts.admin')

@section('title', isset($career) ? 'Edit Lowongan' : 'Tambah Lowongan')

@section('content')
<x-admin.page-header :title="isset($career) ? 'Edit Lowongan' : 'Tambah Lowongan'">
 <x-slot:actions>
 <x-admin.button href="{{ route('admin.careers.index') }}" variant="secondary">Kembali</x-admin.button>
 </x-slot:actions>
</x-admin.page-header>

<form action="{{ isset($career) ? route('admin.careers.update', $career) : route('admin.careers.store') }}" method="POST">
 @csrf
 @if(isset($career)) @method('PUT') @endif

 @if($errors->any())
 <div class="mb-4 p-4 bg-red-100 border border-red-200 text-red-600 rounded-xl">
 <ul class="list-disc list-inside">
 @foreach($errors->all() as $error)
 <li>{{ $error }}</li>
 @endforeach
 </ul>
 </div>
 @endif

 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
 <div class="lg:col-span-2 col-span-1 space-y-6">
 <x-admin.card title="Informasi Lowongan">
 <div class="space-y-4">
 <x-admin.input name="title" label="Judul Posisi" :value="old('title', $career->title ?? '')" required placeholder="Contoh: Staff Marketing"/>

 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
 <x-admin.input name="department" label="Departemen" :value="old('department', $career->department ?? '')" placeholder="Contoh: Marketing"/>
 <x-admin.input name="location" label="Lokasi" :value="old('location', $career->location ?? '')" placeholder="Contoh: Pangkalpinang"/>
 </div>

 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
 <div>
 <label class="block text-[11px] font-medium dark:text-slate-300 dark:text-slate-300 text-zinc-700 mb-1">Tipe Pekerjaan <span class="text-red-600">*</span></label>
 <select name="employment_type" required class="block w-full rounded-xl border dark:border-slate-700 border-zinc-200 py-2.5 px-4 dark:text-slate-100 dark:text-slate-100 text-zinc-900 dark:bg-slate-800/50 dark:bg-slate-800/50 bg-zinc-50 sm:leading-6">
 <option value="full_time" {{ old('employment_type', $career->employment_type ?? '') == 'full_time' ? 'selected' : '' }}>Full Time</option>
 <option value="part_time" {{ old('employment_type', $career->employment_type ?? '') == 'part_time' ? 'selected' : '' }}>Part Time</option>
 <option value="contract" {{ old('employment_type', $career->employment_type ?? '') == 'contract' ? 'selected' : '' }}>Kontrak</option>
 <option value="internship" {{ old('employment_type', $career->employment_type ?? '') == 'internship' ? 'selected' : '' }}>Magang</option>
 </select>
 </div>
 <x-admin.input name="salary_range" label="Kisaran Gaji" :value="old('salary_range', $career->salary_range ?? '')" placeholder="Contoh: Rp 4.000.000 - Rp 6.000.000"/>
 </div>

 <div>
 <label class="block text-[11px] font-medium dark:text-slate-300 dark:text-slate-300 text-zinc-700 mb-1">Deskripsi Pekerjaan <span class="text-red-600">*</span></label>
 <textarea name="description" rows="4" required class="block w-full rounded-xl border dark:border-slate-700 border-zinc-200 py-2.5 px-4 dark:text-slate-100 dark:text-slate-100 text-zinc-900 dark:bg-slate-800/50 dark:bg-slate-800/50 bg-zinc-50 sm:leading-6" placeholder="Jelaskan tentang posisi ini...">{{ old('description', $career->description ?? '') }}</textarea>
 </div>
 </div>
 </x-admin.card>

 <x-admin.card title="Detail Lowongan">
 <div class="space-y-4">
 <div>
 <label class="block text-[11px] font-medium dark:text-slate-300 dark:text-slate-300 text-zinc-700 mb-1">Persyaratan</label>
 <textarea name="requirements" rows="5" class="block w-full rounded-xl border dark:border-slate-700 border-zinc-200 py-2.5 px-4 dark:text-slate-100 dark:text-slate-100 text-zinc-900 dark:bg-slate-800/50 dark:bg-slate-800/50 bg-zinc-50 sm:leading-6" placeholder="- Pendidikan minimal S1&#10;- Pengalaman minimal 2 tahun&#10;- Menguasai Microsoft Office">{{ old('requirements', $career->requirements ?? '') }}</textarea>
 <p class="text-[11px] dark:text-slate-400 dark:text-slate-400 text-zinc-500 mt-1">Gunakan format list dengan tanda "-" di awal setiap baris</p>
 </div>

 <div>
 <label class="block text-[11px] font-medium dark:text-slate-300 dark:text-slate-300 text-zinc-700 mb-1">Tanggung Jawab</label>
 <textarea name="responsibilities" rows="5" class="block w-full rounded-xl border dark:border-slate-700 border-zinc-200 py-2.5 px-4 dark:text-slate-100 dark:text-slate-100 text-zinc-900 dark:bg-slate-800/50 dark:bg-slate-800/50 bg-zinc-50 sm:leading-6" placeholder="- Mengelola akun media sosial&#10;- Membuat konten marketing&#10;- Menganalisis data penjualan">{{ old('responsibilities', $career->responsibilities ?? '') }}</textarea>
 </div>

 <div>
 <label class="block text-[11px] font-medium dark:text-slate-300 dark:text-slate-300 text-zinc-700 mb-1">Benefit</label>
 <textarea name="benefits" rows="4" class="block w-full rounded-xl border dark:border-slate-700 border-zinc-200 py-2.5 px-4 dark:text-slate-100 dark:text-slate-100 text-zinc-900 dark:bg-slate-800/50 dark:bg-slate-800/50 bg-zinc-50 sm:leading-6" placeholder="- BPJS Kesehatan & Ketenagakerjaan&#10;- Tunjangan makan&#10;- Bonus tahunan">{{ old('benefits', $career->benefits ?? '') }}</textarea>
 </div>
 </div>
 </x-admin.card>
 </div>

 <div class="space-y-6">
 <x-admin.card title="Pengaturan">
 <div class="space-y-4">
 <div class="flex items-center gap-2">
 <input type="checkbox" name="is_active" id="is_active" value="1"
 {{ old('is_active', $career->is_active ?? true) ? 'checked' : '' }}
 class="rounded border-zinc-300 text-sky-600 w-5 h-5">
 <label for="is_active" class="text-[11px] dark:text-slate-300 dark:text-slate-300 text-zinc-700">Lowongan Aktif</label>
 </div>

 <x-admin.input type="date" name="deadline" label="Batas Lamaran" :value="old('deadline', isset($career) && $career->deadline ? $career->deadline->format('Y-m-d') : '')" hint="Kosongkan jika tidak ada batas waktu"/>

 <x-admin.input type="number" name="order_position" label="Urutan" :value="old('order_position', $career->order_position ?? 0)" min="0"/>
 </div>
 </x-admin.card>

 <x-admin.button type="submit" class="w-full">
 {{ isset($career) ? 'Simpan Perubahan' : 'Tambah Lowongan' }}
 </x-admin.button>
 </div>
 </div>
</form>
@endsection
