@extends('errors.layout')

@section('title', 'Service Unavailable')
@section('code', '503')
@section('page-title', 'Layanan Tidak Tersedia')
@section('message', 'Saat ini kami sedang melakukan pemeliharaan sistem. Silakan kembali lagi dalam beberapa saat.')

@section('orb-color', 'rgba(99,102,241,0.08)')
@section('orb-color-2', 'rgba(129,140,248,0.06)')
@section('orb-color-3', 'rgba(165,180,252,0.05)')
@section('code-grad', 'linear-gradient(135deg, #818cf8, #6366f1)')
@section('divider-color', 'linear-gradient(90deg, #818cf8, transparent)')
@section('btn-primary', 'linear-gradient(135deg, #6366f1, #4f46e5)')
@section('btn-shadow', 'rgba(99,102,241,0.25)')

@section('illustration')
<svg viewBox="0 0 200 140" fill="none" xmlns="http://www.w3.org/2000/svg">
    <!-- Construction cone -->
    <path d="M86 108 L100 22 L114 108 Z" stroke="#818cf8" stroke-width="2.5" fill="rgba(129,140,248,0.08)"/>
    <path d="M92 82 L100 40 L108 82 Z" fill="rgba(129,140,248,0.05)" opacity="0.5"/>
    <path d="M89 92 L111 92" stroke="#818cf8" stroke-width="3" stroke-linecap="round"/>
    <path d="M92 74 L108 74" stroke="#818cf8" stroke-width="3" stroke-linecap="round"/>
    <path d="M95 56 L105 56" stroke="#818cf8" stroke-width="3" stroke-linecap="round"/>
    <rect x="82" y="108" width="36" height="5" rx="2" fill="#818cf8"/>
    <rect x="72" y="116" width="56" height="3" rx="1.5" fill="rgba(165,180,252,0.3)" opacity="0.5"/>
    <rect x="130" y="38" width="3" height="36" rx="1.5" fill="#818cf8"/>
    <rect x="130" y="74" width="3" height="16" rx="1" fill="#818cf8" opacity="0.5"/>
    <path d="M128 44 L145 44 M128 50 L145 50 M128 56 L145 56 M128 62 L145 62 M128 68 L145 68" stroke="#facc15" stroke-width="2.5" stroke-dasharray="6 4"/>
    <path d="M50 78 L50 68 C50 64 54 62 58 62 L62 62" stroke="#818cf8" stroke-width="2" fill="none" stroke-linecap="round" opacity="0.5"/>
    <circle cx="64" cy="60" r="4" stroke="#818cf8" stroke-width="1.5" fill="none" opacity="0.4"/>
    <text x="44" y="42" font-family="Inter, sans-serif" font-size="14" font-weight="600" fill="rgba(165,180,252,0.4)" opacity="0.6">Z</text>
    <text x="34" y="32" font-family="Inter, sans-serif" font-size="10" font-weight="600" fill="rgba(165,180,252,0.4)" opacity="0.4">z</text>
    <text x="52" y="30" font-family="Inter, sans-serif" font-size="8" font-weight="600" fill="rgba(165,180,252,0.4)" opacity="0.3">z</text>
    <circle cx="148" cy="24" r="1.5" fill="#818cf8" opacity="0.4">
        <animate attributeName="opacity" values="0.4;0.1;0.4" dur="2s" repeatCount="indefinite"/>
    </circle>
    <circle cx="55" cy="16" r="1.5" fill="#818cf8" opacity="0.3">
        <animate attributeName="opacity" values="0.3;0.1;0.3" dur="2.5s" repeatCount="indefinite"/>
    </circle>
</svg>
@endsection
