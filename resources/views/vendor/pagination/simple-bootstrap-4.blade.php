@if ($paginator->hasPages())
    <ul class="pagination" role="navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item-c disabled" aria-disabled="true">
                <span class="page-link-c">@lang('pagination.previous')</span>
            </li>
        @else
            <li class="page-item-c">
                <a class="page-link-c" href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a>
            </li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item-c">
                <a class="page-link-c" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next')</a>
            </li>
        @else
            <li class="page-item-c disabled" aria-disabled="true">
                <span class="page-link-c">@lang('pagination.next')</span>
            </li>
        @endif
    </ul>
@endif
