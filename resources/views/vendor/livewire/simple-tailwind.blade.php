@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <nav class="pagination is-centered is-small" role="navigation" aria-label="Pagination Navigation">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <a class="pagination-previous" disabled aria-disabled="true">{{ __('pagination.previous') }}</a>
            @else
                @if(method_exists($paginator,'getCursorName'))
                    @php($previousCursor = $paginator->previousCursor() ?? $paginator->cursor())
                    <button type="button"
                        dusk="previousPage"
                        wire:key="cursor-{{ $paginator->getCursorName() }}-{{ $previousCursor?->encode() }}"
                        wire:click="setPage('{{ $previousCursor?->encode() }}','{{ $paginator->getCursorName() }}')"
                        x-on:click="{{ $scrollIntoViewJsSnippet }}"
                        wire:loading.attr="disabled"
                        class="pagination-previous">
                        {{ __('pagination.previous') }}
                    </button>
                @else
                    <button type="button"
                        wire:click="previousPage('{{ $paginator->getPageName() }}')"
                        x-on:click="{{ $scrollIntoViewJsSnippet }}"
                        wire:loading.attr="disabled"
                        dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                        class="pagination-previous">
                        {{ __('pagination.previous') }}
                    </button>
                @endif
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                @if(method_exists($paginator,'getCursorName'))
                    @php($nextCursor = $paginator->nextCursor() ?? $paginator->cursor())
                    <button type="button"
                        dusk="nextPage"
                        wire:key="cursor-{{ $paginator->getCursorName() }}-{{ $nextCursor?->encode() }}"
                        wire:click="setPage('{{ $nextCursor?->encode() }}','{{ $paginator->getCursorName() }}')"
                        x-on:click="{{ $scrollIntoViewJsSnippet }}"
                        wire:loading.attr="disabled"
                        class="pagination-next">
                        {{ __('pagination.next') }}
                    </button>
                @else
                    <button type="button"
                        wire:click="nextPage('{{ $paginator->getPageName() }}')"
                        x-on:click="{{ $scrollIntoViewJsSnippet }}"
                        wire:loading.attr="disabled"
                        dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                        class="pagination-next">
                        {{ __('pagination.next') }}
                    </button>
                @endif
            @else
                <a class="pagination-next" disabled aria-disabled="true">{{ __('pagination.next') }}</a>
            @endif
        </nav>
    @endif
</div>
