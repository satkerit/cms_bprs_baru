@extends('layouts.admin')

@section('title', 'Kelola Brosur')

@section('content')
<x-admin.page-header title="Kelola Brosur" subtitle="Kelola brosur pembiayaan syariah">
 <x-slot:actions>
 <x-admin.button href="{{ route('admin.brochures.create') }}" icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>'>
 Upload Brosur
 </x-admin.button>
 </x-slot:actions>
</x-admin.page-header>

<x-admin.card :noPadding="true">
 {{-- Mobile Card View --}}
 <div class="block md:hidden p-4 space-y-4">
 @forelse($brochures as $brochure)
 <div class="bg-white border border-zinc-200/60 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
 <div class="p-4">
 <div class="flex items-start gap-3 mb-3">
 <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0">
 <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
 </svg>
 </div>
 <div class="flex-1 min-w-0">
 <p class="font-semibold text-zinc-900 truncate">{{ $brochure->original_name }}</p>
 <a href="{{ $brochure->download_url }}" target="_blank" class="text-[13px] text-blue-600 hover:underline">Download</a>
 </div>
 </div>

 <div class="grid grid-cols-2 gap-3 mb-4 text-[13px] text-zinc-600">
 <div>
 <span class="text-[11px] text-zinc-400 block">Ukuran</span>
 {{ number_format($brochure->file_size / 1024, 2) }} KB
 </div>
 <div>
 <span class="text-[11px] text-zinc-400 block">Diunggah</span>
 {{ $brochure->created_at->format('d M Y') }}
 </div>
 <div class="col-span-2">
 <span class="text-[11px] text-zinc-400 block">Oleh</span>
 {{ $brochure->uploader ? $brochure->uploader->name : 'System' }}
 </div>
 </div>

 <div class="pt-3 border-t border-zinc-100">
 <button type="button" data-open-modal="deleteBrochure{{ $brochure->id }}" class="flex items-center justify-center gap-2 py-2.5 text-sm font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-xl transition-colors w-full">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
 </svg>
 Hapus
 </button>
 </div>
 </div>
 </div>
 @empty
 <div class="text-center py-12">
 <div class="w-20 h-20 bg-zinc-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
 <svg class="w-10 h-10 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
 </svg>
 </div>
 <h3 class="text-lg font-semibold text-zinc-900 mb-1">Belum Ada Brosur</h3>
 <p class="text-zinc-500 mb-4">Klik tombol "Upload Brosur" untuk menambahkan</p>
 <x-admin.button href="{{ route('admin.brochures.create') }}" size="sm">
 <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
 </svg>
 Upload Brosur
 </x-admin.button>
 </div>
 @endforelse
 </div>

 {{-- Desktop Table View --}}
 <div class="hidden md:block">
 <x-admin.table :headers="['Nama File', 'Ukuran', 'Diunggah Oleh', 'Tanggal Upload', 'Aksi']">
 @forelse($brochures as $brochure)
 <tr class="group hover:bg-zinc-50/50 transition-colors">
 <td class="px-6 py-4">
 <div class="flex items-center gap-4">
 <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0">
 <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
 </svg>
 </div>
 <div class="min-w-0">
 <p class="font-semibold text-zinc-900 truncate">{{ $brochure->original_name }}</p>
 <a href="{{ $brochure->download_url }}" target="_blank" class="text-[13px] text-blue-600 hover:underline">Download</a>
 </div>
 </div>
 </td>
 <td class="px-6 py-4 text-[13px] text-zinc-600 whitespace-nowrap">
 {{ number_format($brochure->file_size / 1024, 2) }} KB
 </td>
 <td class="px-6 py-4 text-[13px] text-zinc-600 whitespace-nowrap">
 {{ $brochure->uploader ? $brochure->uploader->name : 'System' }}
 </td>
 <td class="px-6 py-4 text-[13px] text-zinc-600 whitespace-nowrap">
 {{ $brochure->created_at->format('d M Y H:i') }}
 </td>
 <td class="px-6 py-4 whitespace-nowrap">
 <div class="flex items-center gap-1">
 <button type="button" data-open-modal="deleteBrochure{{ $brochure->id }}" class="p-2 text-zinc-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all" title="Hapus">
 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
 </svg>
 </button>
 </div>
 </td>
 </tr>
 @empty
 <tr>
 <td colspan="5" class="px-6 py-12 text-center">
 <p class="text-zinc-500 font-medium">Belum ada brosur</p>
 <p class="text-[13px] text-zinc-400 mt-1">Klik tombol "Upload Brosur" untuk menambahkan</p>
 </td>
 </tr>
 @endforelse
 </x-admin.table>
 </div>

 {{-- Pagination --}}
 @if($brochures->hasPages())
 <div class="p-5 border-t border-slate-200/60 bg-slate-50/30">
 {{ $brochures->links() }}
 </div>
 @endif
</x-admin.card>

{{-- Delete Modals --}}
@if($brochures->count())
 @foreach($brochures as $brochure)
 <x-admin.delete-modal
 id="deleteBrochure{{ $brochure->id }}"
 title="Hapus Brosur"
 :message="'Apakah Anda yakin ingin menghapus brosur ' . json_encode($brochure->original_name) . '? Tindakan ini tidak dapat dibatalkan.'"
 action="{{ route('admin.brochures.destroy', $brochure) }}"
 />
 @endforeach
@endif
@endsection
