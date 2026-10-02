<?php
$categoryId=$category?$category->id:null;
$stateId=$state?$state->id:null;
$queryString="&category=$categoryId&state=$stateId&order_by=$orderBy&price=$price";
?>
@if ($paginator->total())
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <li class="item1">
            <a href="#" class="link1 prev"></a>
        </li>
    @else
        <li class="item1">
            <a href="{{ $paginator->previousPageUrl().$queryString }}" rel="prev" class="link1 prev"></a>
        </li>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
            <li class="item1">
                <a class="link1 active disabled">{{$element}}</a>
            </li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="item1">
                        <a class="link1 active">{{$page}}</a>
                    </li>
                @else
                    <li class="item1">
                        <a href="{{$url.$queryString}}" class="link1">{{$page}}</a>
                    </li>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <li class="item1">
            <a href="{{ $paginator->nextPageUrl().$queryString }}" class="link1 next"></a>
        </li>
    @else
        <li class="item1">
            <a  class="link1 next"></a>
        </li>
    @endif
@endif
