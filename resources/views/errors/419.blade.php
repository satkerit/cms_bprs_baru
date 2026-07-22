@extends('errors.layout')

@section('title', 'Page Expired')
@section('code', '419')
@section('page-title', 'Sesi Berakhir')
@section('message', 'Sesi Anda telah berakhir karena terlalu lama tidak ada aktivitas. Muat ulang halaman dan login kembali untuk melanjutkan.')

@section('orb-color', 'rgba(234,179,8,0.08)')
@section('orb-color-2', 'rgba(251,146,60,0.06)')
@section('orb-color-3', 'rgba(251,191,36,0.05)')
@section('code-grad', 'linear-gradient(135deg, #facc15, #fb923c)')
@section('divider-color', 'linear-gradient(90deg, #facc15, transparent)')
@section('btn-primary', 'linear-gradient(135deg, #eab308, #f97316)')
@section('btn-shadow', 'rgba(234,179,8,0.25)')

@section('illustration')
<svg viewBox="0 0 200 140" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M80 18 L80 30 C80 40 120 40 120 30 L120 18" stroke="#facc15" stroke-width="2.5" fill="rgba(250,204,21,0.08)"/>
    <path d="M120 18 L120 30 C120 40 80 40 80 30 L80 18" stroke="#facc15" stroke-width="2.5" fill="rgba(250,204,21,0.05)" opacity="0.5"/>
    <path d="M76 18 L124 18" stroke="#facc15" stroke-width="3" stroke-linecap="round"/>
    <path d="M76 116 L124 116" stroke="#facc15" stroke-width="3" stroke-linecap="round"/>
    <path d="M80 18 L76 116" stroke="#facc15" stroke-width="2.5" stroke-linecap="round"/>
    <path d="M120 18 L124 116" stroke="#facc15" stroke-width="2.5" stroke-linecap="round"/>
    <path d="M80 30 L100 55 L120 30" stroke="rgba(250,204,21,0.3)" stroke-width="1.5" fill="rgba(250,204,21,0.05)"/>
    <path d="M82 108 L100 76 L118 108" stroke="rgba(250,204,21,0.3)" stroke-width="1.5" fill="rgba(250,204,21,0.05)"/>
    <line x1="98" y1="56" x2="98" y2="72" stroke="#facc15" stroke-width="1.5" stroke-dasharray="2 3" opacity="0.6">
        <animate attributeName="stroke-dashoffset" values="0;-10" dur="1s" repeatCount="indefinite"/>
    </line>
    <path d="M84 104 L100 76 L116 104 Z" fill="#facc15" opacity="0.4">
        <animate attributeName="opacity" values="0.4;0.6;0.4" dur="3s" repeatCount="indefinite"/>
    </path>
    <circle cx="158" cy="28" r="14" stroke="#facc15" stroke-width="1.5" fill="none" opacity="0.5"/>
    <line x1="158" y1="28" x2="158" y2="21" stroke="#facc15" stroke-width="1.5" stroke-linecap="round" opacity="0.5"/>
    <line x1="158" y1="28" x2="163" y2="28" stroke="#facc15" stroke-width="1.5" stroke-linecap="round" opacity="0.5"/>
    <path d="M36 112 L50 90 L64 112 Z" stroke="#fb923c" stroke-width="1.5" fill="rgba(251,146,60,0.08)" opacity="0.5"/>
    <text x="50" y="108" font-family="Inter, sans-serif" font-size="10" font-weight="700" fill="#fb923c" text-anchor="middle" opacity="0.5">!</text>
</svg>
@endsection
