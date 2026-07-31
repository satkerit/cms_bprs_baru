@extends('layouts.admin')

@section('title', 'Kelola Pengguna')

@section('content')
<x-admin.page-header title="Kelola Pengguna" subtitle="Kelola akun pengguna admin">
    <x-slot:actions>
        <x-admin.button href="{{ route('admin.users.create') }}" icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>'>
            Tambah Pengguna
        </x-admin.button>
    </x-slot:actions>
</x-admin.page-header>

<x-admin.card :noPadding="true">
    <div class="p-4 border-b dark:border-slate-700 border-zinc-200/60 dark:bg-slate-800/50 dark:bg-slate-800/50 bg-zinc-50/50">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/email..."
                   class="w-full sm:flex-1 sm:min-w-[200px] rounded-xl dark:border-slate-700 border-zinc-200 text-[13px] focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20">
            <div class="flex gap-3">
                <select name="role" class="flex-1 sm:flex-none rounded-xl dark:border-slate-700 border-zinc-200 text-[13px] focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 bg-white">
                    <option value="">Semua Role</option>
                    <option value="super_admin" {{ request('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="editor" {{ request('role') == 'editor' ? 'selected' : '' }}>Editor</option>
                </select>
                <x-admin.button type="submit" variant="secondary">Filter</x-admin.button>
                @if(request('search') || request('role'))
                    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 text-[13px] font-medium dark:text-slate-300 dark:text-slate-300 text-zinc-700 bg-white rounded-xl border dark:border-slate-700 border-zinc-200 hover:dark:bg-slate-800/50 dark:bg-slate-800/50 bg-zinc-50 hover:border-zinc-300 transition-all">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Mobile Card View --}}
    <div class="block md:hidden p-4 space-y-4">
        @forelse($users as $user)
            <div class="bg-white border dark:border-slate-700 border-zinc-200/60 rounded-2xl p-4 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start gap-3 mb-3">
                    <div class="w-12 h-12 rounded-xl dark:bg-slate-800 dark:bg-slate-800 bg-zinc-100 flex items-center justify-center flex-shrink-0 ring-1 ring-zinc-200/60">
                        <span class="dark:text-slate-300 dark:text-slate-300 text-zinc-600 font-semibold text-lg">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold dark:text-slate-100 dark:text-slate-100 text-zinc-900 truncate">{{ $user->name }}</p>
                        <p class="text-[13px] dark:text-slate-400 dark:text-slate-400 text-zinc-500 truncate">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-2 mb-3">
                    @if($user->roleModel)
                        @switch($user->roleModel->name)
                            @case('super_admin')
                                <x-admin.badge variant="danger">{{ $user->roleModel->display_name }}</x-admin.badge>
                                @break
                            @case('admin')
                                <x-admin.badge variant="primary">{{ $user->roleModel->display_name }}</x-admin.badge>
                                @break
                            @case('editor')
                                <x-admin.badge variant="info">{{ $user->roleModel->display_name }}</x-admin.badge>
                                @break
                            @default
                                <x-admin.badge variant="secondary">{{ $user->roleModel->display_name }}</x-admin.badge>
                                @break
                        @endswitch
                    @endif
                    @if($user->is_active)
                        <x-admin.badge variant="success">Aktif</x-admin.badge>
                    @else
                        <x-admin.badge variant="danger">Nonaktif</x-admin.badge>
                    @endif
                    <span class="text-[11px] dark:text-slate-500 dark:text-slate-500 text-zinc-400 tabular-nums">{{ $user->created_at->format('d M Y') }}</span>
                </div>
                <div class="flex items-center gap-2 pt-3 border-t dark:border-slate-800 border-zinc-100">
                    <a href="{{ route('admin.users.edit', $user) }}" class="flex-1 text-center py-2.5 text-[13px] font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded-xl transition-colors">
                        Edit
                    </a>
                    @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="flex-1">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-delete w-full py-2.5 text-[13px] font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-xl transition-colors" data-title="Hapus Pengguna" data-text="Apakah Anda yakin ingin menghapus pengguna ini? Data yang dihapus tidak dapat dikembalikan.">
                                Hapus
                            </button>
                        </form>
                    @else
                        <div class="flex-1"></div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <div class="w-16 h-16 dark:bg-slate-800 dark:bg-slate-800 bg-zinc-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 dark:text-slate-500 dark:text-slate-500 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <p class="dark:text-slate-400 dark:text-slate-400 text-zinc-500 font-medium">Belum ada pengguna.</p>
            </div>
        @endforelse
    </div>

    {{-- Desktop Table View --}}
    <div class="hidden md:block">
        <x-admin.table :headers="['Pengguna', 'Role', 'Status', 'Dibuat', 'Aksi']">
            @forelse($users as $user)
                <tr class="group hover:dark:bg-slate-800/50 dark:bg-slate-800/50 bg-zinc-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl dark:bg-slate-800 dark:bg-slate-800 bg-zinc-100 ring-1 ring-zinc-200/60 flex items-center justify-center flex-shrink-0">
                                <span class="dark:text-slate-300 dark:text-slate-300 text-zinc-600 font-semibold text-[13px]">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                            </div>
                            <div class="min-w-0">
                                <p class="font-semibold dark:text-slate-100 dark:text-slate-100 text-zinc-900 truncate">{{ $user->name }}</p>
                                <p class="text-[13px] dark:text-slate-400 dark:text-slate-400 text-zinc-500 truncate">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-1">
                            @if($user->roleModel)
                                @switch($user->roleModel->name)
                                    @case('super_admin')
                                        <x-admin.badge variant="danger">{{ $user->roleModel->display_name }}</x-admin.badge>
                                        @break
                                    @case('admin')
                                        <x-admin.badge variant="primary">{{ $user->roleModel->display_name }}</x-admin.badge>
                                        @break
                                    @case('editor')
                                        <x-admin.badge variant="info">{{ $user->roleModel->display_name }}</x-admin.badge>
                                        @break
                                    @default
                                        <x-admin.badge variant="secondary">{{ $user->roleModel->display_name }}</x-admin.badge>
                                        @break
                                @endswitch
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($user->is_active)
                            <span class="admin-badge-emerald">
                                <span class="admin-status-dot bg-emerald-500 mr-1.5"></span>
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-red-50 text-red-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span>
                                Nonaktif
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-[13px] dark:text-slate-400 dark:text-slate-400 text-zinc-500 whitespace-nowrap">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-1">
                            <a href="{{ route('admin.users.edit', $user) }}" class="p-2 dark:text-slate-500 dark:text-slate-500 text-zinc-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-delete p-2 dark:text-slate-500 dark:text-slate-500 text-zinc-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all" data-title="Hapus Pengguna" data-text="Apakah Anda yakin ingin menghapus pengguna ini? Data yang dihapus tidak dapat dikembalikan.">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="w-16 h-16 dark:bg-slate-800 dark:bg-slate-800 bg-zinc-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 dark:text-slate-500 dark:text-slate-500 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <p class="dark:text-slate-400 dark:text-slate-400 text-zinc-500 font-medium">Belum ada pengguna.</p>
                    </td>
                </tr>
            @endforelse
        </x-admin.table>
    </div>

    @if($users->hasPages())
        <div class="p-5 border-t border-slate-200/60 bg-slate-50/30">{{ $users->links() }}</div>
    @endif
</x-admin.card>
@endsection
