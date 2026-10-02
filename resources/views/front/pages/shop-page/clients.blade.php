@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="user_page">
            <div class="container">
                <div class="inner">
                    @include('front.partial.market-page-menu')
                    <div class="personal_detail_style2">
                        <div class="title_style5 mb30">لیست مشتریان</div>
                        <div class="user_style1">
                            @if($clients->count())
                                <ul id="client-container" class="step no_bullet flex">
                                    @include('front.partial.items.clients')
                                    <li class="gap before-list"></li>
                                    <li class="gap"></li>
                                    <li class="gap"></li>
                                </ul>
                                @if(hasMorePage($clients))
                                    <a data-url="{{$shop->path('clients')}}"
                                       data-parent="#client-container"
                                       data-item=".before-list"
                                       data-page="1" href="javascript:void(0)"
                                       class="see_more_style1 btn-load-more type2">
                                        <span>مشاهده بیشتر</span>
                                    </a>
                                @endif
                            @else
                                <div class="noItem_style2 flex">موری یافت نشد!</div>
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
