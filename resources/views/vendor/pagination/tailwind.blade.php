@if ($paginator->hasPages())
    <nav class="pagination is-centered is-small" role="navigation" aria-label="{{ __('Pagination Navigation') }}">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <a class="pagination-previous" disabled aria-disabled="true">{{ __('pagination.previous') }}</a>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="pagination-previous">{{ __('pagination.previous') }}</a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="pagination-next">{{ __('pagination.next') }}</a>
        @else
            <a class="pagination-next" disabled aria-disabled="true">{{ __('pagination.next') }}</a>
        @endif

        <div class="pagination-info">
            <p class="has-text-grey is-size-7">
                @if ($paginator->firstItem())
                    {{ __('Showing') }} <strong>{{ $paginator->firstItem() }}</strong> {{ __('to') }} <strong>{{ $paginator->lastItem() }}</strong> {{ __('of') }} <strong>{{ $paginator->total() }}</strong> {{ __('results') }}
                @else
                    {{ $paginator->count() }} {{ __('results') }}
                @endif
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
                        @if ($page == $paginator->currentPage())
                            <li>
                                <a class="pagination-link is-current" aria-label="{{ __('Page :page', ['page' => $page]) }}" aria-current="page">{{ $page }}</a>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" class="pagination-link" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </ul>
    </nav>
@endif
