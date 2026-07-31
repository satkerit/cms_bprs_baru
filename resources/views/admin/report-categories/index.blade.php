@php
 $nonce = csp_nonce();
@endphp
@extends('layouts.admin')

@section('title', 'Kategori Laporan')

@section('content')
<div class="py-6">
 <div class="container px-4 sm:px-6 lg:px-8">
 <x-breadcrumb :items="[
 ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
 ['label' => 'Kategori Laporan'],
 ]" />
 {{-- Header --}}
 <div class="flex items-center justify-between mb-6">
 <div>
 <h1 class="text-3xl font-bold dark:text-slate-100 dark:text-slate-100 text-zinc-900">Kategori Laporan</h1>
 <p class="mt-1 text-[11px] dark:text-slate-400 dark:text-slate-400 text-zinc-500">Kelola deskripsi dan pengaturan halaman laporan</p>
 </div>
 <a href="{{ route('admin.site-settings.index') }}" class="inline-flex items-center px-4 py-2 text-[11px] font-medium dark:text-slate-400 dark:text-slate-400 text-zinc-500 bg-white border border-border rounded-xl">
 <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
 </svg>
 Kembali ke Pengaturan Website
 </a>
 </div>

 {{-- Success Message --}}
 @if(session('success'))
 <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-3">
 <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
 </svg>
 <p class="text-[11px] font-medium text-emerald-800">{{ session('success') }}</p>
 </div>
 @endif

 {{-- Cards Grid --}}
 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
 @foreach($categories as $category)
 <div class="bg-white rounded-xl border hover: -shadow duration-200">
 {{-- Card Header --}}
 <div class="px-6 py-5 border-b">
 <div class="flex items-start justify-between">
 <div class="flex items-center gap-3">
 @php
 $icons = [
 'keuangan_publikasi' => ['bg' => 'bg-red-50', 'text' => 'text-red-600', 'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
 'tata_kelola' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
 'tahunan' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
                'tahunan_berkelanjutan' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'icon' => 'M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9'],
 ];
 $meta = $icons[$category->slug] ?? $icons['keuangan_publikasi'];
 @endphp
 <div class="w-12 h-12 {{ $meta['bg'] }} rounded-xl flex items-center justify-center shrink-0">
 <svg class="w-6 h-6 {{ $meta['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $meta['icon'] }}"/>
 </svg>
 </div>
 <div>
 <h3 class="text-base font-semibold dark:text-slate-100 dark:text-slate-100 text-zinc-900">{{ $category->name }}</h3>
 <p class="text-[11px] dark:text-slate-400 dark:text-slate-400 text-zinc-500 mt-0.5">Slug: {{ $category->slug }}</p>
 </div>
 </div>
 <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-[11px] font-medium {{ $category->is_active ? 'bg-emerald-100 text-emerald-800' : 'dark:bg-slate-800/50 dark:bg-slate-800/50 bg-zinc-50 dark:text-slate-400 dark:text-slate-400 text-zinc-500' }}">
 {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
 </span>
 </div>
 </div>

 {{-- Card Body --}}
 <div class="px-6 py-4 space-y-3">
 <div>
 <label class="text-[11px] font-semibold dark:text-slate-400 dark:text-slate-400 text-zinc-500 tracking-wider">Judul Halaman</label>
 <p class="text-[13px] dark:text-slate-100 dark:text-slate-100 text-zinc-900 mt-1">{{ $category->title }}</p>
 </div>
 <div>
 <label class="text-[11px] font-semibold dark:text-slate-400 dark:text-slate-400 text-zinc-500 tracking-wider">Subjudul</label>
 <p class="text-[13px] dark:text-slate-100 dark:text-slate-100 text-zinc-900 mt-1">{{ $category->subtitle ?? '-' }}</p>
 </div>
 <div>
 <label class="text-[11px] font-semibold dark:text-slate-400 dark:text-slate-400 text-zinc-500 tracking-wider">Deskripsi</label>
 <p class="text-[13px] dark:text-slate-400 dark:text-slate-400 text-zinc-500 mt-1 line-clamp-2">{{ Str::limit(strip_tags($category->description), 120) ?: '-' }}</p>
 </div>
 </div>

 {{-- Card Footer --}}
 <div class="px-6 py-4 dark:bg-slate-800/50 dark:bg-slate-800/50 bg-zinc-50 border-t">
 <a href="{{ route('admin.report-categories.edit', $category) }}"
 class="inline-flex items-center justify-center w-full px-4 py-2 text-[11px] font-medium text-white bg-gradient-to-r from-emerald-600 to-emerald-600 rounded-xl hover: hover:shadow-emerald-600/20 duration-200">
 <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
 </svg>
 Edit Deskripsi
 </a>
 </div>
 </div>
 @endforeach
 </div>
 </div>
</div>
@endsection
