@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="container">
            <div class="inner">
                <div data-url="{{route('front.shop.index')}}" id="pjax-container" class="product_archive">
                    @include('front.partial.parts.archive-top-filter')
                    <div class="filter_style1 type2">
                        <div class="search_style1 type2 mb20" style="display: block;">
                            <input type="text" id="search" value="{{$search}}" name="search" placeholder="جستجو کنید...">
                            <button><i class="i-search"></i>جستجو کنید</button>
                        </div>
                        <ul class="step no_bullet flex">
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
                                    <select name="orderByRate" data-group="orderByRate" class="filter"
                                            id="order-by-rate">
                                        <option value="">براساس امتیاز</option>
                                        <option value="asc" {{$selectedOrderByRate=='asc'?'selected':''}}>کم به زیاد
                                        </option>
                                        <option value="desc" {{$selectedOrderByRate=='desc'?'selected':''}}>زیاد به کم
                                        </option>
                                    </select>
                                </div>
                            </li>
                            <li class="item">
                                <div class="select_part">
                                    <select name="orderByFollower" data-group="orderByFollower" class="filter"
                                            id="order-by-follower">
                                        <option value="">براساس تعداد فالور</option>
                                        <option value="asc" {{$selectedOrderByFollower=='asc'?'selected':''}}>کم به
                                            زیاد
                                        </option>
                                        <option value="desc" {{$selectedOrderByFollower=='desc'?'selected':''}}>زیاد به
                                            کم
                                        </option>
                                    </select>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="box_style3 flex type2">
                        @forelse($shops as $index=>$shop)
                            @include('front.partial.items.shop')
                        @empty
                            <div class="noItem_style2 flex">موردی یافت نشد!</div>
                        @endforelse
                    </div>
                    @if($hasMorePage)
                        <a data-url="{{route('front.shop.index')}}"
                           href="javascript:void(0)"
                           class="see_more_style1 btn-load-more-pjax type2">
                            <span>مشاهده بیشتر</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')


    <script>

        $(document).ready(function () {
            // filter_style2 click
            $(document.body).on('click', '.filter_style2 .category_btn', function () {
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
