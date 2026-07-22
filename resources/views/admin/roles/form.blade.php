@extends('layouts.admin')

@section('title', isset($role) ? 'Edit Role' : 'Tambah Role')

@section('content')
<x-admin.page-header :title="isset($role) ? 'Edit Role' : 'Tambah Role'">
    <x-slot:actions>
        <x-admin.button href="{{ route('admin.roles.index') }}" variant="secondary">Kembali</x-admin.button>
    </x-slot:actions>
</x-admin.page-header>

<form action="{{ isset($role) ? route('admin.roles.update', $role) : route('admin.roles.store') }}" method="POST">
    @csrf
    @if(isset($role)) @method('PUT') @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Role Info --}}
        <div class="lg:col-span-1">
            <x-admin.card title="Informasi Role">
                <div class="space-y-4">
                    <div>
                        @if(isset($role) && $role->is_system)
                            <x-admin.input
                                name="name_display"
                                label="Nama Role (Slug)"
                                :value="$role->name"
                                disabled
                                placeholder="contoh: content_manager"
                                hint="Nama role sistem tidak dapat diubah"
                            />
                            <input type="hidden" name="name" value="{{ $role->name }}">
                        @else
                            <x-admin.input
                                name="name"
                                label="Nama Role (Slug)"
                                :value="old('name', $role->name ?? '')"
                                required
                                :error="$errors->first('name')"
                                placeholder="contoh: content_manager"
                                hint="Gunakan huruf kecil dan underscore saja"
                            />
                        @endif
                    </div>

                    <div>
                        <x-admin.input
                            name="display_name"
                            label="Nama Tampilan"
                            :value="old('display_name', $role->display_name ?? '')"
                            required
                            :error="$errors->first('display_name')"
                            placeholder="contoh: Content Manager"
                        />
                    </div>

                    <div>
                        <label class="block text-[13px] font-medium text-zinc-700 mb-1">Deskripsi</label>
                        <textarea
                            name="description"
                            rows="3"
                            class="block w-full rounded-xl border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-[13px]"
                            placeholder="Deskripsi singkat tentang role ini"
                        >{{ old('description', $role->description ?? '') }}</textarea>
                        @error('description')<p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                               {{ old('is_active', $role->is_active ?? true) ? 'checked' : '' }}
                               class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                        <label for="is_active" class="text-[13px] text-zinc-700">Role Aktif</label>
                    </div>

                    @if(isset($role) && $role->is_system)
                        <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl">
                            <p class="text-[13px] text-amber-800">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                Ini adalah role sistem. Nama role tidak dapat diubah.
                            </p>
                        </div>
                    @endif
                </div>
            </x-admin.card>
        </div>

        {{-- Permissions --}}
        <div class="lg:col-span-2">
            <x-admin.card title="Hak Akses (Permissions)" subtitle="Pilih permission yang diberikan untuk role ini">
                <div class="space-y-6" x-data="permissionManager()">
                    {{-- Quick Actions --}}
                    <div class="flex flex-wrap gap-2 pb-4 border-b border-zinc-200">
                        <button type="button" @click="selectAll()" class="px-3 py-1.5 text-[11px] font-medium text-amber-700 bg-amber-50 hover:bg-zinc-100 rounded-xl border border-amber-200 transition-colors">
                            Pilih Semua
                        </button>
                        <button type="button" @click="deselectAll()" class="px-3 py-1.5 text-[11px] font-medium text-zinc-700 bg-zinc-50 hover:bg-zinc-100 rounded-xl border border-zinc-200 transition-colors">
                            Hapus Semua
                        </button>
                    </div>

                    {{-- Permission Groups --}}
                    @if($permissions->isNotEmpty())
                        @foreach($permissions as $group => $groupPermissions)
                            <div class="border border-zinc-200 rounded-xl overflow-hidden">
                                <div class="bg-zinc-50/50 px-4 py-3 flex items-center justify-between border-b border-zinc-200">
                                    <div class="flex items-center gap-3">
                                        <input
                                            type="checkbox"
                                            id="group_{{ $group }}"
                                            @click="toggleGroup('{{ $group }}')"
                                            :checked="isGroupChecked('{{ $group }}')"
                                            :indeterminate="isGroupIndeterminate('{{ $group }}')"
                                            class="rounded-xl border-zinc-300 text-zinc-900 focus:ring-zinc-500"
                                        >
                                        <label for="group_{{ $group }}" class="font-medium text-zinc-900">
                                            {{ $permissionGroups[$group] ?? ucfirst($group) }}
                                        </label>
                                    </div>
                                    <span class="text-[11px] text-zinc-500 tabular-nums" x-text="getGroupCount('{{ $group }}')"></span>
                                </div>
                                <div class="p-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    @foreach($groupPermissions as $permission)
                                        <label class="flex items-center gap-2 cursor-pointer group">
                                            <input
                                                type="checkbox"
                                                name="permissions[]"
                                                value="{{ $permission->id }}"
                                                data-group="{{ $group }}"
                                                {{ in_array($permission->id, old('permissions', $rolePermissions ?? [])) ? 'checked' : '' }}
                                                @change="updateGroupState('{{ $group }}')"
                                                class="permission-checkbox rounded-xl border-zinc-300 text-zinc-900 focus:ring-zinc-500"
                                            >
                                            <span class="text-[13px] text-zinc-700 group-hover:text-zinc-900">{{ $permission->display_name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-12 text-zinc-500">
                            Tidak ada permission yang tersedia.
                        </div>
                    @endif

                    <div class="pt-4 border-t border-zinc-200">
                        <x-admin.button type="submit">
                            {{ isset($role) ? 'Simpan Perubahan' : 'Tambah Role' }}
                        </x-admin.button>
                    </div>
                </div>
            </x-admin.card>
        </div>
    </div>
</form>
@endsection