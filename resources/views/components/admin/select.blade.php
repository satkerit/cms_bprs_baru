@props([
    'label' => null,
    'name' => null,
    'model' => null,
    'options' => [],
    'error' => null,
    'helper' => null,
    'required' => false,
    'placeholder' => 'Pilih opsi'
])

@php
    $selectId = $name ?? $model;
    $errorId = $selectId ? $selectId . '-error' : null;
@endphp

<div class="space-y-1.5">
    @if($label)
        <label for="{{ $selectId }}" class="block text-[13px] font-medium text-slate-700">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <select
            name="{{ $name }}"
            @if($model) wire:model="{{ $model }}" @endif
            id="{{ $selectId }}"
            @if($error) aria-invalid="true" aria-describedby="{{ $errorId }}" @endif
            {{ $attributes->merge([
                'class' => 'select ' . ($error ? 'input-error' : '')
            ]) }}
        >
            @if($placeholder)
                <option value="">{{ $placeholder }}</option>
            @endif
            @foreach($options as $key => $label)
                <option value="{{ $key }}">{{ $label }}</option>
            @endforeach
            {{ $slot ?? '' }}
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
            <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
    </div>

    @if($helper && !$error)
        <p class="mt-1 text-[12px] text-slate-400 flex items-center gap-1">
            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ $helper }}
        </p>
    @endif

    @if($error)
        <p id="{{ $errorId }}" class="mt-1 text-[12px] text-red-600 flex items-center gap-1" role="alert">
            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ $error }}
        </p>
    @endif
</div>
