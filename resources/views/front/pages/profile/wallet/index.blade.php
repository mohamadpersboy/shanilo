@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="user_panel">
            <div class="container">
                <div class="inner">
                    <div class='panel_style1 other_page_section'>

                        @include('front.partial.dashboard')
                        <div class='panel_content'>
                            @include('front.partial.parts.wallet-header')
                            <div class="title_style8"><span>اطلاعات حساب و موجودی</span></div>
                            <div class="panel_cart_info flex">
                                <div class="right_part">
                                    <div class="cart_box_style1 flex">

                                        @foreach($wallets as $index=>$wallet)
                                            <div class="item modal_btn btn-wallet"
                                                 data-url="{{route('front.profile.wallet.transactions',$wallet)}}">
                                                <div class="title">کیف پول {{$wallet->shop->title}}</div>
                                                <div class="remain flex"><span>{{showPrice($wallet->total)}}</span>موجودی
                                                </div>
                                                <div class="cart_info flex">
                                                    <div class="info flex">
                                                        <span>{{showPrice($wallet->removeable)}}</span>قابل برداشت
                                                    </div>
                                                    <div class="info flex">
                                                        <span>{{showPrice($wallet->checkouting)}}</span>درحال تسویه
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="item modal_btn btn-wallet"
                                             data-url="{{route('creditlog')}}">
                                            <div class="title">موجودی کاربر</div>
                                            <div class="remain flex"><span>{{showPrice(auth()->user()->credit)}}</span>موجودی
                                            </div>
                                            <div class="cart_info flex">
                                                <div class="info flex">
                                                    <span>{{showPrice(auth()->user()->credit)}}</span>قابل
                                                    برداشت
                                                </div>
                                                <div class="info flex">
                                                    <span>{{$requestCheckout}}</span>درحال
                                                    تسویه
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--clsoe .panel_content-->
                    </div>
                </div><!-- .inner -->
            </div><!-- .container -->
        </div><!-- .user_page -->
    </section>
    @include('front.plugins.wallet-transactions-modal')

    @include('front.partial.upload-img-profile')
@endsection

@section('js')


    <script>

      $(document).ready(function () {

      });//document ready

    </script>

@endsection
