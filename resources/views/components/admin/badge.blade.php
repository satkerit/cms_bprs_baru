@props([
    'variant' => 'default'
])

@php
    $variants = [
        'default' => 'admin-badge-emerald',
        'primary' => 'admin-badge-emerald',
        'secondary' => 'admin-badge-zinc',
        'success' => 'admin-badge-emerald',
        'destructive' => 'admin-badge-red',
        'danger' => 'admin-badge-red',
        'warning' => 'admin-badge-amber',
        'info' => 'admin-badge-sky',
        'outline' => 'admin-badge-zinc',
    ];

    $dotVariants = [
        'default' => 'admin-status-dot-active',
        'primary' => 'admin-status-dot-active',
        'secondary' => 'admin-status-dot-inactive',
        'success' => 'admin-status-dot-active',
        'destructive' => 'admin-status-dot-danger',
        'danger' => 'admin-status-dot-danger',
        'warning' => 'admin-status-dot-warning',
        'info' => 'admin-status-dot-active',
        'outline' => 'admin-status-dot-inactive',
    ];
@endphp

<span {{ $attributes->merge([
    'class' => 'admin-badge ' . ($variants[$variant] ?? $variants['default'])
]) }}>
    <span class="{{ $dotVariants[$variant] ?? 'admin-status-dot-active' }}"></span>
    {{ $slot }}
</span>
