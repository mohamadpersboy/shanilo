@if ($paginator->total())
    <div class="pagination clearfix">
        <ul class="step no_bullet">
        @if ($paginator->onFirstPage())
          <li class="item prev">
              <a title="" class="link">قبلی</a>
          </li>
        @else
            <li class="item prev">
                <a href="{{ $paginator->previousPageUrl()}}" title="" class="link">قبلی</a>
            </li>
        @endif
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="item active"><a title="" class="link">{{$element}}</a></li>
            @endif
            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="item active"><a title="" class="link">{{$page}}</a></li>
                    @else
                        <li class="item"><a href="{{$url}}" title="" class="link">{{$page}}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach
        {{-- Next Page Link --}}

        @if ($paginator->hasMorePages())
            <li class="item next">
                <a href="{{ $paginator->nextPageUrl() }}" title="" class="link">بعدی</a>
            </li>
        @else
            <li class="item next">
                <a title="" class="link">بعدی</a>
            </li>
        @endif
        </ul>
    </div><!--close .pagination-->
@endif