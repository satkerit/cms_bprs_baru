@extends('layouts.admin')

@section('title', 'Kelola Dewan & Direksi')

@section('content')
<x-admin.page-header title="Kelola Dewan & Direksi" subtitle="Kelola anggota dewan komisaris, direksi, dan pengawas syariah">
    <x-slot:actions>
        <x-admin.button href="{{ route('admin.board-members.create') }}" icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>'>
            Tambah Anggota
        </x-admin.button>
    </x-slot:actions>
</x-admin.page-header>

<x-admin.card :noPadding="true">
    {{-- Filter Section --}}
    <div class="p-5 border-b dark:border-slate-800 border-zinc-100 dark:bg-slate-800/50 dark:bg-slate-800/50 bg-zinc-50/50">
        <form method="GET" class="flex flex-col sm:flex-row gap-4">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 dark:text-slate-500 dark:text-slate-500 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama anggota..."
                       class="w-full pl-10 rounded-xl border-0 py-2.5 px-4 dark:text-slate-100 dark:text-slate-100 text-zinc-900 bg-white shadow-sm ring-1 ring-inset ring-zinc-200 placeholder:dark:text-slate-500 dark:text-slate-500 text-zinc-400 focus:ring-2 focus:ring-inset focus:ring-sky-500 text-sm">
            </div>
            <div class="flex gap-3">
                <select name="type" class="flex-1 sm:flex-none rounded-xl border-0 py-2.5 px-4 pr-10 dark:text-slate-100 dark:text-slate-100 text-zinc-900 bg-white shadow-sm ring-1 ring-inset ring-zinc-200 focus:ring-2 focus:ring-inset focus:ring-sky-500 text-sm">
                    <option value="">Semua Tipe</option>
                    <option value="komisaris" {{ request('type') == 'komisaris' ? 'selected' : '' }}>Dewan Komisaris</option>
                    <option value="direksi" {{ request('type') == 'direksi' ? 'selected' : '' }}>Dewan Direksi</option>
                    <option value="pengawas_syariah" {{ request('type') == 'pengawas_syariah' ? 'selected' : '' }}>Dewan Pengawas Syariah</option>
                </select>
                <x-admin.button type="submit" variant="secondary">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filter
                </x-admin.button>
                @if(request('search') || request('type'))
                    <a href="{{ route('admin.board-members.index') }}" class="inline-flex items-center px-4 py-2.5 text-sm font-medium dark:text-slate-300 dark:text-slate-300 text-zinc-600 bg-white rounded-xl ring-1 ring-inset ring-zinc-200 hover:dark:bg-slate-800/50 dark:bg-slate-800/50 bg-zinc-50 transition-colors">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Mobile Card View --}}
    <div class="block md:hidden p-4 space-y-4">
        @forelse($members as $member)
            <div class="bg-white border dark:border-slate-700 border-zinc-200/60 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                {{-- Member Photo --}}
                <div class="relative h-48 dark:bg-slate-800 dark:bg-slate-800 bg-zinc-100">
                    @if($member->photo && \App\Helpers\StorageHelper::exists($member->photo))
                        <img src="{{ \App\Helpers\StorageHelper::url($member->photo) }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <div class="w-24 h-24 rounded-full bg-sky-100 flex items-center justify-center">
                                <span class="text-sky-600 font-bold text-4xl">{{ strtoupper(substr($member->name, 0, 2)) }}</span>
                            </div>
                        </div>
                    @endif
                    {{-- Type Badge --}}
                    <div class="absolute top-3 right-3">
                        @switch($member->type)
                            @case('komisaris')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-sky-50 text-sky-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-sky-500 mr-1.5"></span>
                                    Komisaris
                                </span>
                            @break
                            @case('direksi')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-violet-50 text-violet-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-violet-500 mr-1.5"></span>
                                    Direksi
                                </span>
                            @break
                            @case('pengawas_syariah')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-emerald-50 text-emerald-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                    Pengawas Syariah
                                </span>
                            @break
                        @endswitch
                    </div>
                </div>

                {{-- Member Info --}}
                <div class="p-4">
                    <div class="flex items-start justify-between gap-3 mb-2">
                        <h3 class="font-bold dark:text-slate-100 dark:text-slate-100 text-zinc-900 line-clamp-1">{{ $member->name }}</h3>
                        <span class="text-[11px] dark:text-slate-500 dark:text-slate-500 text-zinc-400 font-medium whitespace-nowrap">#{{ $member->order_position ?? '-' }}</span>
                    </div>
                    <p class="text-[13px] dark:text-slate-400 dark:text-slate-400 text-zinc-500 line-clamp-1 mb-3">{{ $member->position }}</p>

                    {{-- Education Preview --}}
                    @if(!empty($member->education) && count($member->education) > 0)
                        <div class="flex items-center gap-1.5 text-[12px] dark:text-slate-500 dark:text-slate-500 text-zinc-400 mb-4">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                            </svg>
                            <span>{{ count($member->education) }} pendidikan</span>
                        </div>
                    @endif

                    {{-- Actions --}}
                    <div class="grid grid-cols-2 gap-3 pt-3 border-t dark:border-slate-800 border-zinc-100">
                        <a href="{{ route('admin.board-members.edit', $member) }}" class="flex items-center justify-center gap-2 py-2.5 text-sm font-semibold text-sky-700 bg-sky-50 hover:bg-sky-100 rounded-xl transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </a>
                        <button type="button" data-open-modal="deleteBoardMember{{ $member->id }}" class="flex items-center justify-center gap-2 py-2.5 text-sm font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-xl transition-colors">
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
                <div class="w-20 h-20 dark:bg-slate-800 dark:bg-slate-800 bg-zinc-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 dark:text-slate-500 dark:text-slate-500 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold dark:text-slate-100 dark:text-slate-100 text-zinc-900 mb-1">Belum Ada Anggota</h3>
                <p class="dark:text-slate-400 dark:text-slate-400 text-zinc-500 mb-4">Mulai tambahkan anggota dewan pertama Anda</p>
                <x-admin.button href="{{ route('admin.board-members.create') }}" size="sm">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Anggota
                </x-admin.button>
            </div>
        @endforelse
    </div>

    {{-- Desktop Table View --}}
    <div class="hidden md:block">
        <x-admin.table :headers="['Anggota', 'Jabatan', 'Tipe', 'Urutan', 'Aksi']">
            @forelse($members as $member)
                <tr class="group hover:dark:bg-slate-800/50 dark:bg-slate-800/50 bg-zinc-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-4">
                            @if($member->photo && \App\Helpers\StorageHelper::exists($member->photo))
                                <img src="{{ \App\Helpers\StorageHelper::url($member->photo) }}" alt="{{ $member->name }}" class="w-12 h-12 rounded-xl object-cover flex-shrink-0 dark:bg-slate-800 dark:bg-slate-800 bg-zinc-100 ring-1 ring-zinc-200/60">
                            @else
                                <div class="w-12 h-12 rounded-xl bg-sky-100 ring-1 ring-sky-200/60 flex items-center justify-center flex-shrink-0">
                                    <span class="text-sky-600 font-semibold text-sm">{{ strtoupper(substr($member->name, 0, 2)) }}</span>
                                </div>
                            @endif
                            <div class="min-w-0">
                                <p class="font-semibold dark:text-slate-100 dark:text-slate-100 text-zinc-900 truncate max-w-[250px]">{{ $member->name }}</p>
                                @if(!empty($member->education) && count($member->education) > 0)
                                    <p class="text-[12px] dark:text-slate-500 dark:text-slate-500 text-zinc-400 mt-0.5 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                        </svg>
                                        {{ count($member->education) }} pendidikan
                                    </p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-[13px] dark:text-slate-300 dark:text-slate-300 text-zinc-600 whitespace-nowrap">
                        {{ $member->position }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @switch($member->type)
                            @case('komisaris')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-sky-50 text-sky-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-sky-500 mr-1.5"></span>
                                    Komisaris
                                </span>
                            @break
                            @case('direksi')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-violet-50 text-violet-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-violet-500 mr-1.5"></span>
                                    Direksi
                                </span>
                            @break
                            @case('pengawas_syariah')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-emerald-50 text-emerald-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                    Pengawas Syariah
                                </span>
                            @break
                        @endswitch
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg dark:bg-slate-800 dark:bg-slate-800 bg-zinc-100 text-[13px] font-semibold dark:text-slate-300 dark:text-slate-300 text-zinc-600">
                            {{ $member->order_position ?? '-' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-1">
                            <a href="{{ route('admin.board-members.edit', $member) }}" class="p-2 dark:text-slate-500 dark:text-slate-500 text-zinc-400 hover:text-sky-600 hover:bg-sky-50 rounded-xl transition-all" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <button type="button" data-open-modal="deleteBoardMember{{ $member->id }}" class="p-2 dark:text-slate-500 dark:text-slate-500 text-zinc-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="w-16 h-16 dark:bg-slate-800 dark:bg-slate-800 bg-zinc-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 dark:text-slate-500 dark:text-slate-500 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <p class="dark:text-slate-400 dark:text-slate-400 text-zinc-500 font-medium">Belum ada anggota dewan</p>
                        <p class="text-[13px] dark:text-slate-500 dark:text-slate-500 text-zinc-400 mt-1">Klik tombol "Tambah Anggota" untuk menambahkan</p>
                    </td>
                </tr>
            @endforelse
        </x-admin.table>
    </div>

    {{-- Pagination --}}
    @if($members->hasPages())
        <div class="p-5 border-t border-slate-200/60 bg-slate-50/30">
            {{ $members->links() }}
        </div>
    @endif
</x-admin.card>

{{-- Delete Modals --}}
@if($members->count())
    @foreach($members as $member)
        <x-admin.delete-modal
            id="deleteBoardMember{{ $member->id }}"
            title="Hapus Anggota"
            :message="'Apakah Anda yakin ingin menghapus anggota ' . json_encode($member->name) . '? Tindakan ini tidak dapat dibatalkan.'"
            action="{{ route('admin.board-members.destroy', $member) }}"
        />
    @endforeach
@endif
@endsection
