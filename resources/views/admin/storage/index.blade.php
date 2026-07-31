@extends('layouts.admin')

@section('title', 'File Manager')

@section('content')
<x-admin.page-header title="File Manager" subtitle="Kelola file dan folder di storage">
 <x-slot:actions>
 <button data-toggle-modal="uploadModal" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-[11px] font-medium rounded-xl">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
 </svg>
 Upload File
 </button>
 <button data-toggle-modal="folderModal" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-[11px] font-medium rounded-xl">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
 </svg>
 Folder Baru
 </button>
 </x-slot:actions>
</x-admin.page-header>

{{-- Storage Info --}}
<div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-6">
 <div class="bg-white rounded-xl p-4 border dark:border-slate-700 border-zinc-200">
 <p class="text-[11px] dark:text-slate-400 dark:text-slate-400 text-zinc-500">Total Storage</p>
 <p class="text-4xl font-semibold dark:text-slate-100 dark:text-slate-100 text-zinc-900">{{ number_format($storageInfo['total'] / 1024 / 1024 / 1024, 2) }} GB</p>
 </div>
 <div class="bg-white rounded-xl p-4 border dark:border-slate-700 border-zinc-200">
 <p class="text-[11px] dark:text-slate-400 dark:text-slate-400 text-zinc-500">Terpakai</p>
 <p class="text-4xl font-semibold text-sky-600">{{ number_format($storageInfo['used'] / 1024 / 1024 / 1024, 2) }} GB</p>
 </div>
 <div class="bg-white rounded-xl p-4 border dark:border-slate-700 border-zinc-200">
 <p class="text-[11px] dark:text-slate-400 dark:text-slate-400 text-zinc-500">Tersedia</p>
 <p class="text-4xl font-semibold text-sky-600">{{ number_format($storageInfo['free'] / 1024 / 1024 / 1024, 2) }} GB</p>
 </div>
</div>

{{-- Breadcrumbs --}}
<div class="mb-4 flex items-center gap-2 text-[11px]">
 <a href="{{ route('admin.storage.index') }}" class="text-sky-600 font-medium">
 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
 </svg>
 </a>
 @foreach($breadcrumbs as $crumb)
 <span class="dark:text-slate-500 dark:text-slate-500 text-zinc-400">/</span>
 <a href="{{ route('admin.storage.index', ['path' => $crumb['path']]) }}" class="text-sky-600">
 {{ $crumb['name'] }}
 </a>
 @endforeach
</div>

