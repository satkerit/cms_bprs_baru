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
                <button type="button"
                    wire:click="previousPage('{{ $paginator->getPageName() }}')"
                    x-on:click="{{ $scrollIntoViewJsSnippet }}"
                    wire:loading.attr="disabled"
                    dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.before"
                    class="pagination-previous">
                    {{ __('pagination.previous') }}
                </button>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <button type="button"
                    wire:click="nextPage('{{ $paginator->getPageName() }}')"
                    x-on:click="{{ $scrollIntoViewJsSnippet }}"
                    wire:loading.attr="disabled"
                    dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.before"
                    class="pagination-next">
                    {{ __('pagination.next') }}
                </button>
            @else
                <a class="pagination-next" disabled aria-disabled="true">{{ __('pagination.next') }}</a>
            @endif

            <div class="pagination-info">
                <p class="has-text-grey is-size-7">
                    <span>{{ __('Showing') }}</span>
                    <strong>{{ $paginator->firstItem() }}</strong>
                    <span>{{ __('to') }}</span>
                    <strong>{{ $paginator->lastItem() }}</strong>
                    <span>{{ __('of') }}</span>
                    <strong>{{ $paginator->total() }}</strong>
                    <span>{{ __('results') }}</span>
                </p>
            </div>

            {{-- Pagination List --}}
            <ul class="pagination-list">
                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li><span class="pagination-ellipsis">{{ $element }}</span></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            <li wire:key="paginator-{{ $paginator->getPageName() }}-page{{ $page }}">
                                @if ($page == $paginator->currentPage())
                                    <a class="pagination-link is-current" aria-current="page"
                                        aria-label="{{ __('Page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @else
                                    <button type="button"
                                        wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                        x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                        class="pagination-link"
                                        aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </button>
                                @endif
                            </li>
                        @endforeach
                    @endif
                @endforeach
            </ul>
        </nav>
    @endif
</div>
