@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="cart_page">
                <div class="container">
                    <div class="inner">
                        @include('front.partial.parts.cart-header')
                        <div class="cart_register flex">
                            <div class="box">
                                <div class="title_style5">در شانیلو عضو هستید؟</div>
                                <p class="text">برای تکمیل فرایند خود وارد شوید.</p>
                                <div class="btn_style6 sign_in_btn"><span>ورود</span></div>
                            </div>
                            <div class="box">
                                <div class="title_style5">هنوز عضو نشدید؟</div>
                                <p class="text">برای تکمیل فرایند خود ثبت نام کنید.</p>
                                <a href="{{route('front.auth.register.show')}}" title="" class="btn_style6"><span>عضویت</span></a>
                            </div>
                        </div>
                    </div><!-- .inner -->
                </div><!-- .container -->
        </div><!-- .user_page -->
    </section>


@endsection

@section('js')


    <script>

        $(document).ready(function () {
            /////////////////////////////
            $('.cart_page .sign_in_btn').click(function(){
                $('.header_part1 .sign_in_btn .link').trigger('click');
            });

        });//document ready

    </script>

@endsection