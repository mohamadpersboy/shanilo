@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="cart_page">
                <div class="container">
                    <div class="inner">

                        <div class="cart_result flex">
                            @if($order->payment->status=='successful')
                            <div class="success_cart box side_box_shadow">
                                <div class="cart_icon"><i class="i-checked"></i></div>
                                <div class="cart_text">خرید شما با موفقیت انجام و ثبت گردید.</div>
                                <ul class="step cart_step no_bullet">
                                    <li class="item">شماره سفارش {{$order->id}}</li>
                                    <li class="item">شماره مرجع تراکنش {{$order->payment->ref_id}}</li>
                                    <li class="item">شماره پرداخت {{$order->payment->id}}</li>
                                </ul>
                            </div>
                            @else
                            <div class="error_cart box side_box_shadow">
                                <div class="cart_icon"><i class="i-cancel"></i></div>
                                <div class="cart_text">متاسفانه مشکلی در هنگام پرداخت رخ داد!</div>
                            </div>
                            @endif
                        </div>

                    </div><!-- .inner -->
                </div><!-- .container -->
        </div><!-- .user_page -->
    </section>


@endsection

@section('js')


    <script>

        $(document).ready(function () {



        });//document ready

    </script>

@endsection