@props([
    'type' => 'text',
    'label' => null,
    'name' => null,
    'model' => null,
    'error' => null,
    'hint' => null,
    'helper' => null,
    'required' => false,
    'value' => '',
    'placeholder' => ''
])

@php
    $inputId = $name ?? $model;
    $errorId = $inputId ? $inputId . '-error' : null;
@endphp

<div class="space-y-1.5">
    @if($label)
        <label for="{{ $inputId }}" class="block text-[13px] font-medium text-slate-700">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            @if($model) wire:model="{{ $model }}" @endif
            id="{{ $inputId }}"
            value="{{ $value }}"
            placeholder="{{ $placeholder }}"
            @if($error) aria-invalid="true" aria-describedby="{{ $errorId }}" @endif
            {{ $attributes->merge([
                'class' => 'input ' . ($error ? 'input-error' : '')
            ]) }}
        >
        @if($error)
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                </svg>
            </div>
        @endif
    </div>

    @if($helper && !$error)
        <p class="mt-1 text-[12px] text-slate-400 flex items-center gap-1">
            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ $helper }}
        </p>
    @endif

    @if($hint && !$error)
        <p class="mt-1 text-[12px] text-slate-400 flex items-center gap-1">
            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ $hint }}
        </p>
    @endif

    @if($error)
        <p id="{{ $errorId }}" class="mt-1 text-[12px] text-red-600 flex items-center gap-1" role="alert">
            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ $error }}
        </p>
    @endif
</div>
