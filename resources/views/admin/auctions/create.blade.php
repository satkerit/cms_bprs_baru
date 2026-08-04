@extends('layouts.admin')

@section('title', 'Tambah Lelang')

@section('content')
<x-admin.page-header title="Tambah Lelang Baru" subtitle="Isi informasi pengumuman lelang agunan">
    <x-slot:actions>
        <a href="{{ route('admin.auctions.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 text-sm font-semibold hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </x-slot:actions>
</x-admin.page-header>

@if($errors->any())
    <x-admin.alert type="error" title="Terdapat kesalahan validasi!" class="mb-5">
        <ul class="list-disc list-inside text-sm space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-admin.alert>
@endif

<form method="POST" action="{{ route('admin.auctions.store') }}" enctype="multipart/form-data" id="auctionForm">
    @csrf
    @include('admin.auctions._form')
</form>
@endsection
