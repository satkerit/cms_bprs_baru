@extends('errors.layout')

@section('title', 'Forbidden')
@section('code', '403')
@section('page-title', 'Akses Ditolak')
@section('message', __((isset($exception) ? $exception->getMessage() : null) ?: 'Maaf, Anda tidak memiliki izin untuk mengakses halaman ini. Jika Anda merasa seharusnya bisa mengakses, hubungi administrator.'))

@section('orb-color', 'rgba(239,68,68,0.08)')
@section('orb-color-2', 'rgba(248,113,113,0.06)')
@section('orb-color-3', 'rgba(252,165,165,0.05)')
@section('code-grad', 'linear-gradient(135deg, #f87171, #ef4444)')
@section('divider-color', 'linear-gradient(90deg, #f87171, transparent)')
@section('btn-primary', 'linear-gradient(135deg, #dc2626, #ef4444)')
@section('btn-shadow', 'rgba(220,38,38,0.25)')

@section('illustration')
<svg viewBox="0 0 200 140" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M100 18 L148 36 L148 72 C148 100 100 122 100 122 C100 122 52 100 52 72 L52 36 Z" stroke="#f87171" stroke-width="2.5" fill="rgba(248,113,113,0.08)"/>
    <path d="M100 26 L140 40 L140 70 C140 94 100 114 100 114 C100 114 60 94 60 70 L60 40 Z" stroke="rgba(252,165,165,0.3)" stroke-width="1" fill="none"/>
    <rect x="82" y="62" width="36" height="28" rx="5" fill="#f87171" opacity="0.9"/>
    <path d="M88 62 V52 A12 12 0 0 1 112 52 V62" stroke="#f87171" stroke-width="3.5" fill="none" stroke-linecap="round"/>
    <circle cx="100" cy="76" r="4" fill="white"/>
    <rect x="98" y="78" width="4" height="7" rx="1" fill="white"/>
    <circle cx="142" cy="40" r="14" fill="rgba(248,113,113,0.08)" stroke="#f87171" stroke-width="2"/>
    <line x1="136" y1="34" x2="148" y2="46" stroke="#f87171" stroke-width="2.5" stroke-linecap="round"/>
    <line x1="148" y1="34" x2="136" y2="46" stroke="#f87171" stroke-width="2.5" stroke-linecap="round"/>
</svg>
@endsection
