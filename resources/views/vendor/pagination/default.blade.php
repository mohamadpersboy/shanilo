<div class="list1">
@if ($paginator->total())
    <ul>
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="item1 first">
                <a href="#" class="page-link" title="">قبلی</a>
            </li><!-- item1 -->
        @else
            <li class="item1 first">
                <a href="{{ $paginator->previousPageUrl() }}" class="page-link" title="">قبلی</a>
            </li><!-- item1 -->
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="item1 active"><a class="page-link">{{$element}}</a></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="item1 active"><a class="page-link">{{$page}}</a></li>
                    @else
                        <li class="item1"><a href="{{$url}}" class="page-link">{{$page}}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach
        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="item1 last">
                <a href="{{ $paginator->nextPageUrl() }}" class="page-link" title="">بعدی</a>
            </li><!-- item1 -->
        @else
            <li class="item1 last">
                <a class="page-link" title="">بعدی</a>
            </li><!-- item1 -->
        @endif

    </ul>
@endif
</div><!--list1-->