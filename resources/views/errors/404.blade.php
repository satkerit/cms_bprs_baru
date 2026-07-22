@extends('errors.layout')

@section('title', 'Not Found')
@section('code', '404')
@section('page-title', 'Halaman Tidak Ditemukan')
@section('message', 'Halaman yang Anda cari sepertinya menghilang entah ke mana. Mungkin sudah dipindah, dihapus, atau alamatnya salah. Coba periksa kembali URL atau navigasi ke halaman lain.')

@section('orb-color', 'rgba(59,130,246,0.08)')
@section('orb-color-2', 'rgba(99,102,241,0.07)')
@section('orb-color-3', 'rgba(139,92,246,0.05)')
@section('code-grad', 'linear-gradient(135deg, #60a5fa, #818cf8)')
@section('divider-color', 'linear-gradient(90deg, #60a5fa, transparent)')
@section('btn-primary', 'linear-gradient(135deg, #3b82f6, #6366f1)')
@section('btn-shadow', 'rgba(59,130,246,0.25)')

@section('illustration')
<svg viewBox="0 0 200 140" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="100" cy="62" r="42" stroke="#60a5fa" stroke-width="2.5" fill="rgba(96,165,250,0.08)"/>
    <circle cx="100" cy="62" r="32" stroke="rgba(147,197,253,0.3)" stroke-width="1.5" fill="none"/>
    <path d="M100 40 L105 62 L100 84 L95 62 Z" fill="#60a5fa" opacity="0.8"/>
    <path d="M100 40 L100 62 L95 62 Z" fill="#3b82f6"/>
    <text x="118" y="52" font-family="Inter, sans-serif" font-size="32" font-weight="800" fill="rgba(147,197,253,0.5)">?</text>
    <circle cx="100" cy="62" r="48" stroke="rgba(147,197,253,0.3)" stroke-width="1.5" stroke-dasharray="4 6" fill="none" opacity="0.5">
        <animateTransform attributeName="transform" type="rotate" from="0 100 62" to="360 100 62" dur="8s" repeatCount="indefinite"/>
    </circle>
    <circle cx="138" cy="98" r="8" stroke="#60a5fa" stroke-width="2" fill="none"/>
    <line x1="144" y1="104" x2="152" y2="112" stroke="#60a5fa" stroke-width="2.5" stroke-linecap="round"/>
</svg>
@endsection
