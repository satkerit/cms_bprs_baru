@extends('errors.layout')

@section('title', 'Payment Required')
@section('code', '402')
@section('page-title', 'Pembayaran Diperlukan')
@section('message', 'Halaman ini memerlukan pembayaran untuk dapat diakses. Silakan hubungi administrator untuk informasi lebih lanjut.')

@section('orb-color', 'rgba(234,179,8,0.08)')
@section('orb-color-2', 'rgba(249,115,22,0.06)')
@section('orb-color-3', 'rgba(251,191,36,0.05)')
@section('code-grad', 'linear-gradient(135deg, #facc15, #fb923c)')
@section('divider-color', 'linear-gradient(90deg, #facc15, transparent)')
@section('btn-primary', 'linear-gradient(135deg, #eab308, #f97316)')
@section('btn-shadow', 'rgba(234,179,8,0.25)')

@section('illustration')
<svg viewBox="0 0 200 140" fill="none" xmlns="http://www.w3.org/2000/svg">
    <!-- Locked safe -->
    <rect x="60" y="30" width="80" height="90" rx="8" stroke="#facc15" stroke-width="2.5" fill="rgba(250,204,21,0.08)"/>
    <rect x="68" y="38" width="64" height="74" rx="4" fill="rgba(250,204,21,0.05)" opacity="0.5"/>
    <circle cx="100" cy="75" r="16" stroke="#facc15" stroke-width="2" fill="none"/>
    <circle cx="100" cy="75" r="3" fill="#facc15"/>
    <path d="M100 91 L100 98" stroke="#facc15" stroke-width="2" stroke-linecap="round"/>
    <rect x="85" y="38" width="30" height="20" rx="4" stroke="#facc15" stroke-width="2" fill="none"/>
    <!-- Coin stack -->
    <ellipse cx="145" cy="104" rx="12" ry="4" fill="#facc15" opacity="0.3"/>
    <rect x="133" y="92" width="24" height="12" rx="3" fill="#facc15" opacity="0.5"/>
    <ellipse cx="145" cy="92" rx="12" ry="4" fill="#facc15" opacity="0.4"/>
    <rect x="135" y="82" width="20" height="10" rx="2.5" fill="#facc15" opacity="0.6"/>
    <ellipse cx="145" cy="82" rx="10" ry="3" fill="#facc15" opacity="0.5"/>
</svg>
@endsection
