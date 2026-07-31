@php
 $nonce = csp_nonce();
@endphp
@extends('layouts.admin')

@section('title', 'Edit ' . $reportCategory->name)

@section('content')
<div class="py-6">
 <div class="container max-w-5xl px-4 sm:px-6 lg:px-8">
 {{-- Header --}}
 <div class="flex items-center justify-between mb-6">
 <div>
 <h1 class="text-3xl font-bold dark:text-slate-100 dark:text-slate-100 text-zinc-900">Edit {{ $reportCategory->name }}</h1>
 <p class="mt-1 text-[11px] dark:text-slate-400 dark:text-slate-400 text-zinc-500">Perbarui judul, subjudul, dan deskripsi halaman laporan</p>
 </div>
 <a href="{{ route('admin.report-categories.index') }}" class="inline-flex items-center px-4 py-2 text-[11px] font-medium dark:text-slate-400 dark:text-slate-400 text-zinc-500 bg-white border border-border rounded-xl">
 <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
 </svg>
 Kembali
 </a>
 </div>

 {{-- Form --}}
 <div class="bg-white rounded-xl border">
 <form action="{{ route('admin.report-categories.update', $reportCategory) }}" method="POST">
 @csrf
 @method('PUT')

 <div class="p-6 space-y-6">
 {{-- Title --}}
 <div>
 <label for="title" class="block text-[11px] font-medium dark:text-slate-100 dark:text-slate-100 text-zinc-900 mb-1">Judul Halaman</label>
 <input type="text"
 name="title"
 id="title"
 value="{{ old('title', $reportCategory->title) }}"
 class="w-full rounded-xl border-zinc-300"
 maxlength="255">
 @error('title')
 <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
 @enderror
 </div>

 {{-- Subtitle --}}
 <div>
 <label for="subtitle" class="block text-[11px] font-medium dark:text-slate-100 dark:text-slate-100 text-zinc-900 mb-1">Subjudul Halaman</label>
 <input type="text"
 name="subtitle"
 id="subtitle"
 value="{{ old('subtitle', $reportCategory->subtitle) }}"
 class="w-full rounded-xl border-zinc-300"
 maxlength="255">
 @error('subtitle')
 <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
 @enderror
 </div>

 {{-- Description --}}
 <div>
 <label for="description" class="block text-[11px] font-medium dark:text-slate-100 dark:text-slate-100 text-zinc-900 mb-1">Deskripsi Halaman</label>
 <textarea name="description"
 id="description"
 rows="6"
 class="w-full rounded-xl border-zinc-300">{{ old('description', $reportCategory->description) }}</textarea>
 <p class="mt-1 text-[11px] dark:text-slate-400 dark:text-slate-400 text-zinc-500">Deskripsi yang akan ditampilkan di halaman laporan publik</p>
 @error('description')
 <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
 @enderror
 </div>
 </div>

 {{-- Footer --}}
 <div class="px-6 py-4 dark:bg-slate-800/50 dark:bg-slate-800/50 bg-zinc-50 border-t">
 <button type="submit"
 class="inline-flex items-center px-6 py-2.5 text-[11px] font-medium text-white bg-gradient-to-r from-emerald-600 to-emerald-600 rounded-xl hover: hover:shadow-emerald-600/20 duration-200">
 <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
 </svg>
 Simpan Perubahan
 </button>
 </div>
 </form>
 </div>
 </div>
</div>
@endsection
