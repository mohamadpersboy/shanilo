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
                            <div class="title_style8"><span>کارت ها</span></div>
                            <div class="panel_cart_info flex">
                                <div class="cart_box_style2 flex">
                                    <ul class="step no_bullet flex">
                                        @foreach($bankCarts as $index=>$bankCart)
                                            <li class="item modal_btn btn-bank-cart" data-url="{{route('front.profile.bankCart.edit',$bankCart)}}">
                                                <div class="shaba_num">{{$bankCart->sheba_no}}</div>
                                                <div class="center_cart flex">
                                                    <div class="cart_name">{{$bankCart->owner}}</div>
                                                    <div class="cart_date">{{$bankCart->expire_year}}/{{$bankCart->expire_month}}</div>
                                                </div>
                                                <div class="cart_num">{{$bankCart->cart_no}}</div>
                                            </li>
                                        @endforeach
                                        <li class="item modal_btn  btn-bank-cart" data-url="{{route('front.profile.bankCart.create')}}">
                                            <a href="#" class="add_cart">افزودن کارت جدید +</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div><!--clsoe .panel_content-->
                    </div>
                </div><!-- .inner -->
            </div><!-- .container -->
        </div><!-- .user_page -->
    </section>
    @include('front.plugins.add_cart_modal')
    @include('front.partial.upload-img-profile')
    <script>
        $(document).ready(function () {
            /////////////////////////////
            //modal style2
            $('.cart_box_style1 .item.modal_btn.cart_modal_btn ').click(function () {
                $('.modal_style1.cart_box_modal').fadeIn(300);
                $('body').css('overflow', 'hidden');
            });
            //modal style2
           /* $('.add_cart_btn.modal_btn ').click(function () {
                $('.modal_style1.add_cart_modal').fadeIn(300);
                $('body').css('overflow', 'hidden');
            });*/
            //////////////////////////////
            // delete click
            $('.box_style8 .item .dlt_btn > i').click(function () {
                $(this).parent('.dlt_btn').addClass('active');
            })
            $('.box_style8 .item .dlt_btn .short_request .btn.no').click(function () {
                $(this).parents('.dlt_btn').removeClass('active');
            })
        });//document ready
    </script>


@endsection
