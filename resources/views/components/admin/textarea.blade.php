@props([
    'label' => null,
    'name' => null,
    'model' => null,
    'value' => '',
    'error' => null,
    'helper' => null,
    'required' => false,
    'rows' => 4,
    'placeholder' => ''
])

@php
    $textareaId = $name ?? $model;
    $errorId = $textareaId ? $textareaId . '-error' : null;
@endphp

<div class="space-y-1.5">
    @if($label)
        <label for="{{ $textareaId }}" class="block text-[13px] font-medium text-slate-700">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <textarea
        name="{{ $name }}"
        @if($model) wire:model="{{ $model }}" @endif
        id="{{ $textareaId }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        @if($error) aria-invalid="true" aria-describedby="{{ $errorId }}" @endif
        {{ $attributes->merge([
            'class' => 'input resize-y min-h-[100px] ' . ($error ? 'input-error' : '')
        ]) }}
    >{{ $value }}</textarea>

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
