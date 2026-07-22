@extends('errors.layout')

@section('title', 'Unauthorized')
@section('code', '401')
@section('page-title', 'Akses Tidak Diizinkan')
@section('message', 'Anda perlu login terlebih dahulu untuk mengakses halaman ini. Silakan masuk dengan akun yang sesuai.')

@section('orb-color', 'rgba(239,68,68,0.08)')
@section('orb-color-2', 'rgba(251,146,60,0.06)')
@section('orb-color-3', 'rgba(251,191,36,0.05)')
@section('code-grad', 'linear-gradient(135deg, #f87171, #fb923c)')
@section('divider-color', 'linear-gradient(90deg, #f87171, transparent)')
@section('btn-primary', 'linear-gradient(135deg, #ef4444, #f97316)')
@section('btn-shadow', 'rgba(239,68,68,0.25)')

@section('illustration')
<svg viewBox="0 0 200 140" fill="none" xmlns="http://www.w3.org/2000/svg">
    <rect x="60" y="16" width="80" height="110" rx="8" stroke="#f87171" stroke-width="2.5" fill="rgba(248,113,113,0.08)"/>
    <rect x="68" y="24" width="64" height="94" rx="5" fill="rgba(248,113,113,0.05)" opacity="0.5"/>
    <rect x="76" y="32" width="48" height="36" rx="4" stroke="rgba(252,165,165,0.3)" stroke-width="1.5" fill="none"/>
    <rect x="76" y="74" width="48" height="36" rx="4" stroke="rgba(252,165,165,0.3)" stroke-width="1.5" fill="none"/>
    <circle cx="126" cy="92" r="5" fill="#f87171"/>
    <rect x="124" y="95" width="4" height="8" rx="1" fill="#f87171"/>
    <rect x="133" y="20" width="5" height="5" rx="1" fill="#f87171" opacity="0.6"/>
    <circle cx="174" cy="38" r="8" stroke="rgba(252,165,165,0.5)" stroke-width="2" fill="none"/>
    <path d="M166 56 C166 50 178 50 178 56" stroke="rgba(252,165,165,0.5)" stroke-width="2" fill="none"/>
    <path d="M158 56 L140 56" stroke="rgba(252,165,165,0.5)" stroke-width="2" stroke-dasharray="4 3"/>
    <path d="M144 52 L140 56 L144 60" stroke="rgba(252,165,165,0.5)" stroke-width="2" fill="none"/>
</svg>
@endsection
