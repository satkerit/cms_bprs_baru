@extends('layouts.admin')

@section('title', 'Edit Berita')

@section('content')
<x-admin.page-header
 title="Edit Berita"
 subtitle="Perbarui informasi berita"
 :breadcrumbs="[
 ['label' => 'Berita', 'url' => route('admin.news.index')],
 ['label' => 'Edit']
 ]"
>
 <x-slot:actions>
 <x-admin.button href="{{ route('admin.news.index') }}" variant="outline">
 Kembali
 </x-admin.button>
 </x-slot:actions>
</x-admin.page-header>

<form method="POST" action="{{ route('admin.news.update', $news) }}" enctype="multipart/form-data" class="space-y-6">
 @csrf
 @method('PUT')
 @include('admin.news._form', ['news' => $news])
</form>
@endsection
