@extends('errors.layout')

@section('title', 'Server Error')
@section('code', '500')
@section('page-title', 'Terjadi Kesalahan Server')
@section('message', 'Maaf, terjadi masalah pada server kami. Tim teknis sudah mendapat notifikasi dan sedang memperbaikinya. Silakan coba lagi beberapa saat.')

@section('orb-color', 'rgba(249,115,22,0.08)')
@section('orb-color-2', 'rgba(239,68,68,0.06)')
@section('orb-color-3', 'rgba(251,146,60,0.05)')
@section('code-grad', 'linear-gradient(135deg, #fb923c, #f87171)')
@section('divider-color', 'linear-gradient(90deg, #fb923c, transparent)')
@section('btn-primary', 'linear-gradient(135deg, #f97316, #ef4444)')
@section('btn-shadow', 'rgba(249,115,22,0.25)')

@section('illustration')
<svg viewBox="0 0 200 140" fill="none" xmlns="http://www.w3.org/2000/svg">
    <g>
        <animateTransform attributeName="transform" type="rotate" from="0 100 70" to="360 100 70" dur="10s" repeatCount="indefinite"/>
        <circle cx="100" cy="70" r="32" stroke="#fb923c" stroke-width="3" fill="rgba(251,146,60,0.08)"/>
        <rect x="96" y="32" width="8" height="12" rx="2" fill="#fb923c"/>
        <rect x="96" y="96" width="8" height="12" rx="2" fill="#fb923c"/>
        <rect x="62" y="66" width="12" height="8" rx="2" fill="#fb923c"/>
        <rect x="126" y="66" width="12" height="8" rx="2" fill="#fb923c"/>
        <rect x="73" y="43" width="10" height="10" rx="2" fill="#fb923c" transform="rotate(-45 78 48)"/>
        <rect x="117" y="87" width="10" height="10" rx="2" fill="#fb923c" transform="rotate(-45 122 92)"/>
        <rect x="117" y="43" width="10" height="10" rx="2" fill="#fb923c" transform="rotate(45 122 48)"/>
        <rect x="73" y="87" width="10" height="10" rx="2" fill="#fb923c" transform="rotate(45 78 92)"/>
        <circle cx="100" cy="70" r="14" fill="rgba(255,255,255,0.05)" stroke="rgba(251,146,60,0.3)" stroke-width="1.5"/>
        <circle cx="100" cy="70" r="4" fill="#fb923c"/>
    </g>
    <g>
        <animateTransform attributeName="transform" type="rotate" from="0 148 42" to="-10 148 42" dur="3s" repeatCount="indefinite" values="0 148 42; -8 148 42; 0 148 42"/>
        <rect x="146" y="42" width="4" height="36" rx="2" fill="#fb923c"/>
        <path d="M144 42 A4 4 0 1 1 152 42 L152 38 A4 4 0 1 1 144 38 Z" fill="#fb923c"/>
        <rect x="144" y="78" width="8" height="6" rx="1" fill="#fb923c"/>
    </g>
    <circle cx="60" cy="40" r="2" fill="#fb923c" opacity="0.6">
        <animate attributeName="opacity" values="0.6;0;0.6" dur="1.5s" repeatCount="indefinite"/>
    </circle>
    <circle cx="140" cy="110" r="2.5" fill="#fb923c" opacity="0.5">
        <animate attributeName="opacity" values="0.5;0;0.5" dur="2s" repeatCount="indefinite"/>
    </circle>
    <circle cx="55" cy="102" r="1.5" fill="#fb923c" opacity="0.4">
        <animate attributeName="opacity" values="0.4;0;0.4" dur="1.8s" repeatCount="indefinite"/>
    </circle>
</svg>
@endsection
