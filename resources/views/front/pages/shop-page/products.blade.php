@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="user_page market_page">
            <div class="container">
                <div class="inner">
                    @include('front.partial.market-page-menu')
                    <div id="pjax-container" class="personal_detail_style2" data-url="{{$shop->path('products')}}">
                        <input id="limit" value="{{$limit}}" type="hidden" name="limit">
                        <input id="view" value="{{$view}}" type="hidden" name="view">
                        <input id="search" value="{{$search}}" type="hidden" name="search">
                        <div class="title_style9 mb30 flex">
                            @if($search)
                                <div class="title search-key">
                                    <span>{{$search}}</span>
                                    <div class="dlt_btn btn-remove-search"><i class="i-cancel"></i></div>
                                </div>
                            @else
                                <div class="title">
                                    <span>لیست محصولات</span>
                                </div>
                            @endif
                            <div class="change_box_style">
                                <ul class="step no_bullet flex">
                                    <li class="item list {{$view=='list'?'active':''}}" data-type=".type2"><i
                                                class="i-list-1"></i></li>
                                    <li class="item box  {{$view=='box'?'active':''}}" data-type=".type2"><i
                                                class="i-exclamation"></i></li>
                                </ul>
                            </div>
                        </div>
                        <div class="filter_style1 mb30">
                            <ul class="step no_bullet flex">
                                <li class="item">
                                    <div class="select_part">
                                        <select name="productCategories" class="filter" data-group="category"
                                                id="#productCategories">
                                            <option value="">بر اساس دسته بندی</option>
                                            @if($selectedCategory)
                                                @php
                                                    $selectedCategory=\App\Models\Specific\ProductCategory::findOrFail($selectedCategory);
                                                    $productCategories=$selectedCategory->children()->orderBy('title')->get();
                                                @endphp
                                                <option value="{{$selectedCategory->parent?$selectedCategory->parent->id:''}}">دسته بندی قبلی</option>
                                            @endif
                                            @foreach($productCategories as $index=>$productCategory)
                                                <option value="{{$productCategory->id}}">{{$productCategory->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="select_part">
                                        <select name="brand" class="filter" data-group="brand"
                                                id="#brand">
                                            <option value="">بر اساس برند</option>
                                            @foreach($brands as $index=>$brand)
                                                <option value="{{$brand->id}}" {{$brand->id==$selectedBrand?'selected':''}}>{{$brand->title}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="select_part">
                                        <select name="orderByPrice" class="filter" id="orderByPrice"
                                                data-group="orderByPrice">
                                            <option value="">بر اساس قیمت</option>
                                            <option {{$selectedOrderByPrice=='asc'?'selected':''}} value="asc">از کم به
                                                زیاد
                                            </option>
                                            <option {{$selectedOrderByPrice=='desc'?'selected':''}} value="desc">از زیاد
                                                به کم
                                            </option>
                                        </select>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="select_part">
                                        <select name="hasDiscount" class="filter" id="hasDiscount"
                                                data-group="hasDiscount">
                                            <option value="">تخفیف</option>
                                            <option {{$selectedHasDiscount=='yes'?'selected':''}} value="yes">تخفیف
                                                دار
                                            </option>
                                            <option {{$selectedHasDiscount=='no'?'selected':''}} value="no">بدون تخفیف
                                            </option>
                                        </select>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        {{--<div class="search_style1 mb30">
                            <form action="" class="flex">
                                <input type="text" placeholder="جستجو کنید...">
                                <button><i class="i-search"></i></button>
                            </form>
                        </div>--}}
                        <div class="box_style2 {{$view=='list'?'type2':''}}">
                            <div class="loading_style1" style="display: none;"></div><!-- LOADING display is none -->
                            @if($productDetails->count())
                                <ul class="step no_bullet flex">
                                    @include('front.partial.items.products')
                                    <li class="gap"></li>
                                    <li class="gap"></li>
                                    <li class="gap"></li>
                                </ul>
                                @if($hasMorePage)
                                    <a data-url="{{$shop->path('products')}}"
                                       href="javascript:void(0)"
                                       class="see_more_style1 btn-load-more-pjax type2">
                                        <span>مشاهده بیشتر</span>
                                    </a>
                                @endif
                            @else
                                <div class="noItem_style2 flex">موردی یافت نشد!</div>
                            @endif
                        </div>

                    </div><!-- personal_detail_style2 -->
                </div><!-- .inner -->
            </div><!-- .container -->
        </div><!-- .user_page -->
    </section>
    @if(canEditShop($shop))
        @include('front.partial.upload-img-profile-shop')
        @include('front.partial.upload-img-shop')
    @endif
    @include('front.partial.shop-page-modals')
@endsection

@section('js')


    <script>

        $(document).ready(function () {

            $(document.body).on('click', '.title_style9 .change_box_style .box', function () {
                $('.box_style2').removeClass('type2');
                $('.title_style9 .change_box_style .list').removeClass('active');
                $(this).addClass('active');
                $('#view').val('box');
            });
            $(document.body).on('click', '.title_style9 .change_box_style .list', function () {
                $('.box_style2').addClass('type2');
                $('.title_style9 .change_box_style .box').removeClass('active');
                $(this).addClass('active');
                $('#view').val('list');
            });

        });//document ready

    </script>

@endsection
