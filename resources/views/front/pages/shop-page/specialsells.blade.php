@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="user_page market_page">
            <div class="container">
                <div class="inner">
                    @include('front.partial.market-page-menu')
                    <div class="personal_detail_style2">

                        <div class="title_style3 flex">
                            <div class="title_part flex">
                                <div class="title">فروش ویژه</div>
                            </div>
                            <a href="javascript:void(0)" title="" rel="nofollow" class="btn_part disabled"><i
                                        class="i-link"></i></a>
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
                                    <a data-url="{{$shop->path('specialSells')}}"
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
            /////////////////////////////////////////////////
            //mix it up
            var containerEl = document.querySelector('.box_style2 ');

            var mixer = mixitup(containerEl);

        });//document ready

    </script>

@endsection
