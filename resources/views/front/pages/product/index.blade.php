@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="container">
            <div class="inner">
                <div id="pjax-container" data-url="{{route('front.product.index')}}" class="market_archive">
                    @include('front.partial.parts.archive-top-filter')
                    <div class="filter_style1 type2">
                        <div class="search_style1 type2 mb20" style="display: block;">
                                <input type="text" id="search" value="{{$search}}" name="search" placeholder="جستجو کنید...">
                                <button><i class="i-search"></i>جستجو کنید</button>
                        </div>
                        <ul class="step no_bullet">
                            <li class="item">
                                <div class="select_part">
                                    <select name="state" onchange="$('#city').val('')" data-group="state" class="filter" id="state">
                                        <option value="">انتخاب استان</option>
                                        @foreach($states as $index=>$state)
                                            <option value="{{$state->id}}" {{$selectedState==$state->id?'selected':''}}>{{$state->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </li>
                            <li class="item">
                                <div class="select_part">
                                    <select name="city" data-group="city" class="filter" id="city">
                                        <option value="">انتخاب شهر</option>
                                        @foreach($cities as $index=>$city)
                                            <option value="{{$city->id}}" {{$selectedCity==$city->id?'selected':''}}>{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </li>
                            <li class="item">
                                <div class="select_part">
                                    <select name="orderByPrice" id="order-by-price" data-group="orderByPrice" class="filter">
                                        <option value="">براساس قیمت</option>
                                        <option value="asc" {{$selectedOrderByPrice=='asc'?'selected':''}}>کم به زیاد</option>
                                        <option value="desc" {{$selectedOrderByPrice=='desc'?'selected':''}}>زیاد به کم</option>
                                    </select>
                                </div>
                            </li>
                            <li class="item">
                                <div class="select_part">
                                    <select name="orderByRate" id="order-by-rate" data-group="orderByRate" class="filter">
                                        <option value="">براساس امتیاز</option>
                                        <option value="asc" {{$selectedOrderByRate=='asc'?'selected':''}}>کم به زیاد</option>
                                        <option value="desc" {{$selectedOrderByRate=='desc'?'selected':''}}>زیاد به کم</option>
                                    </select>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="box_style2">
                        {{--<div class="loading_style1"></div>--}}
                        @if($productDetails->count())
                            <ul class="step no_bullet flex">
                                @include('front.partial.items.products')
                                <li class="gap"></li>
                                <li class="gap"></li>
                                <li class="gap"></li>
                            </ul>
                            @if($hasMorePage)
                                <a data-url="{{route('front.product.index')}}"
                                   href="javascript:void(0)"
                                   class="see_more_style1 btn-load-more-pjax type2">
                                    <span>مشاهده بیشتر</span>
                                </a>
                            @endif
                        @else
                            <div class="noItem_style2 flex">موردی یافت نشد!</div>
                        @endif

                    </div><!-- .box_style2 -->
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')


    <script>

        $(document).ready(function () {
            // filter_style2 click
            $(document.body).on('click','.filter_style2 .category_btn',function(){
                $('.filter_style2 .category_sub').fadeToggle(200);
            });

            $("body").click(function (e) {
                if (!$(e.target).is(".filter_style2 .category_select") && !$(e.target).is(".filter_style2 .category_select *")) {
                    $('.filter_style2 .category_sub').fadeOut(200);
                }
            });//body click

        });//document ready

    </script>

@endsection
