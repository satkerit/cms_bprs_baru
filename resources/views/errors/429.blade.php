@extends('errors.layout')

@section('title', 'Too Many Requests')
@section('code', '429')
@section('page-title', 'Terlalu Banyak Permintaan')
@section('message', 'Anda telah mengirim terlalu banyak permintaan dalam waktu singkat. Silakan istirahat sejenak dan coba lagi nanti.')

@section('orb-color', 'rgba(239,68,68,0.08)')
@section('orb-color-2', 'rgba(251,146,60,0.06)')
@section('orb-color-3', 'rgba(251,191,36,0.05)')
@section('code-grad', 'linear-gradient(135deg, #f87171, #fb923c)')
@section('divider-color', 'linear-gradient(90deg, #f87171, transparent)')
@section('btn-primary', 'linear-gradient(135deg, #ef4444, #f97316)')
@section('btn-shadow', 'rgba(239,68,68,0.25)')

@section('illustration')
<svg viewBox="0 0 200 140" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M40 100 A60 60 0 0 1 160 100" stroke="rgba(255,255,255,0.1)" stroke-width="6" fill="none" stroke-linecap="round"/>
    <path d="M48 96 A56 56 0 0 1 100 44" stroke="#4ade80" stroke-width="6" fill="none" stroke-linecap="round"/>
    <path d="M100 44 A56 56 0 0 1 132 50" stroke="#facc15" stroke-width="6" fill="none" stroke-linecap="round"/>
    <path d="M132 50 A56 56 0 0 1 152 96" stroke="#f87171" stroke-width="6" fill="none" stroke-linecap="round"/>
    <line x1="100" y1="100" x2="132" y2="54" stroke="#f87171" stroke-width="2.5" stroke-linecap="round">
        <animateTransform attributeName="transform" type="rotate" values="0 100 100; -5 100 100; 0 100 100" dur="2s" repeatCount="indefinite"/>
    </line>
    <circle cx="100" cy="100" r="6" fill="#f87171"/>
    <circle cx="100" cy="100" r="3" fill="rgba(255,255,255,0.1)"/>
    <path d="M100 68 L100 82" stroke="#f87171" stroke-width="3" stroke-linecap="round"/>
    <circle cx="100" cy="90" r="2" fill="#f87171"/>
    <text x="55" y="110" font-family="Inter, sans-serif" font-size="9" font-weight="600" fill="rgba(255,255,255,0.3)">0</text>
    <text x="88" y="118" font-family="Inter, sans-serif" font-size="9" font-weight="600" fill="rgba(255,255,255,0.3)">50</text>
    <text x="133" y="110" font-family="Inter, sans-serif" font-size="9" font-weight="600" fill="#f87171">100</text>
    <circle cx="170" cy="30" r="2" fill="#f87171" opacity="0.3"/>
    <circle cx="180" cy="50" r="1.5" fill="#f87171" opacity="0.2"/>
    <circle cx="30" cy="40" r="2" fill="#f87171" opacity="0.3"/>
    <circle cx="20" cy="60" r="1.5" fill="#f87171" opacity="0.2"/>
</svg>
@endsection
