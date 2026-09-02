@if ($paginator->hasPages())
    <ul class="pagination-box">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span><i class="fa fa-angle-left"></i></span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fa fa-angle-left"></i></a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fa fa-angle-right"></i></a></li>
        @else
            <li class="disabled"><span><i class="fa fa-angle-right"></i></span></li>
        @endif
    </ul>
@endif

<style>
  .pagination-box {
    display: inline-flex;
    list-style: none;
    padding: 0;
    gap: 5px;
}

.pagination-box li a, 
.pagination-box li span {
    display: block;
    padding: 10px 15px;
    border: 1px solid #ebebeb;
    color: #333;
    text-decoration: none;
}

.pagination-box li.active span {
    background-color: #c29958; /* Your theme color */
    color: #fff;
    border-color: #c29958;
}

.pagination-box li.disabled span {
    color: #ccc;
}
</style>