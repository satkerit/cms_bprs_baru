@extends('layouts.admin')

@section('title', 'Manajemen Berita')

@section('content')
<x-admin.page-header title="Daftar Berita" subtitle="Kelola berita dan artikel">
    <x-slot:actions>
        <x-admin.button href="{{ route('admin.news.create') }}" icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>'>
            Tambah Berita
        </x-admin.button>
    </x-slot:actions>
</x-admin.page-header>

@if(session('success'))
    <x-admin.alert type="success" title="Berhasil!" class="mb-5">
        {{ session('success') }}
    </x-admin.alert>
@endif

@if(session('error'))
    <x-admin.alert type="error" title="Gagal!" class="mb-5">
        {{ session('error') }}
    </x-admin.alert>
@endif

<x-admin.card :noPadding="true">
    <x-admin.table :headers="['Judul', 'Kategori', 'Penulis', 'Status', 'Tanggal', 'Aksi']">
        @forelse($news as $item)
            <tr>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-4">
                        @if(!empty($item->featured_image))
                            <img src="{{ \App\Helpers\StorageHelper::url($item->featured_image) }}" alt="{{ $item->title }}"
                                 class="w-12 h-12 rounded-xl object-cover dark:bg-slate-800 bg-zinc-100 ring-1 ring-zinc-200/60 flex-shrink-0
                                        transition-all duration-300"
                                 loading="lazy">
                        @else
                            <div class="w-12 h-12 rounded-xl dark:bg-slate-800 dark:bg-slate-800 bg-zinc-100 ring-1 ring-zinc-200/60 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 dark:text-slate-500 dark:text-slate-500 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="min-w-0">
                            <div class="font-semibold dark:text-slate-100 dark:text-slate-100 text-zinc-900 truncate max-w-[300px]">{{ $item->title }}</div>
                            <div class="text-[13px] dark:text-slate-400 dark:text-slate-400 text-zinc-500 truncate mt-0.5">{{ Str::limit($item->excerpt, 60) }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <x-admin.badge variant="info">{{ $item->category }}</x-admin.badge>
                </td>
                <td class="px-6 py-4 text-[13px] dark:text-slate-100 dark:text-slate-100 text-zinc-900 font-medium">
                    {{ $item->author }}
                </td>
                <td class="px-6 py-4">
                    @if($item->is_published)
                        <x-admin.badge variant="success">Published</x-admin.badge>
                    @else
                        <x-admin.badge variant="secondary">Draft</x-admin.badge>
                    @endif
                </td>
                <td class="px-6 py-4 text-[13px] dark:text-slate-400 dark:text-slate-400 text-zinc-500">
                    {{ $item->published_at ? $item->published_at->format('d M Y') : '-' }}
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-1">
                        <a href="{{ route('admin.news.edit', $item->id) }}"
                           class="table-action-btn" title="Edit">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        <button type="button"
                                data-open-modal="deleteNews{{ $item->id }}"
                                class="table-action-btn-danger" title="Hapus">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">
                    <x-admin.empty-state
                        icon="document"
                        title="Belum ada berita"
                        description="Klik tombol 'Tambah Berita' untuk memulai."
                    />
                </td>
            </tr>
        @endforelse
    </x-admin.table>

    {{-- Delete Modals --}}
    @if($news->count())
        @foreach($news as $item)
            <x-admin.delete-modal
                id="deleteNews{{ $item->id }}"
                title="Hapus Berita"
                message="Apakah Anda yakin ingin menghapus berita ini? Data yang dihapus tidak dapat dikembalikan."
                action="{{ route('admin.news.destroy', $item->id) }}"
            />
        @endforeach
    @endif

    @if(method_exists($news, 'hasPages') && $news->hasPages())
        <div class="p-5 border-t border-slate-200/60 bg-slate-50/30">
            {{ $news->links() }}
        </div>
    @endif
</x-admin.card>
@endsection
