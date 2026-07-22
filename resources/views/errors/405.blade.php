@extends('errors.layout')

@section('title', 'Method Not Allowed')
@section('code', '405')
@section('page-title', 'Metode Tidak Diizinkan')
@section('message', 'Metode permintaan yang digunakan tidak diizinkan untuk halaman ini. Silakan coba dengan metode yang berbeda.')

@section('orb-color', 'rgba(99,102,241,0.08)')
@section('orb-color-2', 'rgba(139,92,246,0.06)')
@section('orb-color-3', 'rgba(165,180,252,0.05)')
@section('code-grad', 'linear-gradient(135deg, #818cf8, #a78bfa)')
@section('divider-color', 'linear-gradient(90deg, #818cf8, transparent)')
@section('btn-primary', 'linear-gradient(135deg, #6366f1, #8b5cf6)')
@section('btn-shadow', 'rgba(99,102,241,0.25)')

@section('illustration')
<svg viewBox="0 0 200 140" fill="none" xmlns="http://www.w3.org/2000/svg">
    <!-- Traffic light -->
    <rect x="82" y="16" width="36" height="100" rx="10" stroke="#818cf8" stroke-width="2.5" fill="rgba(129,140,248,0.08)"/>
    <rect x="88" y="22" width="24" height="88" rx="6" fill="rgba(129,140,248,0.05)"/>
    <circle cx="100" cy="38" r="10" stroke="#818cf8" stroke-width="2" fill="none"/>
    <circle cx="100" cy="66" r="10" stroke="#818cf8" stroke-width="2" fill="none"/>
    <circle cx="100" cy="94" r="10" stroke="#818cf8" stroke-width="2" fill="none"/>
    <circle cx="100" cy="94" r="6" fill="#f87171" opacity="0.8"/>
    <!-- Arrow -->
    <path d="M140 50 L160 50 L155 44" stroke="#818cf8" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" opacity="0.5"/>
    <path d="M140 50 L155 56" stroke="#818cf8" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" opacity="0.5"/>
</svg>
@endsection
