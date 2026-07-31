@extends('layouts.admin')

@section('title', 'Hak Akses Menu')
@section('page-title', 'Hak Akses Menu')

@section('content')
<div class="overflow-hidden rounded-xl border dark:border-slate-700 border-zinc-200/70 bg-white shadow-sm ring-1 ring-zinc-900/5">
 <div class="px-6 py-5 border-b dark:border-slate-700 border-zinc-200/70">
 <h2 class="text-[15px] font-semibold dark:text-slate-100 dark:text-slate-100 text-zinc-900">Konfigurasi Hak Akses Menu</h2>
 <p class="text-[12px] dark:text-slate-400 dark:text-slate-400 text-zinc-500 mt-0.5">Atur menu yang dapat diakses oleh setiap role</p>
 </div>

 <form action="{{ route('admin.menu-permissions.update') }}" method="POST">
 @csrf
 @method('PUT')

 <div class="overflow-x-auto">
 <table class="w-full border-collapse">
 <thead>
 <tr class="border-b dark:border-slate-700 border-zinc-200/70 dark:bg-slate-800/50 dark:bg-slate-800/50 bg-zinc-50/80">
 <th class="px-5 py-3.5 text-left text-[11px] font-semibold dark:text-slate-400 dark:text-slate-400 text-zinc-500 uppercase tracking-[0.05em]">Menu</th>
 <th class="px-5 py-3.5 text-left text-[11px] font-semibold dark:text-slate-400 dark:text-slate-400 text-zinc-500 uppercase tracking-[0.05em]">Section</th>
 @foreach($roles as $role => $roleName)
 <th class="px-5 py-3.5 text-center text-[11px] font-semibold dark:text-slate-400 dark:text-slate-400 text-zinc-500 uppercase tracking-[0.05em]">{{ $roleName }}</th>
 @endforeach
 </tr>
 </thead>
 <tbody class="divide-y divide-zinc-100/80">
 @php $currentSection = null; @endphp
 @foreach($menus as $menu)
 @if($menu->section !== $currentSection)
 @php $currentSection = $menu->section; @endphp
 @if($currentSection)
 <tr class="dark:bg-slate-800/50 dark:bg-slate-800/50 bg-zinc-50/50">
 <td colspan="{{ 2 + count($roles) }}" class="px-5 py-2.5">
 <span class="text-[11px] font-bold dark:text-slate-400 dark:text-slate-400 text-zinc-500 uppercase tracking-[0.05em]">{{ $currentSection }}</span>
 </td>
 </tr>
 @endif
 @endif
 <tr class="table-row-hover">
 <td class="px-5 py-3.5">
 <span class="text-[13px] font-medium dark:text-slate-100 dark:text-slate-100 text-zinc-900">{{ $menu->name }}</span>
 <span class="table-cell-secondary block">{{ $menu->route }}</span>
 </td>
 <td class="px-5 py-3.5">
 <span class="table-cell-secondary">{{ $menu->section ?? '-' }}</span>
 </td>
 @foreach($roles as $role => $roleName)
 @php
 $permission = $menu->permissions->first(function($p) use ($role) {
 return $p->role && $p->role->name === $role;
 });
 $canAccess = $permission ? $permission->can_access : false;
 $isDisabled = ($menu->key === 'menu-permissions' || $menu->key === 'users') && $role !== 'super_admin';
 @endphp
 <td class="px-5 py-3.5 text-center">
 <input
 type="checkbox"
 name="permissions[{{ $menu->id }}][{{ $role }}]"
 value="1"
 {{ $canAccess ? 'checked' : '' }}
 {{ $isDisabled ? 'disabled' : '' }}
 class="rounded border-zinc-300 bg-white text-amber-600 focus:ring-amber-500 h-5 w-5 {{ $isDisabled ? 'opacity-50 cursor-not-allowed' : '' }}"
 >
 @if($isDisabled && $canAccess)
 <input type="hidden" name="permissions[{{ $menu->id }}][{{ $role }}]" value="1">
 @endif
 </td>
 @endforeach
 </tr>
 @endforeach
 </tbody>
 </table>
 </div>

 <div class="px-6 py-4 dark:bg-slate-800/50 dark:bg-slate-800/50 bg-zinc-50/50 border-t dark:border-slate-700 border-zinc-200/70 flex items-center justify-between gap-4">
 <p class="text-[11px] dark:text-slate-400 dark:text-slate-400 text-zinc-500">
 <span class="text-amber-600 font-medium">⚠</span> Menu "Hak Akses Menu" dan "Pengguna" hanya dapat diakses oleh Super Admin
 </p>
 <x-admin.button type="submit">
 Simpan Perubahan
 </x-admin.button>
 </div>
 </form>
</div>
@endsection
