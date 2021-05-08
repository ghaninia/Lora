@if ($paginator->hasPages())
<div class="clearfix"></div>
<div class="pagination-container margin-bottom-30 margin-top-30">
    <nav class="pagination">
    <ul>
    <!-- Previous Page Link -->
    @if (!$paginator->onFirstPage())
        <li>
            <a class="ripple-effect" href="{{ $paginator->previousPageUrl() }}">
                <i class="icon-material-outline-keyboard-arrow-right"></i>
            </a>
        </li>
    @endif
    <!-- Pagination Elements -->
    @foreach ($elements as $element)
    <!-- "Three Dots" Separator -->
        @if (is_string($element))
            <li><a class="current-page">{{ $element }}</a></li>
        @endif
    <!-- Array Of Links -->
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li><a class="ripple-effect current-page">{{ $page }}</a></li>
                @else
                    <li><a class="ripple-effect" href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach
    <!-- Next Page Link -->
    @if ($paginator->hasMorePages())
        <li>
            <a class="ripple-effect" href="{{ $paginator->nextPageUrl() }}">
                <i class="icon-material-outline-keyboard-arrow-left"></i>
            </a>
        </li>
    @endif
    </ul>
</nav>
</div>
<div class="clearfix"></div>
@endif