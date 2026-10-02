@extends('front.master')
@section('section')
    <section class="other_page">
        <div class="user_page market_page user_home_page">
            <div class="container">
                <div class="inner">
                    @include('front.partial.market-page-menu')
                    <div class="personal_detail_style2">
                        @if($specialSuggestions->count())
                            <div class="title_style3 flex">
                                <div class="title_part flex">
                                    <div class="title">پیشنهادات ویژه</div>
                                </div>
                                <a href="{{$shop->path('specialSuggestions')}}" title="" class="btn_part"><i
                                            class="i-link"></i></a>
                            </div>
                            <div class="box_style2">
                                <ul class="step no_bullet flex">
                                    @foreach($specialSuggestions as $index=>$specialSuggestion)
                                        @include('front.partial.items.product',['productDetail'=>$specialSuggestion])
                                    @endforeach

                                    <li class="gap"></li>
                                    <li class="gap"></li>
                                    <li class="gap"></li>
                                </ul>
                            </div>
                        @endif

                        @if($specialSells->count())
                            <div class="title_style3 flex">
                                <div class="title_part flex">
                                    <div class="title">فروش ویژه</div>
                                </div>
                                <a href="{{$shop->path('specialSells')}}" title="" class="btn_part"><i
                                            class="i-link"></i></a>
                            </div>
                            <div class="box_style2">
                                <ul class="step no_bullet flex">
                                    @foreach($specialSells as $index=>$specialSell)
                                        @include('front.partial.items.product',['productDetail'=>$specialSell])
                                    @endforeach

                                    <li class="gap"></li>
                                    <li class="gap"></li>
                                    <li class="gap"></li>
                                </ul>
                            </div>
                        @endif

                        @if($articles->count())
                            <div class="title_style3 flex">
                                <div class="title_part flex">
                                    <div class="title">جدیدترین مجلات</div>
                                </div>
                                <a href="{{$shop->path('articles')}}" title="" class="btn_part"><i class="i-link"></i></a>
                            </div>
                            <div class="box_style7">
                                <ul class="step flex no_bullet">
                                    @foreach($articles as $index=>$article)
                                        @include('front.partial.items.article')
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="title_style3 flex">
                            <div class="title_part flex">
                                <div class="title">جدیدترین محصولات</div>
                            </div>
                            <a href="{{$shop->path('products')}}" title="" class="btn_part"><i class="i-link"></i></a>
                        </div>
                        <div class="box_style2">
                            @if($productDetails->count())
                            <ul id="product-container" class="step no_bullet flex">
                                @include('front.partial.items.products')
                                <li class="gap before-list"></li>
                                <li class="gap"></li>
                                <li class="gap"></li>
                            </ul>
                            @if(hasMorePage($productDetails))
                                <a data-url="{{$shop->path('index')}}"
                                   data-parent="#product-container"
                                   data-item=".before-list"
                                   data-page="1" href="javascript:void(0)"
                                   class="see_more_style1 btn-load-more type2">
                                    <span>مشاهده بیشتر</span>
                                </a>
                            @endif
                           @else
                                <div class="noItem_style2 flex">موردی اضافه نشده!</div>
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


        });//document ready

    </script>

@endsection
