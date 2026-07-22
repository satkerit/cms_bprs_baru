@extends('layouts.admin')

@section('title', 'Tambah Berita')

@section('content')
<x-admin.page-header
 title="Tambah Berita"
 subtitle="Buat berita atau artikel baru"
 :breadcrumbs="[
 ['label' => 'Berita', 'url' => route('admin.news.index')],
 ['label' => 'Tambah']
 ]"
>
 <x-slot:actions>
 <x-admin.button href="{{ route('admin.news.index') }}" variant="outline">
 Kembali
 </x-admin.button>
 </x-slot:actions>
</x-admin.page-header>

<form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data" class="space-y-6">
 @csrf
 @include('admin.news._form')
</form>
@endsection