<x-admin.card :noPadding="true">
 {{-- Mobile Card View --}}
 <div class="block md:hidden p-4 space-y-3">
 @forelse($items as $item)
 <div class="dark:bg-slate-800/50 dark:bg-slate-800/50 bg-zinc-50 rounded-xl p-3 flex items-center gap-3">
 @if($item['type'] === 'folder')
 <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center shrink-0">
 <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 24 24">
 <path d="M10 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2h-8l-2-2z"/>
 </svg>
 </div>
 @else
 <div class="w-10 h-10 bg-sky-100 rounded-xl flex items-center justify-center shrink-0">
 @if(in_array($item['extension'] ?? '', ['jpg', 'jpeg', 'png', 'gif', 'webp']))
 <img src="{{ $item['url'] }}" alt="{{ $item['name'] }}" class="w-10 h-10 rounded-xl">
 @else
 <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
 </svg>
 @endif
 </div>
 @endif
 <div class="flex-1 min-w-0">
 @if($item['type'] === 'folder')
 <a href="{{ route('admin.storage.index', ['path' => $item['path']]) }}" class="font-medium dark:text-slate-100 dark:text-slate-100 text-zinc-900 block">
 {{ $item['name'] }}
 </a>
 @else
 <p class="font-medium dark:text-slate-100 dark:text-slate-100 text-zinc-900">{{ $item['name'] }}</p>
 <p class="text-[13px] dark:text-slate-400 dark:text-slate-400 text-zinc-500">{{ number_format($item['size'] / 1024, 1) }} KB</p>
 @endif
 </div>
 <div class="flex items-center gap-1">
 @if($item['type'] === 'file')
 <a href="{{ route('admin.storage.download', ['file' => $item['path']]) }}" class="p-2 dark:text-slate-400 dark:text-slate-400 text-zinc-500 hover:bg-sky-100 rounded-xl">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
 </svg>
 </a>
 @endif
 <button data-path="{{ $item['path'] }}" data-type="{{ $item['type'] }}" data-name="{{ $item['name'] }}" class="js-delete-btn p-2 dark:text-slate-400 dark:text-slate-400 text-zinc-500 rounded-xl">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
 </svg>
 </button>
 </div>
 </div>
 @empty
 <div class="text-center py-8 dark:text-slate-400 dark:text-slate-400 text-zinc-500">Folder kosong.</div>
 @endforelse
 </div>

 {{-- Desktop Table View --}}
 <div class="hidden md:block">
 <x-admin.table :headers="['Nama', 'Ukuran', 'Terakhir Diubah', 'Aksi']">
 @forelse($items as $item)
 <tr class="hover:dark:bg-slate-800/50 dark:bg-slate-800/50 bg-zinc-50">
 <td class="px-4 py-3">
 <div class="flex items-center gap-3">
 @if($item['type'] === 'folder')
 <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center shrink-0">
 <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 24 24">
 <path d="M10 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2h-8l-2-2z"/>
 </svg>
 </div>
 <a href="{{ route('admin.storage.index', ['path' => $item['path']]) }}" class="font-medium dark:text-slate-100 dark:text-slate-100 text-zinc-900">
 {{ $item['name'] }}
 </a>
 @else
 <div class="w-10 h-10 dark:bg-slate-800/50 dark:bg-slate-800/50 bg-zinc-50 rounded-xl flex items-center justify-center shrink-0">
 @if(in_array($item['extension'] ?? '', ['jpg', 'jpeg', 'png', 'gif', 'webp']))
 <img src="{{ $item['url'] }}" alt="{{ $item['name'] }}" class="w-10 h-10">
 @elseif(($item['extension'] ?? '') === 'pdf')
 <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24">
 <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm-1 2l5 5h-5V4zM8.5 13H10v4H8.5v-4zm2.5 0h1.5v4H11v-4zm2.5 0H15v4h-1.5v-4z"/>
 </svg>
 @else
 <svg class="w-5 h-5 dark:text-slate-500 dark:text-slate-500 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
 </svg>
 @endif
 </div>
 <div>
 <p class="font-medium dark:text-slate-100 dark:text-slate-100 text-zinc-900">{{ $item['name'] }}</p>
 <p class="text-[11px] dark:text-slate-400 dark:text-slate-400 text-zinc-500">{{ $item['extension'] ?? 'file' }}</p>
 </div>
 @endif
 </div>
 </td>
 <td class="px-4 py-3 text-[11px] dark:text-slate-400 dark:text-slate-400 text-zinc-500">
 @if($item['type'] === 'file')
 {{ number_format($item['size'] / 1024, 1) }} KB
 @else
 -
 @endif
 </td>
 <td class="px-4 py-3 text-[11px] dark:text-slate-400 dark:text-slate-400 text-zinc-500">
 {{ date('d M Y H:i', $item['modified']) }}
 </td>
 <td class="px-4 py-3">
 <div class="flex items-center gap-1">
 @if($item['type'] === 'file')
 @if(in_array($item['extension'] ?? '', ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf']))
 <a href="{{ $item['url'] }}" target="_blank" class="p-1.5 dark:text-slate-400 dark:text-slate-400 text-zinc-500 hover:bg-sky-100 rounded-xl" title="Preview">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
 </svg>
 </a>
 @endif
 <a href="{{ route('admin.storage.download', ['file' => $item['path']]) }}" class="p-1.5 dark:text-slate-400 dark:text-slate-400 text-zinc-500 rounded-xl" title="Download">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
 </svg>
 </a>
 @endif
 <button data-path="{{ $item['path'] }}" data-type="{{ $item['type'] }}" data-name="{{ $item['name'] }}" class="js-rename-btn p-1.5 dark:text-slate-400 dark:text-slate-400 text-zinc-500 hover:bg-amber-100 rounded-xl" title="Rename">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
 </svg>
 </button>
 <button data-path="{{ $item['path'] }}" data-type="{{ $item['type'] }}" data-name="{{ $item['name'] }}" class="js-delete-btn p-1.5 dark:text-slate-400 dark:text-slate-400 text-zinc-500 rounded-xl" title="Hapus">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
 </svg>
 </button>
 </div>
 </td>
 </tr>
 @empty
 <tr><td colspan="4" class="px-4 py-8 text-center dark:text-slate-400 dark:text-slate-400 text-zinc-500">Folder kosong.</td></tr>
 @endforelse
 </x-admin.table>
 </div>
</x-admin.card>


{{-- Upload Modal --}}
<div id="uploadModal" class="hidden fixed bg-black z-50 flex items-center justify-center p-4">
 <div class="bg-white rounded-xl max-w-md w-full p-6">
 <h3 class="text-3xl font-semibold dark:text-slate-100 dark:text-slate-100 text-zinc-900 mb-4">Upload File</h3>
 <form action="{{ route('admin.storage.upload') }}" method="POST" enctype="multipart/form-data">
 @csrf
 <input type="hidden" name="path" value="{{ $path }}">
 <div class="mb-4">
 <label class="block text-[11px] font-medium dark:text-slate-300 dark:text-slate-300 text-zinc-700 mb-2">Pilih File</label>
 <input type="file" name="files[]" multiple required class="w-full text-[13px] dark:text-slate-400 dark:text-slate-400 text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-medium file:bg-emerald-50 file:text-emerald-700 hover:file:bg-sky-100">
 <p class="text-[11px] dark:text-slate-400 dark:text-slate-400 text-zinc-500 mt-1">Maksimal 50MB per file</p>
 </div>
 <div class="flex justify-end gap-3">
 <button type="button" data-close-modal="uploadModal" class="px-4 py-2 text-[11px] font-medium dark:text-slate-300 dark:text-slate-300 text-zinc-700 rounded-xl">Batal</button>
 <button type="submit" class="px-4 py-2 text-[11px] font-medium text-white bg-blue-600 rounded-xl">Upload</button>
 </div>
 </form>
 </div>
</div>

{{-- Create Folder Modal --}}
<div id="folderModal" class="hidden fixed bg-black z-50 flex items-center justify-center p-4">
 <div class="bg-white rounded-xl max-w-md w-full p-6">
 <h3 class="text-3xl font-semibold dark:text-slate-100 dark:text-slate-100 text-zinc-900 mb-4">Buat Folder Baru</h3>
 <form action="{{ route('admin.storage.create-folder') }}" method="POST">
 @csrf
 <input type="hidden" name="path" value="{{ $path }}">
 <div class="mb-4">
 <label class="block text-[11px] font-medium dark:text-slate-300 dark:text-slate-300 text-zinc-700 mb-2">Nama Folder</label>
 <input type="text" name="folder_name" required pattern="[a-zA-Z0-9\-_]+" class="w-full rounded-xl border-zinc-300 text-[13px]" placeholder="nama-folder">
 <p class="text-[11px] dark:text-slate-400 dark:text-slate-400 text-zinc-500 mt-1">Hanya huruf, angka, dash, dan underscore</p>
 </div>
 <div class="flex justify-end gap-3">
 <button type="button" data-close-modal="folderModal" class="px-4 py-2 text-[11px] font-medium dark:text-slate-300 dark:text-slate-300 text-zinc-700 rounded-xl">Batal</button>
 <button type="submit" class="px-4 py-2 text-[11px] font-medium text-white bg-blue-600 rounded-xl">Buat</button>
 </div>
 </form>
 </div>
</div>

{{-- Delete Modal --}}
<div id="deleteModal" class="hidden fixed bg-black z-50 flex items-center justify-center p-4">
 <div class="bg-white rounded-xl max-w-md w-full p-6">
 <h3 class="text-3xl font-semibold dark:text-slate-100 dark:text-slate-100 text-zinc-900 mb-2">Konfirmasi Hapus</h3>
 <p class="dark:text-slate-300 dark:text-slate-300 text-zinc-700 mb-4">Yakin ingin menghapus <span id="deleteItemName" class="font-medium"></span>?</p>
 <form action="{{ route('admin.storage.delete') }}" method="POST">
 @csrf
 @method('DELETE')
 <input type="hidden" name="item" id="deleteItemPath">
 <input type="hidden" name="type" id="deleteItemType">
 <div class="flex justify-end gap-3">
 <button type="button" data-close-modal="deleteModal" class="px-4 py-2 text-[11px] font-medium dark:text-slate-300 dark:text-slate-300 text-zinc-700 rounded-xl">Batal</button>
 <button type="submit" class="px-4 py-2 text-[11px] font-medium text-white bg-red-600 rounded-xl">Hapus</button>
 </div>
 </form>
 </div>
</div>

{{-- Rename Modal --}}
<div id="renameModal" class="hidden fixed bg-black z-50 flex items-center justify-center p-4">
 <div class="bg-white rounded-xl max-w-md w-full p-6">
 <h3 class="text-3xl font-semibold dark:text-slate-100 dark:text-slate-100 text-zinc-900 mb-4">Ubah Nama</h3>
 <form action="{{ route('admin.storage.rename') }}" method="POST">
 @csrf
 @method('PUT')
 <input type="hidden" name="old_name" id="renameOldName">
 <input type="hidden" name="type" id="renameItemType">
 <div class="mb-4">
 <label class="block text-[11px] font-medium dark:text-slate-300 dark:text-slate-300 text-zinc-700 mb-2">Nama Baru</label>
 <input type="text" name="new_name" id="renameNewName" required class="w-full rounded-xl border-zinc-300 text-[13px]">
 </div>
 <div class="flex justify-end gap-3">
 <button type="button" data-close-modal="renameModal" class="px-4 py-2 text-[11px] font-medium dark:text-slate-300 dark:text-slate-300 text-zinc-700 rounded-xl">Batal</button>
 <button type="submit" class="px-4 py-2 text-[11px] font-medium text-white bg-blue-600 rounded-xl">Simpan</button>
 </div>
 </form>
 </div>
</div>

<script nonce="{{ $nonce }}">
document.querySelectorAll('.js-delete-btn').forEach(function(btn) {
 btn.addEventListener('click', function() {
 document.getElementById('deleteItemPath').value = this.dataset.path;
 document.getElementById('deleteItemType').value = this.dataset.type;
 document.getElementById('deleteItemName').textContent = this.dataset.name;
 document.getElementById('deleteModal').classList.remove('hidden');
 });
});

document.querySelectorAll('.js-rename-btn').forEach(function(btn) {
 btn.addEventListener('click', function() {
 document.getElementById('renameOldName').value = this.dataset.path;
 document.getElementById('renameItemType').value = this.dataset.type;
 document.getElementById('renameNewName').value = this.dataset.name;
 document.getElementById('renameModal').classList.remove('hidden');
 });
});

document.querySelectorAll('[data-toggle-modal]').forEach(function(btn) {
 btn.addEventListener('click', function() {
 var modal = document.getElementById(this.dataset.toggleModal);
 if (modal) {
 modal.classList.remove('hidden');
 modal.classList.add('flex');
 }
 });
});

document.querySelectorAll('[data-close-modal]').forEach(function(btn) {
 btn.addEventListener('click', function() {
 var modal = document.getElementById(this.dataset.closeModal);
 if (modal) {
 modal.classList.add('hidden');
 modal.classList.remove('flex');
 }
 });
});
</script>
@endsection
