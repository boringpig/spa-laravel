@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled">
                <a href="#">
                    <i class="ace-icon fa fa-angle-double-left"></i>
                </a>
            </li>    
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}">
                    <i class="ace-icon fa fa-angle-double-left"></i>
                </a>
            </li>
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
                        <li class="active"><a href="#">{{ $page }}</a></li>    
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}">
                    <i class="ace-icon fa fa-angle-double-right"></i>
                </a>
            </li>
        @else
            <li class="disabled">
                <a href="#">
                    <i class="ace-icon fa fa-angle-double-right"></i>
                </a>
            </li>   
        @endif
    </ul>
@endif
