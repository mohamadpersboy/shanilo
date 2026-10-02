@if ($paginator->hasPages())
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-body border-top-teal text-center">
                <ul class="pagination pagination-flat pagination-rounded">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li class="disabled"><span>{{__('content.prev')}}</span></li>
                    @else
                        <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">{{__('content.prev')}}</a></li>
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
                        <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">{{__('content.next')}}</a></li>
                    @else
                        <li class="disabled"><span>{{__('content.next')}}</span></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endif