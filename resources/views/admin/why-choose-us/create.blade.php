@extends('layouts.admin')

@section('title', 'Tambah Item - Why Choose Us')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6">
 <!-- Header -->
 <div class="flex "items-center gap-4 mb-8">
 <a href="{{ route('admin.why-choose-us.index') }}" class="p-2.5 bg-white rounded-xl text-zinc-500 border">
 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
 </a>
 <div>
 <h2 class="text-3xl font-bold text-zinc-900 tracking-tight">Tambah Item Baru</h2>
 <p class="text-zinc-500">Tambahkan poin keunggulan baru untuk ditampilkan.</p>
 </div>
 </div>

 <!-- Form -->
 <form action="{{ route('admin.why-choose-us.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
 @csrf

 <div class="bg-white rounded-xl p-6 sm:p-8 border">
 <!-- Decorative gradient -->
 <div class="top-0 right-0 w-32 h-32 bg-sky-500/5 rounded-full blur-3xl -mr-16 -mt-16"></div>

 <h3 class="text-xl font-bold text-zinc-900 mb-6 flex items-center gap-2">
 <span class="w-8 h-8 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center">
 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
 </span>
 Informasi Utama
 </h3>

 <!-- Title & Order -->
 <div class="md:grid md:grid-cols-12 gap-6 mb-6">
 <div class="md:col-span-8 space-y-2">
 <label class="text-[11px] font-semibold text-zinc-900">Judul Item <span class="text-red-600">*</span></label>
 <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-4 py-2.5 rounded-xl border-zinc-300 text-zinc-900 font-medium" placeholder="Contoh: Aman & Terpercaya">
 @error('title') <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p> @enderror
 </div>
 <div class="space-y-2">
 <label class="text-[11px] font-semibold text-zinc-900">Urutan <span class="text-red-600">*</span></label>
 <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" required class="w-full px-4 py-2.5 rounded-xl border-zinc-300 text-zinc-900 font-medium">
 </div>
 </div>

 <!-- Description -->
 <div class="space-y-2 mb-6">
 <label class="text-[11px] font-semibold text-zinc-900">Deskripsi <span class="text-red-600">*</span></label>
 <textarea name="description" rows="3" required class="w-full px-4 py-3 rounded-xl border-zinc-300 text-zinc-900 font-medium resize-none" placeholder="Jelaskan keunggulan secara detail namun ringkas...">{{ old('description') }}</textarea>
 @error('description') <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p> @enderror
 </div>

 <!-- Visualization -->
 <div class="md:grid md:grid-cols-2 gap-8 pt-6 border-t mt-4">
 <!-- Icon Upload -->
 <div class="space-y-4">
 <label class="text-[11px] font-semibold text-zinc-900 flex justify-between items-center">
 <span>Icon Image (Opsional)</span>
 <span class="text-[11px] font-medium text-zinc-500 bg-zinc-50 px-2 py-0.5 rounded-lg">Max: 2MB</span>
 </label>
 <div x-data="{ preview: null }" class="border-2 border-dashed border-zinc-200 rounded-xl p-6 text-center hover:border-blue-400 /20 bg-zinc-50">
 <input type="file" name="icon" class="w-full h-full opacity-0" accept="image/png, image/jpeg, image/svg+xml, image/webp" @change="preview = URL.createObjectURL($event.target.files[0])">

 <div x-show="!preview" class="space-y-3">
 <div class="w-14 h-14 bg-white border text-zinc-500 rounded-xl flex items-center justify-center">
 <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
 </div>
 <div>
 <p class="text-[11px] font-semibold text-zinc-500">Upload Icon</p>
 <p class="text-[11px] text-zinc-500 mt-1">SVG, PNG, JPG, WebP</p>
 <p class="text-[11px] text-zinc-500">Rekomendasi: 200x200px (1:1)</p>
 </div>
 </div>

 <div x-show="preview" x-cloak >
 <img :src="preview" class="h-32 object-contain rounded-xl">
 <button type="button" @click.prevent="preview = null; $el.closest('.relative').querySelector('input').value = ''" class="-top-3 -right-3 bg-white text-red-600 border rounded-lg p-1.5 z-20">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
 </button>
 </div>
 </div>
 </div>

 <!-- Color Theme -->
 <div class="space-y-4">
 <label class="text-[11px] font-semibold text-zinc-900">Tema Warna <span class="text-red-600">*</span></label>
 <div class="grid grid-cols-2 lg:grid-cols-3 gap-3">
 @foreach(\App\Models\WhyChooseUs::getThemes() as $key => $label)
 @php
 $safeKey = ($key === 'primary') ? 'emerald' : $key;
 @endphp
 <label >
 <input type="radio" name="color_theme" value="{{ $key }}" {{ old('color_theme', 'primary') == $key ? 'checked' : '' }}>
 <div class="flex "items-center gap-3 p-3 rounded-xl border -checked:border-{{ $safeKey }}-500 -checked:bg-{{ $safeKey }}-50/50 -checked: -checked:ring-{{ $safeKey }}-500 h-full">
 <div class="w-8 h-8 rounded-full bg-{{ $safeKey }}-500 shrink-0 border-2 border-white ring-border"></div>
 <span class="text-[11px] font-semibold text-zinc-500">{{ $label }}</span>
 </div>
 </label>
 @endforeach
 </div>
 </div>
 </div>

 <!-- Active Toggle -->
 <div class="pt-6 mt-6 border-t">
 <label class="flex "items-center gap-4 p-3 rounded-xl border border-transparent hover:border-blue-100 /30">
 <div class="shrink-0">
 <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
 <div class="w-12 h-7 bg-zinc-200 after:content-[''] after: after:top-[3px] after:left-[3px] after:bg-white after:border-zinc-300 after:border after:rounded-full after:h-5 after:w-5 after: -checked:bg-sky-500 after:"></div>
 </div>
 <div>
 <span class="text-[11px] font-bold text-zinc-900 block">Aktifkan Item</span>
 <span class="text-[11px] text-zinc-500">Item akan ditampilkan di halaman depan jika aktif.</span>
 </div>
 </label>
 </div>
 </div>

 <!-- Submit -->
 <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-4">
 <a href="{{ route('admin.why-choose-us.index') }}" class="px-6 py-3 bg-white text-zinc-500 font-semibold rounded-xl border text-center">Batal</a>  <button type="submit" class="px-6 py-3 bg-gradient-to-r from-emerald-600 to-emerald-500 text-white font-bold rounded-xl shadow-emerald-600/30 hover:-translate-y-0.5 flex items-center justify-center">
 <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
 Simpan Item
 </button>
 </div>
 </form>
</div>
@endsection
