@if ($paginator->hasPages())
    <nav class="pagination is-centered is-small" role="navigation" aria-label="{{ __('Pagination Navigation') }}">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <a class="pagination-previous" disabled aria-disabled="true">{{ __('pagination.previous') }}</a>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="pagination-previous" aria-label="{{ __('pagination.previous') }}">{{ __('pagination.previous') }}</a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="pagination-next" aria-label="{{ __('pagination.next') }}">{{ __('pagination.next') }}</a>
        @else
            <a class="pagination-next" disabled aria-disabled="true">{{ __('pagination.next') }}</a>
        @endif
    </nav>
@endif
