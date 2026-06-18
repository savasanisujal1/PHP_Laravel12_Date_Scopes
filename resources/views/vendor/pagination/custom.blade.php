@if ($paginator->hasPages())
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link rounded-pill border-0 shadow-sm">&laquo;</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link rounded-pill border-0 shadow-sm" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a>
            </li>
        @endif
 
        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active">
                            <span class="page-link rounded-pill border-0 shadow-sm bg-primary text-white">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link rounded-pill border-0 shadow-sm" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link rounded-pill border-0 shadow-sm" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link rounded-pill border-0 shadow-sm">&raquo;</span>
            </li>
        @endif
        
    </ul>
</nav>

<style>
    .page-link {
        margin: 0 5px;
        transition: all 0.3s ease;
    }
    .page-item.active .page-link {
        background-color: #667eea !important;
        box-shadow: 0 4px 10px rgba(102, 126, 234, 0.4);
    }
    /* Dark Mode Support */
    .dark .page-link {
        background-color: #2d2d2d;
        color: #fff;
        border: 1px solid #444;
    }
    .dark .page-item.disabled .page-link {
        background-color: #1e1e1e;
        color: #666;
    }
</style>
@endif