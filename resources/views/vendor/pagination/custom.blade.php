@if ($paginator->hasPages())
<nav>
    <ul class="pagination justify-content-center">

        @foreach ($elements as $element)

            @if (is_array($element))
                @foreach ($element as $page => $url)

                    @if ($page == $paginator->currentPage())
                        <li class="page-item active">
                            <span class="page-link rounded-pill">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link rounded-pill" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif

                @endforeach
            @endif

        @endforeach

    </ul>
</nav>
@endif