@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="cart_page">
                <div class="container">
                    <div class="inner">
                        @include('front.partial.parts.cart-header')
                        <div class="cart_table_select mt30">
                            <ul class="step no_bullet">
                                @foreach($sendTypes as $index=>$sendType)
                                    <li id="send-type-{{$sendType->id}}" class="item clearfix">
                                        <div class="right_part">
                                            <label class="check_radio_style1">
                                                <input type="radio"
                                                       name="send_type" {{$cartDetail->send_type_id==$sendType->id?'checked':''}}
                                                       class="cart-updater"
                                                       data-url="{{route('front.cart.update-field',$cartDetail)}}"
                                                       data-field="send_type_id"
                                                       data-value="{{$sendType->id}}"
                                                       data-block="#send-type-{{$sendType->id}}">
                                                <span class="icon"></span>
                                            </label>
                                        </div><!-- close .right_part -->
                                        <div class="left_part">
                                            <label for="payment1">
                                                <div class="title">{{$sendType->title}}</div>
                                                <div class="sub_title">{{$sendType->description}}</div>
                                            </label>
                                        </div><!-- close .left_part -->
                                        <div class="price_part">
                                            <label for="payment1">
                                                <div class="title">هزینه ارسال</div>
                                                <div class="price">{{showPrice($cartDetail->calculateTransportPrice($sendType),null,null)}}</div>
                                            </label>
                                        </div><!-- close price_part -->
                                    </li><!-- close .item -->
                                @endforeach
                            </ul><!-- close .step -->
                        </div>
                        <div class="cart_btn_part space_between flex mb30 mt30">
                            <a href="{{route('front.cart.step5',$cartDetail)}}" title="" class="btn_style8 green"><span class="text">مرحله بعدی</span><span class="icon"><i class="i-back"></i></span></a>
                            <a href="{{route('front.cart.step3',$cartDetail)}}" title="" class="btn_style8 green"><span class="text">مرحله قبلی</span><span class="icon"><i class="i-next"></i></span></a>
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